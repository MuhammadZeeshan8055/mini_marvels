<div class="space-y-6">
    <form wire:submit="saveSection" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
        <div>
            <h2 class="font-semibold text-plum">Section intro</h2>
            <p class="text-xs text-slate-500 mt-0.5">Heading shown beside the testimonials carousel.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Kicker</label>
                <input type="text" wire:model="section_kicker" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('section_kicker') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Title</label>
                <input type="text" wire:model="section_title" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('section_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Description</label>
                <textarea wire:model="section_description" rows="2" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"></textarea>
                @error('section_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm font-medium hover:bg-plum/90">
            Save Section
        </button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <button
            type="button"
            wire:click="toggleForm"
            class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-slate-50"
        >
            <span class="font-semibold text-plum">
                {{ $editingId ? 'Edit Testimonial' : 'Add Testimonial' }}
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
                        <label class="block text-sm mb-1">Name</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Role</label>
                        <input type="text" wire:model="role" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="Parent">
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1">Review text</label>
                        <textarea wire:model="text" rows="3" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"></textarea>
                        @error('text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Photo URL</label>
                        <input type="url" wire:model="image_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Or upload photo</label>
                        <input type="file" wire:model="image_upload" accept="image/*" class="w-full text-sm">
                        @error('image_upload') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Rating (1–5)</label>
                        <input type="number" min="1" max="5" wire:model="rating" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm self-end pb-2">
                        <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-plum focus:ring-plum/30">
                        Active
                    </label>
                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm font-medium hover:bg-plum/90">
                            {{ $editingId ? 'Update Testimonial' : 'Add Testimonial' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-plum">All testimonials</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($testimonials as $index => $item)
                <div class="px-5 py-4 flex flex-col sm:flex-row gap-4 sm:items-center" wire:key="testimonial-{{ $item->id }}">
                    <img src="{{ $item->imageUrl() }}" alt="" class="w-16 h-16 rounded-full object-cover bg-slate-100 shrink-0">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-slate-800">{{ $item->name }} <span class="text-sm font-normal text-slate-500">· {{ $item->role }}</span></h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ $item->text }}</p>
                        <p class="text-xs mt-1 {{ $item->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $item->rating }}★ · {{ $item->is_active ? 'Active' : 'Hidden' }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 shrink-0">
                        <button type="button" wire:click="move({{ $item->id }}, 'up')" @disabled($index === 0) class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm disabled:opacity-30">↑</button>
                        <button type="button" wire:click="move({{ $item->id }}, 'down')" @disabled($index === $testimonials->count() - 1) class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm disabled:opacity-30">↓</button>
                        <button type="button" wire:click="edit({{ $item->id }})" class="rounded-lg border border-plum/30 text-plum px-3 py-1.5 text-sm hover:bg-cream">Edit</button>
                        <button type="button" wire:click="toggleActive({{ $item->id }})" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm hover:bg-slate-50">Toggle</button>
                        <button type="button" wire:click="delete({{ $item->id }})" wire:confirm="Delete this testimonial?" class="rounded-lg border border-red-200 text-red-500 px-3 py-1.5 text-sm hover:bg-red-50">Delete</button>
                    </div>
                </div>
            @empty
                <p class="px-5 py-8 text-sm text-slate-500 text-center">No testimonials yet.</p>
            @endforelse
        </div>
    </div>
</div>
