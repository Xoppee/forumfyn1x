<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Acesso não autorizado.');
        }

        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('home')->with('error', 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
