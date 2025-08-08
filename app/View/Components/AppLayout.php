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

        if ($user) {
            // Only fetch low stock menus if the user is authenticated and has menus
            $lowStockMenus = $user->menus()->where('stok', '<', 10)->orderBy('stok', 'asc')->get();
        }

        return view('layouts.app', compact('lowStockMenus'));
    }
}
