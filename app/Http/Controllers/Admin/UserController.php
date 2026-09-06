<?php

namespace App\Http\Controllers\Admin;

use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,mozo,cocina'],
        ]);

        $generatedPassword = Str::password(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($generatedPassword),
            'is_active' => true,
        ]);

        try {
            Mail::to($user->email)->send(new UserCredentials($user, $generatedPassword));
        } catch (\Exception $e) {
            dd("ERROR DE CORREO: " . $e->getMessage());
        }
        return redirect()->route('admin.users.index')
            ->with('status', 'Usuario creado y notificado por correo. La contraseña temporal es: ' . $generatedPassword);
    }

    public function toggleAccess($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'Reactivado' : 'Desactivado';
        return back()->with('status', "Usuario $status correctamente.");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,mozo,cocina'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.users.index')
            ->with('status', 'Usuario actualizado correctamente.');
    }
}
