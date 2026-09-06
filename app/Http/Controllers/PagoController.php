<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    public function show(Table $table)
    {
        $order = Order::with('details.product')
            ->where('table_id', $table->id)
            ->where('status', '!=', 'paid')
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Esta mesa no tiene cuenta pendiente.');
        }

        return view('pagos.show', compact('table', 'order'));
    }

    public function store(Request $request)
    {

        $rules = [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,card,yape',
            'tipo_comprobante' => 'required|in:ticket,boleta,factura',
        ];

        if ($request->tipo_comprobante === 'boleta') {
            $rules['nro_documento'] = 'required|digits:8';
            $rules['razon_social'] = 'required|string';
        } elseif ($request->tipo_comprobante === 'factura') {
            $rules['nro_documento'] = 'required|digits:11';
            $rules['razon_social'] = 'required|string';
            $rules['direccion_fiscal'] = 'required|string';
        }

        $request->validate($rules);
        $order = Order::findOrFail($request->order_id);

        DB::transaction(function () use ($order, $request) {
            $order->status = 'paid';
            $order->payment_method = $request->payment_method;
            $order->tipo_comprobante = $request->tipo_comprobante;
            $order->nro_documento = $request->nro_documento;
            $order->razon_social = $request->razon_social;
            $order->direccion_fiscal = $request->direccion_fiscal;
            $order->save();
            if ($order->table_id) {
                $table = Table::find($order->table_id);
                $table->status = 'libre';
                $table->save();
            }
        });

        $total = $order->total;
        $subtotal = $total / 1.18;
        $igv = $total - $subtotal;
        
        $pdf = Pdf::loadView('pdf.ticket', compact('order', 'subtotal', 'igv'));
        $pdf->setPaper([0, 0, 220, 1000], 'portrait');
        return $pdf->stream('comprobante-'.$order->id.'.pdf');
    }

    public function exito($id)
    {
        $payment = Payment::with('order.table')->findOrFail($id);
        return view('pagos.exito', compact('payment'));
    }

    public function voucher($id)
    {
        $payment = Payment::with(['order.details.product', 'order.user', 'order.table'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.voucher', compact('payment'));
        return $pdf->stream('comprobante-' . $id . '.pdf');
    }
}
