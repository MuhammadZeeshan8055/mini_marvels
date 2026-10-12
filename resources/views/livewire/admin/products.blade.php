<div class="space-y-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <h2 class="font-semibold text-plum">
                {{ $editingId ? 'Edit Product' : 'Add Product' }}
            </h2>
            @if ($editingId)
                <button type="button" wire:click="resetForm" class="text-sm text-slate-500 hover:underline">Cancel edit</button>
            @endif
        </div>

        <form wire:submit="save" class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" wire:model="name" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Category</label>
                <select wire:model="category_id" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->emoji }} {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Price</label>
                <input type="number" step="0.01" min="0" wire:model="price" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Stock</label>
                <input type="number" min="0" wire:model="stock" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Age</label>
                <select wire:model="age" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                    <option value="">Select age</option>
                    @foreach ($ages as $ageOption)
                        <option value="{{ $ageOption }}">{{ $ageOption }}</option>
                    @endforeach
                </select>
                @error('age') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Cover image URL (optional)</label>
                <input type="url" wire:model="image_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="https://example.com/image.jpg">
                <p class="text-xs text-slate-500 mt-1">Only full http/https links. Leave empty if you upload files below.</p>
                @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Upload multiple images (color variants)</label>
                <input type="file" wire:model="new_images" accept="image/*" multiple class="w-full text-sm">
                <div wire:loading wire:target="new_images" class="text-xs text-slate-500 mt-1">Uploading...</div>
                @error('new_images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('new_images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-500 mt-1">Choose image files, then click Add/Update Product. The form stays open so you can set color name + hex.</p>

                @if (is_array($new_images) && count($new_images))
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach ($new_images as $file)
                            @if (is_object($file) && method_exists($file, 'temporaryUrl'))
                                <img src="{{ $file->temporaryUrl() }}" alt="preview" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            @if (count($gallery))
                <div class="md:col-span-2 space-y-3">
                    <h3 class="text-sm font-semibold text-plum">Gallery / color swatches</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach ($gallery as $index => $item)
                            <div
                                class="flex gap-3 items-start border rounded-xl p-3 {{ !empty($item['is_main']) ? 'border-plum bg-plum/5' : 'border-slate-200' }}"
                                wire:key="gallery-{{ $item['id'] }}"
                            >
                                <img src="{{ $item['url'] }}" alt="" class="w-16 h-16 rounded-lg object-cover bg-slate-100">
                                <div class="flex-1 space-y-2 min-w-0">
                                    @if (!empty($item['is_main']))
                                        <span class="inline-block text-[10px] uppercase tracking-wide font-semibold text-plum bg-cream px-2 py-0.5 rounded-full">Main display</span>
                                    @endif
                                    <input
                                        type="text"
                                        wire:model="gallery.{{ $index }}.color_name"
                                        class="w-full rounded-lg border border-slate-200 px-2 py-1.5 text-sm"
                                        placeholder="Color name"
                                    >
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="color"
                                            wire:model="gallery.{{ $index }}.color_hex"
                                            class="h-9 w-12 rounded border border-slate-200 p-0.5"
                                        >
                                        <input
                                            type="text"
                                            wire:model="gallery.{{ $index }}.color_hex"
                                            class="flex-1 rounded-lg border border-slate-200 px-2 py-1.5 text-sm"
                                            placeholder="#hex"
                                        >
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        @if (empty($item['is_main']))
                                            <button
                                                type="button"
                                                wire:click="setAsMain({{ $index }})"
                                                class="text-xs text-plum font-medium hover:underline"
                                            >Set as main display</button>
                                        @endif
                                        <button
                                            type="button"
                                            wire:click="removeGalleryImage({{ $index }})"
                                            wire:confirm="Remove this image?"
                                            class="text-xs text-red-500 hover:underline"
                                        >Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Description</label>
                <textarea wire:model="description" rows="3" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6 md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model="is_featured" class="rounded">
                    Featured
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model="is_active" class="rounded">
                    Active
                </label>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm">
                    {{ $editingId ? 'Update Product' : 'Add Product' }}
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-wrap gap-3 items-center justify-between">
            <h2 class="font-semibold text-plum">All Products</h2>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search products..."
                class="rounded-full border border-slate-200 px-4 py-2 text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-plum/30"
            >
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-cream text-plum">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-slate-100 align-top">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover bg-slate-100">
                                    <div>
                                        <p class="font-medium">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $product->age }}</p>
                                        @if ($product->is_featured)
                                            <span class="text-[10px] uppercase tracking-wide text-amber-600">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $product->category?->name }}</td>
                            <td class="px-4 py-3">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3">
                                <button
                                    type="button"
                                    wire:click="toggleActive({{ $product->id }})"
                                    class="rounded-full px-2.5 py-1 text-xs {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}"
                                >
                                    {{ $product->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button type="button" wire:click="edit({{ $product->id }})" class="text-plum hover:underline">Edit</button>
                                    <button
                                        type="button"
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Delete this product?"
                                        class="text-red-500 hover:underline"
                                    >Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
