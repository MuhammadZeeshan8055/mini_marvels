<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <button
            type="button"
            wire:click="toggleForm"
            class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-slate-50"
        >
            <span class="font-semibold text-plum">
                {{ $editingId ? 'Edit Hero Slide' : 'Add Hero Slide' }}
            </span>
            <span class="flex items-center gap-3">
                @if ($editingId)
                    <span class="text-sm text-slate-500 hover:underline" wire:click.stop="resetForm">Cancel edit</span>
                @endif
                <svg class="w-5 h-5 text-plum transition-transform {{ $showForm ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                </svg>
            </span>
        </button>

        @if ($showForm)
            <div class="px-5 pb-5 border-t border-slate-100">
                <form wire:submit="save" class="grid md:grid-cols-2 gap-4 pt-4">
                    <div>
                        <label class="block text-sm mb-1">Eyebrow label</label>
                        <input type="text" wire:model="eyebrow" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="Educational Programs">
                        @error('eyebrow') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Button label</label>
                        <input type="text" wire:model="button_label" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @error('button_label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1">Heading</label>
                        <input type="text" wire:model="title" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1">Description</label>
                        <textarea wire:model="text" rows="3" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"></textarea>
                        @error('text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Button link</label>
                        <input type="text" wire:model="button_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="#products or /shop">
                        @error('button_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Image URL (optional)</label>
                        <input type="url" wire:model="image_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="https://...">
                        @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1">Or upload image</label>
                        <input type="file" wire:model="image_upload" accept="image/*" class="w-full text-sm">
                        <div wire:loading wire:target="image_upload" class="text-xs text-slate-500 mt-1">Uploading...</div>
                        @error('image_upload') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="eyebrow_box" class="rounded border-slate-300 text-plum focus:ring-plum/30">
                        Boxed eyebrow style
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="title_dark" class="rounded border-slate-300 text-plum focus:ring-plum/30">
                        Dark title text
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm md:col-span-2">
                        <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-plum focus:ring-plum/30">
                        Active on homepage
                    </label>

                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm font-medium hover:bg-plum/90">
                            {{ $editingId ? 'Update Slide' : 'Add Slide' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-plum">Hero slides</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage the homepage hero carousel text and images.</p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($slides as $index => $slide)
                <div class="px-5 py-4 flex flex-col sm:flex-row gap-4 sm:items-center" wire:key="slide-{{ $slide->id }}">
                    <img src="{{ $slide->imageUrl() }}" alt="" class="w-20 h-20 rounded-xl object-cover bg-slate-100 shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs uppercase tracking-wide text-amber-600 font-semibold">{{ $slide->eyebrow }}</p>
                        <h3 class="font-semibold text-slate-800 truncate">{{ $slide->title }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ $slide->text }}</p>
                        <p class="text-xs mt-1 {{ $slide->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $slide->is_active ? 'Active' : 'Hidden' }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 shrink-0">
                        <button type="button" wire:click="move({{ $slide->id }}, 'up')" @disabled($index === 0) class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm disabled:opacity-30">↑</button>
                        <button type="button" wire:click="move({{ $slide->id }}, 'down')" @disabled($index === $slides->count() - 1) class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm disabled:opacity-30">↓</button>
                        <button type="button" wire:click="edit({{ $slide->id }})" class="rounded-lg border border-plum/30 text-plum px-3 py-1.5 text-sm hover:bg-cream">Edit</button>
                        <button type="button" wire:click="toggleActive({{ $slide->id }})" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm hover:bg-slate-50">Toggle</button>
                        <button type="button" wire:click="delete({{ $slide->id }})" wire:confirm="Delete this slide?" class="rounded-lg border border-red-200 text-red-500 px-3 py-1.5 text-sm hover:bg-red-50">Delete</button>
                    </div>
                </div>
            @empty
                <p class="px-5 py-8 text-sm text-slate-500 text-center">No hero slides yet. Add your first slide above.</p>
            @endforelse
        </div>
    </div>
</div>
