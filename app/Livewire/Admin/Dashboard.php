<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $recentOrders = Order::query()
            ->latest()
            ->take(5)
            ->get();

        $revenue = (float) Order::query()
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $revenueThisMonth = (float) Order::query()
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total');

        $ordersToday = Order::query()
            ->whereDate('created_at', today())
            ->count();

        return view('livewire.admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'userCount' => User::count(),
            'orderCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'revenue' => $revenue,
            'revenueThisMonth' => $revenueThisMonth,
            'ordersToday' => $ordersToday,
            'lowStockCount' => Product::where('stock', '<=', 5)->where('is_active', true)->count(),
            'recentOrders' => $recentOrders,
            'statusCounts' => $this->statusCounts(),
            'chart' => $this->chartData(),
        ])->layout('layouts.admin', [
            'title' => 'Dashboard',
        ]);
    }

    /** @return array<string, int> */
    private function statusCounts(): array
    {
        $counts = Order::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $result = [];

        foreach (Order::STATUSES as $status) {
            $result[$status] = (int) ($counts[$status] ?? 0);
        }

        return $result;
    }

    /** @return array{labels: list<string>, orders: list<int>, revenue: list<float>} */
    private function chartData(): array
    {
        $start = now()->subDays(6)->startOfDay();
        $end = now()->endOfDay();

        $rows = Order::query()
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as orders, COALESCE(SUM(total), 0) as revenue')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy(fn ($row) => Carbon::parse($row->day)->toDateString());

        $labels = [];
        $orders = [];
        $revenue = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $key = $date->toDateString();
            $labels[] = $date->format('D');
            $orders[] = (int) ($rows[$key]->orders ?? 0);
            $revenue[] = round((float) ($rows[$key]->revenue ?? 0), 0);
        }

        return [
            'labels' => $labels,
            'orders' => $orders,
            'revenue' => $revenue,
        ];
    }
}
