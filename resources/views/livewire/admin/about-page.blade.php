<div class="space-y-6">
    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
        <div>
            <h2 class="font-semibold text-plum">About Us page</h2>
            <p class="text-xs text-slate-500 mt-0.5">Content shown on the public About Us page.</p>
        </div>

        <div>
            <label class="block text-sm mb-1">Page title</label>
            <input type="text" wire:model="title" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div wire:key="about-editor">
            <label class="block text-sm mb-1">Content</label>
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
                        placeholder: 'Write about your store...',
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

                    const initial = $wire.content || '';
                    if (initial) {
                        quill.root.innerHTML = initial;
                    }

                    quill.on('text-change', () => {
                        let html = quill.root.innerHTML;
                        if (html === '<p><br></p>') {
                            html = '';
                        }
                        $wire.set('content', html);
                    });
                "
            >
                <div x-ref="editor"></div>
            </div>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Image URL</label>
                <input type="url" wire:model="image_url" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
                @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Or upload image</label>
                <input type="file" wire:model="image_upload" accept="image/*" class="w-full text-sm">
                @if ($previewImage)
                    <img src="{{ $previewImage }}" alt="" class="mt-2 w-28 h-28 rounded-xl object-cover border border-slate-200">
                @endif
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-4">
            <h3 class="text-sm font-semibold text-plum">SEO</h3>
            <div>
                <label class="block text-sm mb-1">Meta title</label>
                <input type="text" wire:model="meta_title" maxlength="70" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
            </div>
            <div>
                <label class="block text-sm mb-1">Meta description</label>
                <textarea wire:model="meta_description" rows="2" maxlength="160" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30"></textarea>
            </div>
        </div>

        <button type="submit" class="rounded-full bg-plum text-white px-5 py-2.5 text-sm font-medium hover:bg-plum/90">
            Save About Page
        </button>
    </form>
</div>
