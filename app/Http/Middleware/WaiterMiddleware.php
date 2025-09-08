<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WaiterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role == 'waiter') {
            return $next($request);
        }

        // Jika pengguna telah login tetapi bukan waiter, arahkan ke halaman pesan
        if (auth()->check()) {
            return redirect()->route('pesan.index');
        }

        abort(403, 'Unauthorized action.');
    }
}
