<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário não estiver logado OU não for admin, volta pra home
        if (!$request->user() || !$request->user()->isAdmin()) {
            return redirect('/')->with('error', 'Acesso negado. Apenas para administradores.');
        }

        return $next($request);
    }
}