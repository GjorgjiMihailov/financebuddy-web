@extends('admin.layouts.app')

@section('title', 'Уреди пост')
@section('page-title', 'Уреди: ' . Str::limit($post->title, 50))

@section('page-actions')
    <div class="flex items-center gap-3">
        @if($post->status === 'published')
            <a href="{{ route('blog.show', $post) }}"
               target="_blank"
               class="text-xs text-stone hover:text-ink transition-colors">
                Прегледај на сајтот ↗
            </a>
        @endif
        <a href="{{ route('admin.posts.index') }}"
           class="text-sm text-stone hover:text-ink transition-colors">
            ← Назад кон листата
        </a>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
<style>
    .EasyMDEContainer .CodeMirror { min-height: 320px; font-size: 14px; }
    .editor-toolbar { border-color: #E5DDD0; }
    .CodeMirror { border-color: #E5DDD0; }
</style>
@endpush

@section('content')

<form method="POST"
      action="{{ route('admin.posts.update', $post) }}"
      enctype="multipart/form-data"
      class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left column: main content --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Title --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="title" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Наслов <span class="text-red-500">*</span>
                </label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    required
                    autofocus
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange
                           {{ $errors->has('title') ? 'border-red-400' : 'border-border' }}"
                >
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="slug" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Slug (URL) <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-stone flex-shrink-0">/blog/</span>
                    <input
                        id="slug"
                        type="text"
                        name="slug"
                        value="{{ old('slug', $post->slug) }}"
                        required
                        data-manual="true"
                        class="flex-1 border rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-orange
                               {{ $errors->has('slug') ? 'border-red-400' : 'border-border' }}"
                    >
                </div>
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-stone">Внимавај при промена — менувањето на slug-от ги крши постоечките линкови.</p>
            </div>

            {{-- Excerpt --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="excerpt" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Кратко резиме
                </label>
                <textarea
                    id="excerpt"
                    name="excerpt"
                    rows="3"
                    maxlength="500"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange resize-none"
                >{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            {{-- Content --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="content" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Содржина (Markdown) <span class="text-red-500">*</span>
                </label>
                <textarea id="content" name="content">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO --}}
            <details class="bg-white border border-border rounded-xl overflow-hidden" {{ old('meta_title', $post->meta_title) ? 'open' : '' }}>
                <summary class="px-5 py-3.5 cursor-pointer text-xs font-semibold text-stone uppercase tracking-wide select-none hover:bg-paper-warm transition-colors">
                    SEO (опционо)
                </summary>
                <div class="px-5 pb-5 pt-4 space-y-4 border-t border-border">
                    <div>
                        <label for="meta_title" class="block text-xs font-medium text-ink mb-1">
                            Meta наслов
                        </label>
                        <input
                            id="meta_title"
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title', $post->meta_title) }}"
                            maxlength="255"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                        >
                    </div>
                    <div>
                        <label for="meta_description" class="block text-xs font-medium text-ink mb-1">
                            Meta опис
                        </label>
                        <textarea
                            id="meta_description"
                            name="meta_description"
                            rows="2"
                            maxlength="500"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange resize-none"
                        >{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </details>

        </div>

        {{-- Right column --}}
        <div class="space-y-5">

            {{-- Publish --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Статус и објавување</h3>

                <div class="flex gap-3 mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="draft"
                               {{ old('status', $post->status) === 'draft' ? 'checked' : '' }}
                               class="text-brand-orange focus:ring-brand-orange">
                        <span class="text-sm">Нацрт</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="published"
                               {{ old('status', $post->status) === 'published' ? 'checked' : '' }}
                               class="text-brand-orange focus:ring-brand-orange">
                        <span class="text-sm">Објавено</span>
                    </label>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-medium text-ink mb-1">
                        Датум на објавување
                    </label>
                    <input
                        id="published_at"
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                    >
                </div>

                <div class="mt-4 pt-4 border-t border-border flex flex-col gap-2">
                    <button type="submit"
                            class="w-full bg-brand-orange hover:bg-brand-orange-dark text-white text-sm font-semibold py-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
                        Зачувај промени
                    </button>
                </div>

                <div class="mt-3 pt-3 border-t border-border">
                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                          onsubmit="return confirm('Сигурно сакате да го избришете овој пост? Оваа акција е неповратна.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full text-center text-xs text-red-500 hover:text-red-700 py-1 transition-colors">
                            Избриши пост
                        </button>
                    </form>
                </div>
            </div>

            {{-- Category --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-3">Категорија</h3>

                <select
                    id="category_id"
                    name="category_id"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange mb-3"
                >
                    <option value="">— без категорија —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                                {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                    <option value="__new__">+ Нова категорија...</option>
                </select>

                <div id="new-category-field" class="hidden">
                    <input
                        type="text"
                        name="new_category"
                        id="new_category"
                        placeholder="Внесете ново ime на категорија"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                    >
                </div>
            </div>

            {{-- Author --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="author_name" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Автор
                </label>
                <input
                    id="author_name"
                    type="text"
                    name="author_name"
                    value="{{ old('author_name', $post->author_name) }}"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                >
            </div>

            {{-- Featured image --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-3">Главна слика</h3>

                @if($post->featured_image_path)
                    <div class="mb-3">
                        <img src="{{ Storage::url($post->featured_image_path) }}"
                             alt="Тековна главна слика"
                             class="w-full h-32 object-cover rounded-lg border border-border">
                    </div>
                @endif

                <input
                    type="file"
                    name="featured_image"
                    id="featured_image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full text-sm text-stone file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-paper-warm file:text-ink hover:file:bg-border cursor-pointer"
                >
                <p class="mt-2 text-xs text-stone">
                    {{ $post->featured_image_path ? 'Прикачи нова слика за да ја замениш постојната.' : 'JPG, PNG или WebP · макс. 5MB' }}
                </p>
                @error('featured_image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
<script>
    const easyMDE = new EasyMDE({
        element: document.getElementById('content'),
        spellChecker: false,
        autosave: { enabled: true, uniqueId: 'edit-post-{{ $post->id }}', delay: 3000 },
        toolbar: ['bold','italic','heading','|','quote','unordered-list','ordered-list','|','link','image','|','preview','side-by-side','fullscreen','|','guide'],
        status: ['autosave', 'lines', 'words'],
    });

    // New category toggle
    const categorySelect   = document.getElementById('category_id');
    const newCategoryField = document.getElementById('new-category-field');
    const newCategoryInput = document.getElementById('new_category');

    categorySelect.addEventListener('change', function () {
        if (this.value === '__new__') {
            newCategoryField.classList.remove('hidden');
            newCategoryInput.required = true;
            this.value = '';
        } else {
            newCategoryField.classList.add('hidden');
            newCategoryInput.required = false;
            newCategoryInput.value = '';
        }
    });
</script>
@endpush
