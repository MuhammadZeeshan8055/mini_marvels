<div class="cart-page shop-page">
    <section class="shop-banner cart-banner" aria-labelledby="shop-page-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="shop-page-title">Shop</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>›</span><span aria-current="page">Shop</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="shop-content">
        <div class="shop-container">
            <div class="shop-intro">
                <div><span>Find their new favorite</span><h2>Toys for curious little minds</h2></div>
                <p>Browse playful picks selected for every age, interest, and kind of adventure.</p>
            </div>

            <div class="shop-layout">
                <aside>
                    <details class="shop-filter-panel" open>
                        <summary>Filter products <span>⌄</span></summary>
                        <div class="shop-filters">
                            <div class="shop-filter-group shop-search-group">
                                <label for="shop-search">Search products</label>
                                <div class="shop-search">
                                    <input id="shop-search" type="search" wire:model.live.debounce.300ms="search" placeholder="What are you looking for?">
                                    <span aria-hidden="true">⌕</span>
                                </div>
                            </div>

                            <fieldset class="shop-filter-group">
                                <legend>Category</legend>
                                <label class="shop-filter-option">
                                    <input type="radio" wire:model.live="category" value="All">
                                    <span>All products</span><b>{{ count($this->filteredProducts) }}</b>
                                </label>
                                @foreach ($categories as $option)
                                    <label class="shop-filter-option">
                                        <input type="radio" wire:model.live="category" value="{{ $option }}">
                                        <span>{{ $option }}</span><b>{{ $this->categoryCounts[$option] }}</b>
                                    </label>
                                @endforeach
                            </fieldset>

                            <fieldset class="shop-filter-group">
                                <legend>Age range</legend>
                                <label class="shop-filter-option">
                                    <input type="radio" wire:model.live="age" value="All"><span>All ages</span>
                                </label>
                                @foreach ($ages as $option)
                                    <label class="shop-filter-option">
                                        <input type="radio" wire:model.live="age" value="{{ $option }}"><span>{{ $option }}</span>
                                    </label>
                                @endforeach
                            </fieldset>

                            <div class="shop-filter-group shop-price-filter">
                                <label for="max-price">Price up to <strong>${{ $maxPrice }}</strong></label>
                                <input id="max-price" type="range" min="10" max="80" step="5" wire:model.live="maxPrice">
                                <div><span>$10</span><span>$80</span></div>
                            </div>

                            @if ($search || $category !== 'All' || $age !== 'All' || $maxPrice < 80 || $sort !== 'featured')
                                <button type="button" class="clear-filters" wire:click="resetFilters">Clear all filters</button>
                            @endif
                        </div>
                    </details>
                </aside>

                <div class="shop-results">
                    <div class="shop-toolbar">
                        <p><strong>{{ $this->filteredProducts->count() }}</strong> products</p>
                        <label>Sort by
                            <select wire:model.live="sort">
                                <option value="featured">Featured</option>
                                <option value="price-low">Price: low to high</option>
                                <option value="price-high">Price: high to low</option>
                                <option value="name">Name: A–Z</option>
                            </select>
                        </label>
                    </div>

                    <div class="shop-product-grid" wire:loading.class="is-loading">
                        @forelse ($this->filteredProducts as $product)
                            <x-product-card
                                :name="$product['name']"
                                :category="$product['category']"
                                :age="$product['age']"
                                :price="$product['price']"
                                :image="$product['image']"
                                wire:key="shop-{{ \Illuminate\Support\Str::slug($product['name']) }}"
                            />
                        @empty
                            <div class="shop-empty">
                                <span aria-hidden="true">🧸</span>
                                <h3>No toys found</h3>
                                <p>Try another search or clear your filters.</p>
                                <button type="button" class="cart-pill" wire:click="resetFilters">Reset Filters</button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
