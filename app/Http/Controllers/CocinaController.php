<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function index()
    {
        $pedidos = Order::with(['details.product', 'table', 'user'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('cocina.index', compact('pedidos'));
    }

    public function marcarListo($id)
    {
        $pedido = Order::findOrFail($id);
        $pedido->status = 'ready';
        $pedido->save();

        return redirect()->route('cocina.index')->with('status', '¡Pedido marcado como listo!');
    }
}
