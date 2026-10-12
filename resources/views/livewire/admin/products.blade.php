<div class="space-y-6">
    {{-- Toggle form: click header to open/close --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <button
            type="button"
            wire:click="toggleForm"
            class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-slate-50"
        >
            <span class="font-semibold text-plum">
                {{ $editingId ? 'Edit Product' : 'Add Product' }}
            </span>
            <span class="flex items-center gap-3">
                @if ($editingId)
                    <span
                        class="text-sm text-slate-500 hover:underline"
                        wire:click.stop="resetForm"
                    >Cancel edit</span>
                @endif
                <svg
                    class="w-5 h-5 text-plum transition-transform {{ $showForm ? 'rotate-180' : '' }}"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                </svg>
            </span>
        </button>

        @if ($showForm)
        <div class="px-5 pb-5 border-t border-slate-100">
        <form wire:submit="save" class="grid md:grid-cols-2 gap-4 pt-4">
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
                <label class="block text-sm mb-1">Official price</label>
                <input type="number" step="0.01" min="0" wire:model="official_price" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="Optional list price">
                <p class="text-xs text-slate-500 mt-1">Shown crossed out when higher than sale price.</p>
                @error('official_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Sale price</label>
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
                    <div>
                        <h3 class="text-sm font-semibold text-plum">Gallery images</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Use ↑ ↓ to change order. Color is optional.</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach ($gallery as $index => $item)
                            <div
                                class="flex gap-3 items-start border rounded-xl p-3 {{ !empty($item['is_main']) ? 'border-plum bg-plum/5' : 'border-slate-200' }}"
                                wire:key="gallery-{{ $item['id'] }}"
                            >
                                <div class="flex flex-col gap-1 shrink-0">
                                    <button
                                        type="button"
                                        wire:click="moveGalleryImage({{ $index }}, 'up')"
                                        @disabled($index === 0)
                                        class="w-8 h-8 rounded-lg border border-slate-200 text-plum text-sm disabled:opacity-30 disabled:cursor-not-allowed hover:bg-cream"
                                        title="Move up"
                                        aria-label="Move image up"
                                    >↑</button>
                                    <button
                                        type="button"
                                        wire:click="moveGalleryImage({{ $index }}, 'down')"
                                        @disabled($index === count($gallery) - 1)
                                        class="w-8 h-8 rounded-lg border border-slate-200 text-plum text-sm disabled:opacity-30 disabled:cursor-not-allowed hover:bg-cream"
                                        title="Move down"
                                        aria-label="Move image down"
                                    >↓</button>
                                </div>
                                <img src="{{ $item['url'] }}" alt="" class="w-16 h-16 rounded-lg object-cover bg-slate-100">
                                <div class="flex-1 space-y-2 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-[10px] uppercase tracking-wide text-slate-400">#{{ $index + 1 }}</span>
                                        @if (!empty($item['is_main']))
                                            <span class="inline-block text-[10px] uppercase tracking-wide font-semibold text-plum bg-cream px-2 py-0.5 rounded-full">Main display</span>
                                        @endif
                                    </div>

                                    @if (!empty($item['has_color']))
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
                                        <button
                                            type="button"
                                            wire:click="clearImageColor({{ $index }})"
                                            class="text-xs text-slate-500 hover:underline"
                                        >Remove color</button>
                                    @else
                                        <p class="text-xs text-slate-500">No color assigned</p>
                                        <button
                                            type="button"
                                            wire:click="enableImageColor({{ $index }})"
                                            class="text-xs text-plum font-medium hover:underline"
                                        >Assign color</button>
                                    @endif

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

            <div class="md:col-span-2" wire:key="description-editor-{{ $editingId ?? 'new' }}">
                <label class="block text-sm mb-1">Description</label>
                <div
                    class="mm-quill"
                    wire:ignore
                    x-data
                    x-init="
                        if (!window.__mmQuillReady) {
                            const Size = Quill.import('attributors/style/size');
                            Size.whitelist = ['12px', '14px', '16px', '18px', '24px', '32px'];
                            Quill.register(Size, true);
                            window.__mmQuillReady = true;
                        }

                        const quill = new Quill($refs.editor, {
                            theme: 'snow',
                            placeholder: 'Write a rich product description...',
                            modules: {
                                toolbar: [
                                    [{ header: [1, 2, 3, false] }],
                                    [{ size: ['12px', '14px', '16px', '18px', '24px', '32px'] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ list: 'ordered' }, { list: 'bullet' }],
                                    [{ align: [] }],
                                    ['link'],
                                    ['clean']
                                ]
                            }
                        });

                        const initial = $wire.description || '';
                        if (initial) {
                            quill.root.innerHTML = initial;
                        }

                        quill.on('text-change', () => {
                            let html = quill.root.innerHTML;
                            if (html === '<p><br></p>') {
                                html = '';
                            }
                            $wire.set('description', html);
                        });
                    "
                >
                    <div x-ref="editor"></div>
                </div>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2 rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-4">
                <div>
                    <h3 class="text-sm font-semibold text-plum">SEO</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Used for search engines and social previews. Leave blank to use product defaults.</p>
                </div>

                <div>
                    <label class="block text-sm mb-1">Meta title</label>
                    <input type="text" wire:model="meta_title" maxlength="70" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="Custom page title">
                    <p class="text-xs text-slate-500 mt-1">Recommended up to 60–70 characters.</p>
                    @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm mb-1">Meta description</label>
                    <textarea wire:model="meta_description" rows="2" maxlength="160" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="Short summary for search results"></textarea>
                    <p class="text-xs text-slate-500 mt-1">Recommended up to 150–160 characters.</p>
                    @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm mb-1">Meta keywords</label>
                    <input type="text" wire:model="meta_keywords" maxlength="255" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="kids toys, soft toys, wooden toys">
                    <p class="text-xs text-slate-500 mt-1">Comma-separated keywords.</p>
                    @error('meta_keywords') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
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
        @endif
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
                            <td class="px-4 py-3">
                                @if ($product->onSale())
                                    <span class="text-slate-400 line-through text-xs">Rs {{ number_format($product->official_price, 0) }}</span>
                                    <span class="block font-medium text-plum">Rs {{ number_format($product->price, 0) }}</span>
                                @else
                                    Rs {{ number_format($product->price, 0) }}
                                @endif
                            </td>
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
