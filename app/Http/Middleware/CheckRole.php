<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // Jika belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Jika user tidak punya role atau role tidak cocok
        if (!$user->inRoles($roles)) {
            abort(403, 'Tidak ada akses!');
        }

        return $next($request);
    }
}
