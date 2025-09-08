<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class AdminStockNotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Hanya untuk admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Ambil semua menu dengan stok kurang dari 10
            $lowStockMenus = Menu::where('stok', '<', 10)->orderBy('stok', 'asc')->get();
            
            // Bagikan ke view
            view()->share('adminLowStockMenus', $lowStockMenus);
        }
        
        return $response;
    }
}
