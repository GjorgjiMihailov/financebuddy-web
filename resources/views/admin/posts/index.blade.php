@extends('admin.layouts.app')

@section('title', 'Блог постови')
@section('page-title', 'Блог постови')

@section('page-actions')
    <a href="{{ route('admin.posts.create') }}"
       class="inline-flex items-center gap-1.5 bg-brand-orange hover:bg-brand-orange-dark text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
        + Нов пост
    </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap gap-3 mb-5">
    <select name="status"
            class="border border-border rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-orange">
        <option value="">Сите статуси</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Објавено</option>
        <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Нацрт</option>
    </select>

    <select name="category_id"
            class="border border-border rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-orange">
        <option value="">Сите категории</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit"
            class="bg-white border border-border hover:border-brand-orange text-ink text-sm px-3 py-1.5 rounded-lg transition-colors">
        Филтрирај
    </button>

    @if(request()->hasAny(['status', 'category_id']))
        <a href="{{ route('admin.posts.index') }}"
           class="text-sm text-stone hover:text-ink px-3 py-1.5 transition-colors">
            Ресетирај
        </a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white border border-border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-border bg-paper-warm">
                <th class="text-left px-5 py-3 font-semibold text-ink">Наслов</th>
                <th class="text-left px-4 py-3 font-semibold text-ink hidden md:table-cell">Категорија</th>
                <th class="text-left px-4 py-3 font-semibold text-ink">Статус</th>
                <th class="text-left px-4 py-3 font-semibold text-ink hidden lg:table-cell">Датум</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr class="border-b border-border last:border-0 hover:bg-paper-warm/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-ink">{{ $post->title }}</span>
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell text-stone">
                        {{ $post->category?->name ?? '—' }}
                    </td>
                    <td class="px-4 py-3.5">
                        @if($post->status === 'published')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                Објавено
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-stone/10 text-stone">
                                Нацрт
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 hidden lg:table-cell text-stone text-xs">
                        {{ $post->created_at->format('d.m.Y') }}
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1 justify-end">

                            {{-- Preview (public) --}}
                            @if($post->status === 'published')
                                <a href="{{ route('blog.show', $post) }}"
                                   target="_blank"
                                   class="p-1.5 text-stone hover:text-ink transition-colors"
                                   title="Прегледај на сајтот">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @endif

                            {{-- Publish toggle --}}
                            <form method="POST" action="{{ route('admin.posts.toggle-publish', $post) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="p-1.5 text-stone hover:text-brand-orange transition-colors"
                                        title="{{ $post->status === 'published' ? 'Врати во нацрт' : 'Објави' }}">
                                    @if($post->status === 'published')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </button>
                            </form>

                            {{-- Edit --}}
                            <a href="{{ route('admin.posts.edit', $post) }}"
                               class="p-1.5 text-stone hover:text-ink transition-colors"
                               title="Уреди">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                  onsubmit="return confirm('Сигурно сакате да го избришете овој пост?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-stone hover:text-red-500 transition-colors"
                                        title="Избриши">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-stone text-sm">
                        Нема постови.
                        <a href="{{ route('admin.posts.create') }}" class="text-brand-orange hover:underline ml-1">
                            Создај нов →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endif

@endsection
