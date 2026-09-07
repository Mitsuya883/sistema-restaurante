<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
{
    $mesas = Mesa::all();

    $disponibles = $mesas->where('estado', 'disponible')->count(); // o 'libre'
    $ocupadas = $mesas->where('estado', 'ocupada')->count();
    $reservadas = $mesas->where('estado', 'reservada')->count();
    $total = $mesas->count();

    return view('dashboard', compact('mesas', 'disponibles', 'ocupadas', 'reservadas', 'total'));
}

    public function create()
    {
        return view('admin.mesas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
        ]);

        $mesa = Table::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => 'libre'
        ]);

        $mesa->code = 'ME' . str_pad($mesa->id, 2, '0', STR_PAD_LEFT);
        $mesa->save();

        return redirect()->route('admin.mesas.index')->with('status', 'Mesa creada con código ' . $mesa->code);
    }

    public function edit($id)
    {
        $mesa = Table::findOrFail($id);
        return view('admin.mesas.edit', compact('mesa'));
    }

    public function update(Request $request, $id)
    {
        $mesa = Table::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:libre,ocupada,reservada'
        ]);

        $mesa->update($request->all());

        return redirect()->route('admin.mesas.index')->with('status', 'Mesa actualizada correctamente.');
    }

    public function destroy($id)
    {
        $mesa = Table::findOrFail($id);

        if ($mesa->status == 'ocupada') {
            return back()->with('error', 'No puedes eliminar una mesa que está siendo atendida.');
        }

        $mesa->delete();
        return back()->with('status', 'Mesa eliminada.');
    }
}
