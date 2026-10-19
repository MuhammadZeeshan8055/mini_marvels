<div class="space-y-6">
    {{-- Stat cards --}}
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Orders</p>
                    <p class="text-3xl font-semibold text-plum mt-1">{{ $orderCount }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $pendingOrders }} pending · {{ $ordersToday }} today</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-plum/10 text-plum" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16v12H4zM8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Revenue</p>
                    <p class="text-3xl font-semibold text-plum mt-1">Rs {{ number_format($revenue, 0) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Rs {{ number_format($revenueThisMonth, 0) }} this month</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M7 8h7a3 3 0 0 1 0 6H9a3 3 0 0 0 0 6h8"/></svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Products</p>
                    <p class="text-3xl font-semibold text-plum mt-1">{{ $productCount }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $categoryCount }} categories · {{ $lowStockCount }} low stock</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 3 7.5 12 12l9-4.5L12 3zM3 12l9 4.5L21 12M3 16.5l9 4.5 9-4.5"/></svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Customers</p>
                    <p class="text-3xl font-semibold text-plum mt-1">{{ $userCount }}</p>
                    <p class="text-xs text-slate-400 mt-1">Registered accounts</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3"/><path d="M3 19c1.2-3 3.5-4.5 6-4.5S16.8 16 18 19"/><circle cx="17" cy="9" r="2.5"/><path d="M19.5 14.5c1.2.8 2.1 2.1 2.5 4.5"/></svg>
                </span>
            </div>
        </div>
    </div>

    {{-- Chart + status --}}
    <div class="grid xl:grid-cols-[1.6fr_1fr] gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="font-semibold text-plum">Sales overview</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Orders and revenue for the last 7 days</p>
                </div>
            </div>

            <div class="h-64">
                <canvas
                    id="dashboardSalesChart"
                    aria-label="Sales chart"
                    data-labels='@json($chart['labels'])'
                    data-orders='@json($chart['orders'])'
                    data-revenue='@json($chart['revenue'])'
                ></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-plum mb-1">Order status</h2>
            <p class="text-xs text-slate-500 mb-4">Breakdown of all orders</p>

            <div class="space-y-3">
                @php
                    $statusStyles = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'confirmed' => 'bg-sky-100 text-sky-700',
                        'processing' => 'bg-violet-100 text-violet-700',
                        'shipped' => 'bg-indigo-100 text-indigo-700',
                        'delivered' => 'bg-emerald-100 text-emerald-700',
                        'cancelled' => 'bg-rose-100 text-rose-700',
                    ];
                    $maxStatus = max(1, ...array_values($statusCounts));
                @endphp

                @foreach ($statusCounts as $status => $count)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="inline-flex items-center gap-2">
                                <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $statusStyles[$status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </span>
                            <span class="font-medium text-slate-700">{{ $count }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div
                                class="h-full rounded-full bg-plum/70"
                                style="width: {{ round(($count / $maxStatus) * 100) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500 mb-2">Quick links</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.orders') }}" class="rounded-full bg-plum text-white px-3.5 py-1.5 text-sm">Orders</a>
                    <a href="{{ route('admin.products') }}" class="rounded-full bg-cream text-plum px-3.5 py-1.5 text-sm border border-plum/20">Products</a>
                    <a href="{{ route('admin.categories') }}" class="rounded-full bg-cream text-plum px-3.5 py-1.5 text-sm border border-plum/20">Categories</a>
                    <a href="{{ route('admin.homepage') }}" class="rounded-full bg-cream text-plum px-3.5 py-1.5 text-sm border border-plum/20">Homepage</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent orders --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold text-plum">Recent orders</h2>
                <p class="text-xs text-slate-500 mt-0.5">Latest customer purchases</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-sm text-plum hover:underline">View all</a>
        </div>

        <div class="divide-y divide-slate-50">
            @forelse ($recentOrders as $order)
                <div class="flex items-center justify-between gap-3 py-3 text-sm">
                    <div class="min-w-0">
                        <p class="font-medium truncate">{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $order->customer_name }} · {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-medium">Rs {{ number_format($order->total, 0) }}</p>
                        <p class="text-xs text-slate-500">{{ $order->statusLabel() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500 py-6 text-center">No orders yet.</p>
            @endforelse
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
@endassets

@script
<script>
    const canvas = document.getElementById('dashboardSalesChart');

    if (canvas && window.Chart) {
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const orders = JSON.parse(canvas.dataset.orders || '[]');
        const revenue = JSON.parse(canvas.dataset.revenue || '[]');

        if (canvas._mmChart) {
            canvas._mmChart.destroy();
        }

        canvas._mmChart = new window.Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Revenue (Rs)',
                        data: revenue,
                        borderColor: '#5D3E9F',
                        backgroundColor: 'rgba(93, 62, 159, 0.12)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true,
                        yAxisID: 'y1',
                        pointRadius: 3,
                        pointBackgroundColor: '#5D3E9F',
                    },
                    {
                        type: 'bar',
                        label: 'Orders',
                        data: orders,
                        backgroundColor: 'rgba(247, 168, 197, 0.85)',
                        borderRadius: 8,
                        yAxisID: 'y',
                        maxBarThickness: 28,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            font: { family: 'Fredoka, system-ui, sans-serif', size: 12 },
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label(ctx) {
                                if (ctx.dataset.label?.includes('Revenue')) {
                                    return ` Revenue: Rs ${Number(ctx.raw || 0).toLocaleString()}`;
                                }
                                return ` Orders: ${ctx.raw}`;
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Fredoka, system-ui, sans-serif' } },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { family: 'Fredoka, system-ui, sans-serif' },
                        },
                        grid: { color: 'rgba(148, 163, 184, 0.2)' },
                        title: { display: true, text: 'Orders', color: '#94a3b8', font: { size: 11 } },
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            callback: (value) => 'Rs ' + Number(value).toLocaleString(),
                            font: { family: 'Fredoka, system-ui, sans-serif' },
                        },
                        title: { display: true, text: 'Revenue', color: '#94a3b8', font: { size: 11 } },
                    },
                },
            },
        });
    }
</script>
@endscript
