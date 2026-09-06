<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    public function index()
    {
        $repartidores = Repartidor::all();
        return view('admin.repartidores.index', compact('repartidores'));
    }

    public function create()
    {
        return view('admin.repartidores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|numeric|digits:9',
            'placa_vehiculo' => 'nullable|string|max:10',
        ]);

        Repartidor::create($request->all());

        return redirect()->route('admin.repartidores.index')->with('status', 'Repartidor registrado correctamente.');
    }

    public function edit($id)
    {
        $repartidor = Repartidor::findOrFail($id);
        return view('admin.repartidores.edit', compact('repartidor'));
    }

    public function update(Request $request, $id)
    {
        $repartidor = Repartidor::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|numeric|digits:9',
            'placa_vehiculo' => 'nullable|string|max:10',
            'activo' => 'required|boolean'
        ]);

        $repartidor->update($request->all());

        return redirect()->route('admin.repartidores.index')->with('status', 'Datos del repartidor actualizados.');
    }

    public function destroy($id)
    {
        $repartidor = Repartidor::findOrFail($id);
        $repartidor->delete();

        return back()->with('status', 'Repartidor eliminado del sistema.');
    }
}
