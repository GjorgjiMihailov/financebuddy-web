@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<p class="text-stone text-sm mb-6">Добредојде, {{ auth()->user()->name }}.</p>

{{-- Stats cards --}}
<div class="grid grid-cols-2 gap-4 mb-8">
    <a href="{{ route('admin.messages.index', ['status' => 'new']) }}"
       class="bg-white border border-border rounded-xl p-5 hover:border-brand-orange/50 transition-colors group">
        <div class="text-3xl font-bold text-brand-orange">{{ $newMessagesCount }}</div>
        <div class="text-sm text-stone mt-1 group-hover:text-ink transition-colors">
            нов{{ $newMessagesCount === 1 ? 'а' : 'и' }} порак{{ $newMessagesCount === 1 ? 'а' : 'и' }}
        </div>
        <div class="text-xs text-brand-orange mt-2">Прегледај →</div>
    </a>

    <a href="{{ route('admin.posts.index') }}"
       class="bg-white border border-border rounded-xl p-5 hover:border-brand-orange/50 transition-colors group">
        <div class="text-3xl font-bold text-ink">{{ $totalPostsCount }}</div>
        <div class="text-sm text-stone mt-1 group-hover:text-ink transition-colors">
            вкупно пост{{ $totalPostsCount === 1 ? '' : 'ови' }}
        </div>
        <div class="text-xs text-brand-orange mt-2">Управувај →</div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent messages --}}
    <div class="bg-white border border-border rounded-xl overflow-hidden">
        <div class="px-5 py-3.5 border-b border-border flex items-center justify-between">
            <h2 class="font-semibold text-sm text-ink">Последни пораки</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-xs text-brand-orange hover:underline">
                Сите →
            </a>
        </div>
        @forelse($recentMessages as $message)
            <a href="{{ route('admin.messages.show', $message) }}"
               class="flex items-start gap-3 px-5 py-3.5 border-b border-border last:border-0 hover:bg-paper-warm transition-colors">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-ink truncate {{ $message->status === 'new' ? 'font-semibold' : '' }}">
                        {{ $message->name }}
                        @if($message->status === 'new')
                            <span class="ml-1 inline-block w-1.5 h-1.5 bg-brand-orange rounded-full align-middle"></span>
                        @endif
                    </p>
                    <p class="text-xs text-stone truncate mt-0.5">{{ Str::limit($message->message, 60) }}</p>
                </div>
                <span class="text-xs text-stone flex-shrink-0 mt-0.5">
                    {{ $message->created_at->diffForHumans() }}
                </span>
            </a>
        @empty
            <p class="px-5 py-8 text-sm text-stone text-center">Нема пораки уште.</p>
        @endforelse
    </div>

    {{-- Recent posts --}}
    <div class="bg-white border border-border rounded-xl overflow-hidden">
        <div class="px-5 py-3.5 border-b border-border flex items-center justify-between">
            <h2 class="font-semibold text-sm text-ink">Последни постови</h2>
            <a href="{{ route('admin.posts.create') }}" class="text-xs text-brand-orange hover:underline">
                + Нов пост
            </a>
        </div>
        @forelse($recentPosts as $post)
            <a href="{{ route('admin.posts.edit', $post) }}"
               class="flex items-start gap-3 px-5 py-3.5 border-b border-border last:border-0 hover:bg-paper-warm transition-colors">
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-ink truncate">{{ $post->title }}</p>
                    <p class="text-xs text-stone mt-0.5">{{ $post->category?->name ?? '—' }}</p>
                </div>
                <span class="flex-shrink-0">
                    @if($post->status === 'published')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                            Објавено
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-stone/10 text-stone">
                            Нацрт
                        </span>
                    @endif
                </span>
            </a>
        @empty
            <p class="px-5 py-8 text-sm text-stone text-center">Нема постови уште.</p>
        @endforelse
    </div>

</div>
@endsection
