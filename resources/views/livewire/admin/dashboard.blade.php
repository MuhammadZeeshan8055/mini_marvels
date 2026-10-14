<div>
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Orders</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $orderCount }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $pendingOrders }} pending</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Products</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $productCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Categories</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $categoryCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Users</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $userCount }}</p>
        </div>
    </div>

    <div class="mt-6 grid lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-plum">Recent orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-sm text-plum hover:underline">View all</a>
            </div>
            @forelse ($recentOrders as $order)
                <div class="flex items-center justify-between gap-3 py-2 border-b border-slate-50 last:border-0 text-sm">
                    <div>
                        <p class="font-medium">{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-500">{{ $order->customer_name }} · {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">Rs {{ number_format($order->total, 0) }}</p>
                        <p class="text-xs text-slate-500">{{ $order->statusLabel() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">No orders yet.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-plum mb-2">Quick links</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.orders') }}" class="rounded-full bg-plum text-white px-4 py-2 text-sm">Manage Orders</a>
                <a href="{{ route('admin.products') }}" class="rounded-full bg-cream text-plum px-4 py-2 text-sm border border-plum/20">Manage Products</a>
                <a href="{{ route('admin.categories') }}" class="rounded-full bg-cream text-plum px-4 py-2 text-sm border border-plum/20">Manage Categories</a>
            </div>
        </div>
    </div>
</div>
