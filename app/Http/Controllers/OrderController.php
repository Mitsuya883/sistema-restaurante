<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Repartidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('dashboard', compact('tables'));
    }

    public function show(Table $table)
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true)->where('disponible_hoy', true);
        }])->get();

        $table->load(['orders' => function ($q) {
            $q->where('status', '!=', 'paid')
                ->with('orderDetails.product');
        }]);

        return view('orders.show', compact('table', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'table_id' => 'nullable|exists:tables,id',
            'client_name' => 'nullable|string',
            'client_address' => 'nullable|string',
            'client_phone' => 'nullable|string',
            'cart_data' => 'required',
            'total' => 'required|numeric',
            'tipo_comprobante' => 'required|in:ticket,boleta,factura',
            'delivery_reference' => 'nullable|string'
        ];

        if (!$request->has('tipo_comprobante')) {
            $request->merge(['tipo_comprobante' => 'ticket']);
        }

        if ($request->tipo_comprobante === 'boleta') {
            $rules['nro_documento'] = 'nullable|digits:8';
            $rules['razon_social'] = 'required|string';
        } elseif ($request->tipo_comprobante === 'factura') {
            $rules['nro_documento'] = 'required|digits:11';
            $rules['razon_social'] = 'required|string';
            $rules['direccion_fiscal'] = 'required|string';
        }

        $request->validate($rules);
        $cart = json_decode($request->cart_data, true);

        if (empty($cart)) {
            return back()->with('error', 'El carrito está vacío');
        }

        DB::transaction(function () use ($request, $cart) {

            $type = $request->table_id ? 'dine_in' : 'delivery';

            $order = Order::create([
                'user_id' => Auth::id(),
                'table_id' => $request->table_id,
                'status' => 'pending',
                'total' => $request->total,
                'order_type' => $type,
                'tipo_comprobante' => $request->tipo_comprobante,
                'nro_documento' => $request->nro_documento,
                'razon_social' => $request->razon_social,
                'direccion_fiscal' => $request->direccion_fiscal,
                'delivery_reference' => $request->delivery_reference,
            ]);
            foreach ($cart as $item) {
                $order->orderDetails()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'note' => $item['note'] ?? null,
                ]);
            }
            if ($type === 'delivery') {
                $customer = \App\Models\Customer::firstOrCreate(
                    ['phone' => $request->client_phone],
                    ['name' => $request->client_name, 'address' => $request->client_address]
                );
                $order->customer_id = $customer->id;
                $order->save();
            }
            if ($request->table_id) {
                $table = \App\Models\Table::find($request->table_id);
                $table->status = 'ocupada';
                $table->save();
            }
        });

        return redirect()->route('dashboard')->with('status', '¡Pedido registrado correctamente!');
    }

    public function createDelivery()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();

        return view('orders.delivery', compact('categories'));
    }

    public function dispatch()
    {
        $pedidosPendientes = Order::where('order_type', 'delivery')
            ->where('status', '!=', 'paid')
            ->with('repartidor', 'customer')
            ->latest()
            ->get();

        $repartidores = Repartidor::where('activo', true)->get();

        return view('orders.dispatch', compact('pedidosPendientes', 'repartidores'));
    }

    public function assignDriver(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->repartidor_id = $request->repartidor_id;
        $order->status = 'en_camino';
        $order->save();

        return back()->with('status', 'Pedido asignado a ' . $order->repartidor->nombre);
    }

    public function cobrarOrden(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'payment_method' => 'required|string|in:efectivo,yape,tarjeta'
        ]);

        DB::transaction(function () use ($order, $request) {

            $order->status = 'paid';
            $order->payment_method = $request->payment_method;
            $order->save();

            if ($order->table_id) {
                $mesa = $order->table;
                $mesa->status = 'libre';
                $mesa->save();
            }

            if ($order->order_type == 'delivery' && $order->repartidor_id) {
            }
        });

        return back()->with('status', '¡Pago registrado correctamente! La orden #' . $order->id . ' ha sido cerrada.');
    }
}
