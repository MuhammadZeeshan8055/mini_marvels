<div>
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Products</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $productCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Categories</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $categoryCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Featured</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $featuredCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">Users</p>
            <p class="text-3xl font-semibold text-plum mt-1">{{ $userCount }}</p>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <h2 class="font-semibold text-plum mb-2">Quick links</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.products') }}" class="rounded-full bg-plum text-white px-4 py-2 text-sm">Manage Products</a>
            <a href="{{ route('admin.categories') }}" class="rounded-full bg-cream text-plum px-4 py-2 text-sm border border-plum/20">Manage Categories</a>
        </div>
    </div>
</div>
