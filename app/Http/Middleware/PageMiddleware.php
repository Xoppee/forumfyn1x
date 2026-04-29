<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pages; // Supondo que sua model seja Page
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pega o slug ou ID da rota
        $page = Pages::where('slug', $request->route('page'))->first(); // Ajuste conforme sua rota
        // Se a página for um rascunho (is_draft = true)
        if ($page && !$page->is_published) {
            
            // Verifica se o usuário é o Admin (Nível 99) 
            // ou se ele é o dono da página
            $user = $request->user();
            if (($user->role == 'user')) {
                // Se não for autorizado, manda pra index com erro ou 404
                abort(404); // Melhor usar 404 para nem admitir que a página existe
            }
        }

        return $next($request);
    }
}
