<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
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
        $order = Order::with(
            'items.product',
            'user'
        )->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);
        return back()->with(
            'success',
            'Status updated ✅'
        );
    }

    public function invoice(Order $order)
    {
        $pdf = Pdf::loadView(
            'invoice',
            compact('order')
        );
        return $pdf->download(
            'invoice-' . $order->id . '.pdf'
        );
    }

    public function export()
    {
        return Excel::download(
            new OrdersExport,
            'orders.xlsx'
        );
    }
}
