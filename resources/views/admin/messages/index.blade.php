@extends('admin.layouts.app')

@section('title', 'Контакт пораки')
@section('page-title', 'Контакт пораки')

@section('content')

{{-- Filters --}}
<form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-wrap gap-3 mb-5">
    <select name="status"
            class="border border-border rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-orange">
        <option value="">Сите статуси</option>
        <option value="new"      {{ request('status') === 'new'      ? 'selected' : '' }}>Ново</option>
        <option value="read"     {{ request('status') === 'read'     ? 'selected' : '' }}>Прочитано</option>
        <option value="replied"  {{ request('status') === 'replied'  ? 'selected' : '' }}>Одговорено</option>
        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Архивирано</option>
    </select>

    <button type="submit"
            class="bg-white border border-border hover:border-brand-orange text-ink text-sm px-3 py-1.5 rounded-lg transition-colors">
        Филтрирај
    </button>

    @if(request()->filled('status'))
        <a href="{{ route('admin.messages.index') }}"
           class="text-sm text-stone hover:text-ink px-3 py-1.5 transition-colors">
            Ресетирај
        </a>
    @endif
</form>

{{-- Messages list --}}
<div class="bg-white border border-border rounded-xl overflow-hidden">
    @forelse($messages as $message)
        <a href="{{ route('admin.messages.show', $message) }}"
           class="flex items-start gap-4 px-5 py-4 border-b border-border last:border-0 hover:bg-paper-warm/60 transition-colors
                  {{ $message->status === 'new' ? 'bg-orange-50/40' : '' }}">

            {{-- Status dot --}}
            <div class="mt-1 flex-shrink-0">
                @if($message->status === 'new')
                    <span class="block w-2 h-2 bg-brand-orange rounded-full"></span>
                @else
                    <span class="block w-2 h-2 bg-border rounded-full"></span>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="font-{{ $message->status === 'new' ? 'semibold' : 'medium' }} text-sm text-ink">
                        {{ $message->name }}
                    </span>
                    <span class="text-xs text-stone">{{ $message->email }}</span>
                    @if($message->service_interest)
                        <span class="text-xs text-stone">· {{ $message->service_interest }}</span>
                    @endif
                </div>
                <p class="text-xs text-stone mt-1 truncate">{{ Str::limit($message->message, 120) }}</p>
            </div>

            {{-- Meta --}}
            <div class="flex-shrink-0 text-right">
                @php
                    $statusLabels = [
                        'new'      => ['label' => 'Ново',       'class' => 'bg-orange-100 text-orange-700'],
                        'read'     => ['label' => 'Прочитано',  'class' => 'bg-stone/10 text-stone'],
                        'replied'  => ['label' => 'Одговорено', 'class' => 'bg-blue-100 text-blue-700'],
                        'archived' => ['label' => 'Архивирано', 'class' => 'bg-gray-100 text-gray-500'],
                    ];
                    $s = $statusLabels[$message->status] ?? $statusLabels['read'];
                @endphp
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $s['class'] }}">
                    {{ $s['label'] }}
                </span>
                <p class="text-xs text-stone mt-1.5">{{ $message->created_at->format('d.m.Y') }}</p>
            </div>
        </a>
    @empty
        <p class="px-5 py-12 text-center text-sm text-stone">Нема пораки.</p>
    @endforelse
</div>

@if($messages->hasPages())
    <div class="mt-4">
        {{ $messages->links() }}
    </div>
@endif

@endsection
