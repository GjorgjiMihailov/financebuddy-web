<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Најава — FinanceBuddy Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-paper-warm text-ink min-h-screen flex items-center justify-center">

<div class="w-full max-w-sm px-4">
    <div class="text-center mb-8">
        <span class="font-display text-2xl font-bold text-brand-orange">FinanceBuddy.mk</span>
        <p class="text-stone text-sm mt-1">Admin панел</p>
    </div>

    <div class="bg-white rounded-xl border border-border shadow-sm p-8">
        <h1 class="text-lg font-semibold text-ink mb-6">Најава</h1>

        <form method="POST" action="{{ route('admin.login') }}" novalidate>
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-ink mb-1">
                        Е-маил адреса
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange
                               {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-border' }}"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-ink mb-1">
                        Лозинка
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-border text-brand-orange focus:ring-brand-orange">
                    <span class="text-sm text-stone">Запомни ме</span>
                </label>
            </div>

            <button
                type="submit"
                class="mt-6 w-full bg-brand-orange hover:bg-brand-orange-dark text-white font-semibold text-sm py-2.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2"
            >
                Најави се
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-stone mt-6">
        <a href="{{ route('home') }}" class="hover:text-ink transition-colors">← Назад на сајтот</a>
    </p>
</div>

</body>
</html>
