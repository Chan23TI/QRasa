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
        
        // Jika pengguna memiliki role chef, waiter, atau cashier, arahkan ke halaman pesan
        if (in_array($user->role, ['chef', 'waiter', 'cashier'])) {
            // Redirect ke halaman pesan untuk role chef, waiter, atau cashier
            return redirect()->route('pesan.index');
        }
        
        $baseQuery = $user->pesans();

        // 1. KPI Cards Data
        $totalMenus = Menu::count();
        
        $period = $request->input('period', 'today');

        $revenueQuery = (clone $baseQuery);
        $ordersQuery = (clone $baseQuery);

        switch ($period) {
            case 'this_week':
                $revenueQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $ordersQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $revenueQuery->whereMonth('created_at', Carbon::now()->month);
                $ordersQuery->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'today':
            default:
                $revenueQuery->whereDate('created_at', Carbon::today());
                $ordersQuery->whereDate('created_at', Carbon::today());
                break;
        }

        $revenue = $revenueQuery->sum('total');
        $orders = $ordersQuery->count();

        $averageOrderValue = (clone $baseQuery)->whereMonth('created_at', Carbon::now()->month)->avg('total');

        // 2. Top Selling Menus
        $topSellingMenus = Menu::select('menus.nama', DB::raw('SUM(menu_pesan.quantity) as total_quantity'))
            ->join('menu_pesan', 'menus.id', '=', 'menu_pesan.menu_id')
            ->join('pesans', 'menu_pesan.pesan_id', '=', 'pesans.id')
            ->where('pesans.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('menus.id', 'menus.nama')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // 3. Low Stock Warning
        $lowStockMenus = Menu::where('stok', '<', 10)->orderBy('stok', 'asc')->get();
        
        // Untuk admin, ambil semua menu dengan stok rendah (sama dengan lowStockMenus untuk semua role)
        $adminLowStockMenus = Menu::where('stok', '<', 10)->orderBy('stok', 'asc')->get();

        // 4. Recent Orders
        $pesanans = $user->pesans()->with('user')->latest()->paginate(5);

        // 5. Chart Data with Date Filter
        $chartPeriod = $request->input('chart_period', 'this_month');
        $labels = [];
        $data = [];

        switch ($chartPeriod) {
            case 'this_year':
                $salesData = $user->pesans()
                    ->select(
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw('SUM(total) as total_sales')
                    )
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('month')
                    ->orderBy('month', 'ASC')
                    ->pluck('total_sales', 'month')->all();

                for ($i = 1; $i <= 12; $i++) {
                    $labels[] = Carbon::create()->month($i)->format('M');
                    $data[] = $salesData[$i] ?? 0;
                }
                break;

            case 'last_30_days':
                $startDate = Carbon::now()->subDays(29)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $salesData = $user->pesans()
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total) as total_sales')
                    )
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->pluck('total_sales', 'date')->all();

                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $data[] = $salesData[$date->format('Y-m-d')] ?? 0;
                }
                break;
            
            case 'last_7_days':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $salesData = $user->pesans()
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total) as total_sales')
                    )
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->pluck('total_sales', 'date')->all();

                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $data[] = $salesData[$date->format('Y-m-d')] ?? 0;
                }
                break;

            case 'this_month':
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $salesData = $user->pesans()
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total) as total_sales')
                    )
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->pluck('total_sales', 'date')->all();

                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                    $labels[] = $date->format('d');
                    $data[] = $salesData[$date->format('Y-m-d')] ?? 0;
                }
                break;
        }

        $chartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        return view('dashboard', compact(
            'pesanans', 
            'chartData',
            'period',
            'revenue',
            'orders',
            'averageOrderValue',
            'topSellingMenus',
            'lowStockMenus',
            'adminLowStockMenus',
            'totalMenus',
            'chartPeriod'
        ));
    }
}
