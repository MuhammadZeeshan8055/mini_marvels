<div class="space-y-6">
    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-6">
        <div>
            <h2 class="font-semibold text-plum">Footer content</h2>
            <p class="text-xs text-slate-500 mt-0.5">Shown site-wide in the store footer.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Gallery title</label>
                <input type="text" wire:model="gallery_title" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('gallery_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Copyright text</label>
                <input type="text" wire:model="copyright" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('copyright') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Address</label>
                <input type="text" wire:model="address" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Phone</label>
                <input type="text" wire:model="phone" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" wire:model="email" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Newsletter note</label>
                <input type="text" wire:model="newsletter_text" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('newsletter_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Newsletter image URL</label>
                <input type="url" wire:model="newsletter_image_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('newsletter_image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Or upload newsletter image</label>
                <input type="file" wire:model="newsletter_image_upload" accept="image/*" class="w-full text-sm">
                @if ($newsletterPreview)
                    <img src="{{ $newsletterPreview }}" alt="" class="mt-2 w-16 h-16 rounded-full object-cover border border-slate-200">
                @endif
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-plum">Gallery images (up to 6 URLs)</h3>
            <div class="grid md:grid-cols-2 gap-3">
                @foreach ($gallery_images as $index => $url)
                    <input
                        type="url"
                        wire:model="gallery_images.{{ $index }}"
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"
                        placeholder="Image {{ $index + 1 }} URL"
                    >
                @endforeach
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-sm font-semibold text-plum">Social links</h3>
                <button type="button" wire:click="addSocialLink" class="text-sm text-plum hover:underline">Add link</button>
            </div>

            @foreach ($social_links as $index => $link)
                <div class="grid md:grid-cols-[180px_1fr_auto] gap-3 items-start" wire:key="social-{{ $index }}">
                    <select wire:model="social_links.{{ $index }}.platform" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                        @foreach ($platforms as $platform)
                            <option value="{{ $platform }}">{{ ucfirst($platform) }}</option>
                        @endforeach
                    </select>
                    <input type="text" wire:model="social_links.{{ $index }}.url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30" placeholder="https://...">
                    <button type="button" wire:click="removeSocialLink({{ $index }})" class="rounded-lg border border-red-200 text-red-500 px-3 py-2 text-sm hover:bg-red-50">Remove</button>
                </div>
            @endforeach
        </div>

        <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm font-medium hover:bg-plum/90">
            Save Footer
        </button>
    </form>
</div>
