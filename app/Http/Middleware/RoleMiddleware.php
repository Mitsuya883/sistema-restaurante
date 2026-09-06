<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return $next($request);
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        if ($user->role === 'cocina') {
            return redirect()->route('cocina.index');
        }

        return redirect()->route('dashboard');
    }
}
