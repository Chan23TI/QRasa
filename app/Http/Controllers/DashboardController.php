<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $baseQuery = $user->pesans();

        // 1. KPI Cards Data
        $totalMenus = $user->menus()->count();
        $revenueToday = (clone $baseQuery)->whereDate('created_at', Carbon::today())->sum('total');
        $ordersThisMonth = (clone $baseQuery)->whereMonth('created_at', Carbon::now()->month)->count();
        $averageOrderValue = (clone $baseQuery)->whereMonth('created_at', Carbon::now()->month)->avg('total');

        // 2. Top Selling Menus
        $topSellingMenus = Menu::select('menus.nama', DB::raw('SUM(menu_pesan.quantity) as total_quantity'))
            ->join('menu_pesan', 'menus.id', '=', 'menu_pesan.menu_id')
            ->join('pesans', 'menu_pesan.pesan_id', '=', 'pesans.id')
            ->where('menus.user_id', $user->id)
            ->where('pesans.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('menus.id', 'menus.nama')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // 3. Low Stock Warning
        $lowStockMenus = $user->menus()->where('stok', '<', 10)->orderBy('stok', 'asc')->get();

        // 4. Recent Orders
        $pesanans = $user->pesans()->with('user')->latest()->paginate(5);

        // 5. Chart Data with Date Filter
        $period = $request->input('period', 'last_7_days');
        $startDate = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                break;
            case 'last_30_days':
                $startDate = Carbon::now()->subDays(30);
                break;
            case 'last_7_days':
            default:
                $startDate = Carbon::now()->subDays(7);
                break;
        }

        $salesData = $user->pesans()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_sales'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')->orderBy('date', 'ASC')->get();

        $chartData = [
            'labels' => $salesData->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d')),
            'data' => $salesData->pluck('total_sales'),
        ];

        return view('dashboard', compact(
            'pesanans', 
            'chartData',
            'period',
            'revenueToday',
            'ordersThisMonth',
            'averageOrderValue',
            'topSellingMenus',
            'lowStockMenus',
            'totalMenus'
        ));
    }
}