<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $user = Auth::user();
        $lowStockMenus = collect(); // Default to empty collection
        $adminLowStockMenus = collect(); // Default to empty collection

        if ($user) {
            // Fetch low stock menus for all roles (all menus now)
            $lowStockMenus = Menu::where('stok', '<', 10)->orderBy('stok', 'asc')->get();
            
            // For admin, fetch all low stock menus from all users (same as lowStockMenus now)
            if ($user->role === 'admin') {
                $adminLowStockMenus = Menu::where('stok', '<', 10)->orderBy('stok', 'asc')->get();
            }
        }

        return view('layouts.app', compact('lowStockMenus', 'adminLowStockMenus'));
    }
}
