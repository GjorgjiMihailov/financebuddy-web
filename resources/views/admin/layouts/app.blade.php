<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — FinanceBuddy.mk</title>
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body class="bg-paper-warm text-ink min-h-screen">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-52 bg-ink text-paper flex-shrink-0 flex flex-col">
        <div class="px-4 py-5 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="font-display text-brand-orange font-bold text-base leading-tight">
                FinanceBuddy
            </a>
            <p class="text-stone text-xs mt-0.5">Admin панел</p>
        </div>

        <nav class="flex-1 p-3 space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 px-3 py-2 rounded text-sm text-paper/80 hover:bg-white/10 hover:text-paper transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-paper' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.posts.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded text-sm text-paper/80 hover:bg-white/10 hover:text-paper transition-colors
                      {{ request()->routeIs('admin.posts.*') ? 'bg-white/10 text-paper' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Блог постови
            </a>

            @php
                $newMsgCount = \App\Models\ContactMessage::where('status', 'new')->count();
            @endphp
            <a href="{{ route('admin.messages.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded text-sm text-paper/80 hover:bg-white/10 hover:text-paper transition-colors
                      {{ request()->routeIs('admin.messages.*') ? 'bg-white/10 text-paper' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Пораки
                @if($newMsgCount > 0)
                    <span class="ml-auto bg-brand-orange text-white text-xs font-semibold px-1.5 py-0.5 rounded-full leading-none">
                        {{ $newMsgCount }}
                    </span>
                @endif
            </a>
        </nav>

        <div class="p-4 border-t border-white/10">
            <p class="text-xs text-stone">{{ auth()->user()->name }}</p>
            <p class="text-xs text-stone/60">{{ auth()->user()->email }}</p>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="text-xs text-stone hover:text-paper transition-colors">
                    Одјави се →
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-border px-6 py-3.5 flex items-center justify-between gap-4">
            <h1 class="font-semibold text-ink text-sm">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-2">
                @yield('page-actions')
            </div>
        </header>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>
