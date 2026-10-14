<div>
    @if ($viewing)
        <div class="mb-4">
            <button type="button" wire:click="closeView" class="text-sm text-plum hover:underline">&larr; Back to orders</button>
        </div>

        <div class="grid lg:grid-cols-[1fr_320px] gap-4">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-plum">{{ $viewing->order_number }}</h2>
                        <p class="text-sm text-slate-500 mt-1">Placed {{ $viewing->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                        {{ $viewing->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $viewing->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ ! in_array($viewing->status, ['cancelled', 'delivered'], true) ? 'bg-amber-100 text-amber-800' : '' }}
                    ">{{ $viewing->statusLabel() }}</span>
                </div>

                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <h3 class="font-semibold text-slate-700 mb-2">Customer</h3>
                        <p>{{ $viewing->customer_name }}</p>
                        <p class="text-slate-600">{{ $viewing->customer_email }}</p>
                        <p class="text-slate-600">{{ $viewing->customer_phone }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-700 mb-2">Shipping address</h3>
                        <p class="whitespace-pre-line text-slate-600">{{ $viewing->shipping_address }}</p>
                    </div>
                </div>

                @if ($viewing->note)
                    <div class="text-sm">
                        <h3 class="font-semibold text-slate-700 mb-1">Order note</h3>
                        <p class="text-slate-600">{{ $viewing->note }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="font-semibold text-slate-700 mb-3">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b">
                                    <th class="pb-2 font-medium">Product</th>
                                    <th class="pb-2 font-medium">Price</th>
                                    <th class="pb-2 font-medium">Qty</th>
                                    <th class="pb-2 font-medium text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewing->items as $item)
                                    <tr class="border-b border-slate-50" wire:key="order-item-{{ $item->id }}">
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $item->imageUrl() }}" alt="" class="w-12 h-12 rounded-lg object-cover bg-slate-50" width="48" height="48">
                                                <div>
                                                    <p class="font-medium">{{ $item->product_name }}</p>
                                                    @if ($item->color)
                                                        <p class="text-xs text-slate-500">Color: {{ $item->color }}</p>
                                                    @endif
                                                    @if ($item->product_slug)
                                                        <a href="{{ route('product.show', ['slug' => $item->product_slug]) }}" target="_blank" class="text-xs text-plum hover:underline">View product</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">Rs {{ number_format($item->unit_price, 0) }}</td>
                                        <td class="py-3">{{ $item->quantity }}</td>
                                        <td class="py-3 text-right font-medium">Rs {{ number_format($item->line_total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-plum mb-3">Update status</h3>
                    <form wire:submit="updateStatus" class="space-y-3">
                        <select wire:model="status" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                            @foreach ($statuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        <button type="submit" class="w-full rounded-full bg-plum text-white px-4 py-2 text-sm font-medium hover:bg-plum/90">
                            Save status
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-sm space-y-2">
                    <h3 class="font-semibold text-plum mb-3">Summary</h3>
                    <div class="flex justify-between"><span class="text-slate-500">Subtotal</span><span>Rs {{ number_format($viewing->subtotal, 0) }}</span></div>
                    @if ($viewing->discount > 0)
                        <div class="flex justify-between"><span class="text-slate-500">Discount {{ $viewing->coupon_code ? '('.$viewing->coupon_code.')' : '' }}</span><span>−Rs {{ number_format($viewing->discount, 0) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span class="text-slate-500">Shipping</span><span>Free</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Payment</span><span>Cash on delivery</span></div>
                    <div class="flex justify-between border-t pt-2 mt-2 font-semibold text-plum"><span>Total</span><span>Rs {{ number_format($viewing->total, 0) }}</span></div>
                </div>
            </aside>
        </div>
    @else
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search order #, name, email, phone…"
                class="flex-1 rounded-xl border border-slate-200 px-3 py-2 text-sm bg-white"
            >
            <select wire:model.live="statusFilter" class="rounded-xl border border-slate-200 px-3 py-2 text-sm bg-white sm:w-44">
                <option value="">All statuses</option>
                @foreach ($statuses as $statusOption)
                    <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
                @endforeach
            </select>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium">Order</th>
                            <th class="px-4 py-3 font-medium">Customer</th>
                            <th class="px-4 py-3 font-medium">Items</th>
                            <th class="px-4 py-3 font-medium">Total</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Date</th>
                            <th class="px-4 py-3 font-medium"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/60" wire:key="order-{{ $order->id }}">
                                <td class="px-4 py-3 font-medium text-plum">{{ $order->order_number }}</td>
                                <td class="px-4 py-3">
                                    <div>{{ $order->customer_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $order->items_count }}</td>
                                <td class="px-4 py-3 font-medium">Rs {{ number_format($order->total, 0) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ ! in_array($order->status, ['cancelled', 'delivered'], true) ? 'bg-amber-100 text-amber-800' : '' }}
                                    ">{{ $order->statusLabel() }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button type="button" wire:click="view({{ $order->id }})" class="rounded-full bg-plum/10 text-plum px-3 py-1.5 text-xs font-medium hover:bg-plum/20">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-500">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
