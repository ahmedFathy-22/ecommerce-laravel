<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    // index(), show(), updateStatus(), export() محمية بالفعل
    // بـ middleware(['auth', 'admin']) في routes/web.php، يبقى مفيش
    // احتياج لـ ownership check جواهم — أي أدمن يقدر يشوف أي أوردر.

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'user')
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated ✅');
    }

    /**
     * Route بتاعتها جوا middleware('auth') بس (مش admin)،
     * يعني أي يوزر مسجل دخول يقدر يوصلها بالـ URL لو عرف order id.
     * لازم نتأكد إنه صاحب الأوردر، أو إنه admin.
     *
     * ⚠️ غيّر `is_admin` لو عمود الأدمن عندك اسمه مختلف
     * (مثلاً role == 'admin' أو is_admin == 1).
     */
    public function invoice(Order $order)
    {
        $isOwner = $order->user_id === auth()->id();
        $isAdmin = (bool) (auth()->user()->is_admin ?? false);

        abort_unless(
            $isOwner || $isAdmin,
            403,
            'غير مسموح لك بعرض فاتورة هذا الطلب.'
        );

        $pdf = Pdf::loadView('invoice', compact('order'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
