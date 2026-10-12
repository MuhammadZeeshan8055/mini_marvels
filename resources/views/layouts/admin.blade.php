<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Mini Marvels</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        plum: '#5D3E9F',
                        cream: '#FFF9E5',
                    },
                    fontFamily: {
                        display: ['Fredoka', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .mm-quill .ql-toolbar.ql-snow {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem 0.75rem 0 0;
            background: #f8fafc;
        }
        .mm-quill .ql-container.ql-snow {
            border: 1px solid #e2e8f0;
            border-top: 0;
            border-radius: 0 0 0.75rem 0.75rem;
            min-height: 180px;
            font-family: Fredoka, system-ui, sans-serif;
            font-size: 0.95rem;
        }
        .mm-quill .ql-editor {
            min-height: 160px;
        }
        .mm-quill .ql-editor.ql-blank::before {
            color: #94a3b8;
            font-style: normal;
        }
    </style>
    @livewireStyles
</head>
<body class="font-display bg-slate-100 text-slate-800 min-h-screen">
    {{-- Toast (Alpine + Livewire) --}}
    <div
        x-data="{
            show: false,
            message: '',
            type: 'success',
            timer: null,
            init() {
                Livewire.on('toast', (payload) => {
                    const data = Array.isArray(payload) ? payload[0] : payload;
                    this.message = data.message || 'Done';
                    this.type = data.type || 'success';
                    this.show = true;
                    clearTimeout(this.timer);
                    this.timer = setTimeout(() => this.show = false, 3000);
                });
            }
        }"
        x-show="show"
        x-transition.opacity.duration.200ms
        x-cloak
        class="fixed top-4 right-4 z-50 max-w-sm"
        style="display: none;"
    >
        <div
            class="rounded-xl px-4 py-3 shadow-lg text-white text-sm font-medium"
            :class="type === 'error' ? 'bg-red-500' : (type === 'warning' ? 'bg-amber-500' : 'bg-emerald-500')"
            x-text="message"
        ></div>
    </div>

    <div class="min-h-screen lg:grid lg:grid-cols-[240px_1fr]">
        <aside class="bg-plum text-white p-5">
            <a href="{{ route('admin.dashboard') }}" class="block mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Mini Marvels" class="h-14 w-auto mx-auto lg:mx-0 bg-white/10 rounded-xl p-1">
                <p class="mt-2 text-center lg:text-left text-sm opacity-90">Admin Panel</p>
            </a>

            <nav class="flex flex-wrap lg:flex-col gap-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">Dashboard</a>
                <a href="{{ route('admin.categories') }}" class="rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.categories') ? 'bg-white/20' : '' }}">Categories</a>
                <a href="{{ route('admin.products') }}" class="rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.products') ? 'bg-white/20' : '' }}">Products</a>
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-white/10" target="_blank">View Store</a>
            </nav>
        </aside>

        <div class="flex flex-col min-w-0">
            <header class="bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-plum">{{ $title ?? 'Admin' }}</h1>
                <div class="flex items-center gap-3 text-sm">
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-slate-100 px-3 py-1.5 hover:bg-slate-200">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <style>[x-cloak]{display:none!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @livewireScripts
</body>
</html>
