<?php

namespace App\Http\Controllers;

use App\Models\Category; // Seguimos usando el modelo Category
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Category::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name'
        ], [
            'name.unique' => 'Ya existe una categoría con este nombre.'
        ]);

        Category::create([
            'name' => $request->name,
            'is_active' => true
        ]);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        $categoria = Category::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $categoria->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría renombrada correctamente.');
    }

    public function destroy($id)
    {
        $categoria = Category::findOrFail($id);

        if($categoria->products()->count() > 0) {
            return back()->with('error', 'No puedes eliminar esta categoría porque tiene platos asociados. Borra o mueve los platos primero.');
        }

        $categoria->delete();
        return back()->with('status', 'Categoría eliminada.');
    }
}
