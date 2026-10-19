<div class="space-y-6">
    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
        <div>
            <h2 class="font-semibold text-plum">Contact Us page</h2>
            <p class="text-xs text-slate-500 mt-0.5">Content and contact details for the public Contact page.</p>
        </div>

        <div>
            <label class="block text-sm mb-1">Page title</label>
            <input type="text" wire:model="title" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div wire:key="contact-editor">
            <label class="block text-sm mb-1">Intro content</label>
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
                        placeholder: 'Write contact intro...',
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, 3, false] }],
                                [{ size: ['12px', '14px', '16px', '18px', '24px', '32px'] }],
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
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
                <label class="block text-sm mb-1">Form note</label>
                <input type="text" wire:model="form_note" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-plum/30">
            </div>
            <label class="inline-flex items-center gap-2 text-sm md:col-span-2">
                <input type="checkbox" wire:model="show_form" class="rounded border-slate-300 text-plum focus:ring-plum/30">
                Show contact form on the page
            </label>
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
            Save Contact Page
        </button>
    </form>
</div>
