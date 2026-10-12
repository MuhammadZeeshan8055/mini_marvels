<div class="grid lg:grid-cols-[340px_1fr] gap-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 h-fit">
        <h2 class="font-semibold text-plum mb-4">
            {{ $editingId ? 'Edit Category' : 'Add Category' }}
        </h2>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input
                    type="text"
                    wire:model="name"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"
                    placeholder="e.g. Learning Toys"
                >
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Emoji (optional)</label>
                <input
                    type="text"
                    wire:model="emoji"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"
                    placeholder="🧸"
                >
                @error('emoji') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-full bg-plum text-white px-4 py-2 text-sm">
                    {{ $editingId ? 'Update' : 'Add' }}
                </button>

                @if ($editingId)
                    <button type="button" wire:click="resetForm" class="rounded-full bg-slate-100 px-4 py-2 text-sm">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-cream text-plum">
                    <tr>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Products</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                <span class="mr-1">{{ $category->emoji }}</span>
                                {{ $category->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $category->slug }}</td>
                            <td class="px-4 py-3">{{ $category->products_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button
                                        type="button"
                                        wire:click="edit({{ $category->id }})"
                                        class="text-plum hover:underline"
                                    >Edit</button>
                                    <button
                                        type="button"
                                        wire:click="delete({{ $category->id }})"
                                        wire:confirm="Delete this category?"
                                        class="text-red-500 hover:underline"
                                    >Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
