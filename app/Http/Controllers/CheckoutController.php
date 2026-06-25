<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderSuccessMail;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function index()
    {
        [$products, $cart] = $this->getCartProducts();

        return view('frontend.orders.checkout', compact('products', 'cart'));
    }

    public function payment()
    {
        [$products, $cart] = $this->getCartProducts();

        return view('frontend.orders.payment', compact('products', 'cart'));
    }

    public function store(Request $request)
    {
        session()->put('shipping_data', [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('payment');
    }

    public function stripe(Request $request)
    {
        [$products, $cart] = $this->getCartProducts();

        if ($products->isEmpty()) {
            return redirect()->route('cart')->with('error', 'السلة فاضية، مينفعش تكمل دفع.');
        }

        $shippingData = session()->get('shipping_data', [
            'name' => auth()->user()->name,
            'address' => 'Waiting Address',
            'phone' => '000000000',
        ]);

        $order = $this->createOrderFromCart($products, $cart, $shippingData);

        $lineItems = [];

        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => (int) round($product->price * 100),
                ],
                'quantity' => $cart[$product->id],
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // مهم: لازم نمرر order_id في metadata عشان الـ webhook يقدر
        // يربط Stripe event بالأوردر بتاعنا بدون ما يعتمد على success_url
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
            ],
            'success_url' => route('payment.success', $order->id),
            'cancel_url' => route('cart'),
        ]);

        // نحفظ session id على الأوردر، مفيد للـ webhook ولأي تتبع
        $order->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    /**
     * ده فقط لعرض صفحة "تم الدفع بنجاح" للمستخدم.
     * ⚠️ ماعدناش بنغيّر هنا payment_status ولا بنبعت الإيميل —
     * ده بقى مسؤولية webhook() الوحيدة، لأنها المصدر الموثوق.
     * هنا برضو لازم نتأكد إن الأوردر ده بتاع اليوزر الحالي.
     */
    public function success(Order $order)
    {
        abort_unless(
            $order->user_id === auth()->id(),
            403,
            'غير مسموح لك بعرض هذا الطلب.'
        );

        return view('frontend.orders.payment-success', compact('order'));
    }

    /**
     * Stripe Webhook — المصدر الوحيد الموثوق لتغيير حالة الدفع.
     * - لازم يكون في routes/web.php برّه middleware('auth')
     *   ومستثنى من CSRF (شوف bootstrap/app.php).
     * - بيتأكد من التوقيع (Stripe-Signature) قبل أي تعامل مع البيانات.
     */
    public function webhook(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook: invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', Response::HTTP_BAD_REQUEST);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook: invalid signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $orderId = $session->metadata->order_id ?? null;
            $order = $orderId ? Order::find($orderId) : null;

            if (! $order) {
                Log::warning('Stripe webhook: order not found', ['order_id' => $orderId]);
                return response('Order not found', Response::HTTP_OK); // 200 عشان Stripe ما يعيدش المحاولة على حاجة مش هتتحل
            }

            // idempotency: لو الأوردر اتعالج قبل كده، ما نكررش الإيميل/التحديث
            if ($order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);

                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)
                        ->send(new OrderSuccessMail($order));
                }
            }
        }

        return response('Webhook handled', Response::HTTP_OK);
    }

    private function getCartProducts(): array
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn('id', array_keys($cart))
            ->get();

        return [$products, $cart];
    }

    private function calculateTotal($products, array $cart): float
    {
        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        if (session()->has('coupon')) {
            $coupon = session('coupon');

            if ($coupon['type'] === 'percent') {
                $total -= ($total * $coupon['discount']) / 100;
            } else {
                $total -= $coupon['discount'];
            }
        }

        return max($total, 0);
    }

    private function createOrderFromCart($products, array $cart, array $shippingData): Order
    {
        $total = $this->calculateTotal($products, $cart);

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $shippingData['name'],
            'address' => $shippingData['address'],
            'phone' => $shippingData['phone'],
            'total' => $total,
            'payment' => 'stripe',
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cart[$product->id],
                'price' => $product->price,
            ]);
        }

        // مهم: لازم تتأكد إن session()->forget(['cart','coupon','shipping_data'])
        // بقت هنا أو بعد ما الأوردر يتعمل بنجاح، مش جوا success() القديمة —
        // وإلا لو اليوزر رجع لـ checkout تاني، الكارت لسه موجود وممكن يعمل أوردر تاني بالغلط.
        session()->forget(['cart', 'coupon', 'shipping_data']);

        return $order;
    }
}
