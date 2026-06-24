@extends('admin.layouts.app')

@section('title', 'Порака — ' . $message->name)
@section('page-title', 'Порака од: ' . $message->name)

@section('page-actions')
    <a href="{{ route('admin.messages.index') }}"
       class="text-sm text-stone hover:text-ink transition-colors">
        ← Назад кон пораките
    </a>
@endsection

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Message content --}}
    <div class="lg:col-span-2 space-y-5">

        <div class="bg-white border border-border rounded-xl p-6">
            <h2 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Порака</h2>
            <p class="text-sm text-ink whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
        </div>

        {{-- Reply button --}}
        <div class="bg-white border border-border rounded-xl p-5">
            <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-3">Одговори</h3>
            <a href="mailto:{{ $message->email }}?subject=Re: Порака преку financebuddy.mk&body=Почитуван/а {{ $message->name }},%0A%0A"
               class="inline-flex items-center gap-2 bg-brand-orange hover:bg-brand-orange-dark text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Одговори преку е-маил
            </a>
            <p class="mt-2 text-xs text-stone">Се отвора вашиот е-маил клиент со предефиниран субјект.</p>
        </div>

    </div>

    {{-- Sidebar: meta + status --}}
    <div class="space-y-5">

        {{-- Contact info --}}
        <div class="bg-white border border-border rounded-xl p-5">
            <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Контакт</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs text-stone">Ime и презиме</dt>
                    <dd class="font-medium text-ink mt-0.5">{{ $message->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-stone">Е-маил</dt>
                    <dd class="mt-0.5">
                        <a href="mailto:{{ $message->email }}"
                           class="text-brand-orange hover:underline break-all">
                            {{ $message->email }}
                        </a>
                    </dd>
                </div>
                @if($message->phone)
                    <div>
                        <dt class="text-xs text-stone">Телефон</dt>
                        <dd class="text-ink mt-0.5">{{ $message->phone }}</dd>
                    </div>
                @endif
                @if($message->service_interest)
                    <div>
                        <dt class="text-xs text-stone">Интерес за услуга</dt>
                        <dd class="text-ink mt-0.5">{{ $message->service_interest }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Meta --}}
        <div class="bg-white border border-border rounded-xl p-5">
            <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Метаподатоци</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs text-stone">Примено</dt>
                    <dd class="text-ink mt-0.5">{{ $message->created_at->format('d.m.Y H:i') }}</dd>
                </div>
                @if($message->ip_address)
                    <div>
                        <dt class="text-xs text-stone">IP адреса</dt>
                        <dd class="text-ink font-mono text-xs mt-0.5">{{ $message->ip_address }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Status update --}}
        <div class="bg-white border border-border rounded-xl p-5">
            <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Статус</h3>

            @php
                $statusLabels = [
                    'new'      => ['label' => 'Ново',       'class' => 'bg-orange-100 text-orange-700'],
                    'read'     => ['label' => 'Прочитано',  'class' => 'bg-stone/10 text-stone'],
                    'replied'  => ['label' => 'Одговорено', 'class' => 'bg-blue-100 text-blue-700'],
                    'archived' => ['label' => 'Архивирано', 'class' => 'bg-gray-100 text-gray-500'],
                ];
                $s = $statusLabels[$message->status] ?? $statusLabels['read'];
            @endphp

            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium {{ $s['class'] }} mb-4">
                {{ $s['label'] }}
            </span>

            <form method="POST" action="{{ route('admin.messages.update-status', $message) }}"
                  class="space-y-2">
                @csrf
                @method('PATCH')

                <select name="status"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-orange">
                    <option value="new"      {{ $message->status === 'new'      ? 'selected' : '' }}>Ново</option>
                    <option value="read"     {{ $message->status === 'read'     ? 'selected' : '' }}>Прочитано</option>
                    <option value="replied"  {{ $message->status === 'replied'  ? 'selected' : '' }}>Одговорено</option>
                    <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Архивирано</option>
                </select>

                <button type="submit"
                        class="w-full bg-ink hover:bg-stone text-white text-sm font-medium py-2 rounded-lg transition-colors">
                    Ажурирај статус
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
