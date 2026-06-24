@extends('admin.layouts.app')

@section('title', 'Нов пост')
@section('page-title', 'Нов пост')

@section('page-actions')
    <a href="{{ route('admin.posts.index') }}"
       class="text-sm text-stone hover:text-ink transition-colors">
        ← Назад кон листата
    </a>
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
      action="{{ route('admin.posts.store') }}"
      enctype="multipart/form-data"
      class="space-y-6">
    @csrf

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
                    value="{{ old('title') }}"
                    required
                    autofocus
                    placeholder="Наслов на постот..."
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
                        value="{{ old('slug') }}"
                        required
                        data-manual="false"
                        placeholder="avtomatski-generiran-slug"
                        class="flex-1 border rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-orange
                               {{ $errors->has('slug') ? 'border-red-400' : 'border-border' }}"
                    >
                </div>
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-stone">Автоматски се генерира од насловот. Можете да го уредите рачно.</p>
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
                    placeholder="Краток опис за листата на блогот и meta description (макс. 500 знаци)..."
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange resize-none"
                >{{ old('excerpt') }}</textarea>
            </div>

            {{-- Content (EasyMDE) --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <label for="content" class="block text-xs font-semibold text-stone uppercase tracking-wide mb-2">
                    Содржина (Markdown) <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="content"
                    name="content"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO (collapsible) --}}
            <details class="bg-white border border-border rounded-xl overflow-hidden">
                <summary class="px-5 py-3.5 cursor-pointer text-xs font-semibold text-stone uppercase tracking-wide select-none hover:bg-paper-warm transition-colors">
                    SEO (опционо)
                </summary>
                <div class="px-5 pb-5 pt-4 space-y-4 border-t border-border">
                    <div>
                        <label for="meta_title" class="block text-xs font-medium text-ink mb-1">
                            Meta наслов <span class="text-stone">(fallback: главниот наслов)</span>
                        </label>
                        <input
                            id="meta_title"
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title') }}"
                            maxlength="255"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                        >
                    </div>
                    <div>
                        <label for="meta_description" class="block text-xs font-medium text-ink mb-1">
                            Meta опис <span class="text-stone">(fallback: кратко резиме)</span>
                        </label>
                        <textarea
                            id="meta_description"
                            name="meta_description"
                            rows="2"
                            maxlength="500"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange resize-none"
                        >{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </details>

        </div>

        {{-- Right column: sidebar --}}
        <div class="space-y-5">

            {{-- Publish --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-4">Статус и објавување</h3>

                <div class="flex gap-3 mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="draft"
                               {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                               class="text-brand-orange focus:ring-brand-orange">
                        <span class="text-sm">Нацрт</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="published"
                               {{ old('status') === 'published' ? 'checked' : '' }}
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
                        value="{{ old('published_at') }}"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                    >
                    <p class="mt-1 text-xs text-stone">Остави празно за тековен датум.</p>
                </div>

                <div class="mt-4 pt-4 border-t border-border flex flex-col gap-2">
                    <button type="submit"
                            class="w-full bg-brand-orange hover:bg-brand-orange-dark text-white text-sm font-semibold py-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
                        Зачувај пост
                    </button>
                    <a href="{{ route('admin.posts.index') }}"
                       class="w-full text-center border border-border hover:border-stone text-ink text-sm py-2 rounded-lg transition-colors">
                        Откажи
                    </a>
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
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                    value="{{ old('author_name', auth()->user()->name) }}"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange"
                >
            </div>

            {{-- Featured image --}}
            <div class="bg-white border border-border rounded-xl p-5">
                <h3 class="text-xs font-semibold text-stone uppercase tracking-wide mb-3">Главна слика</h3>
                <input
                    type="file"
                    name="featured_image"
                    id="featured_image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full text-sm text-stone file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-paper-warm file:text-ink hover:file:bg-border cursor-pointer"
                >
                <p class="mt-2 text-xs text-stone">JPG, PNG или WebP · макс. 5MB</p>
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
    // EasyMDE init
    const easyMDE = new EasyMDE({
        element: document.getElementById('content'),
        spellChecker: false,
        autosave: { enabled: true, uniqueId: 'new-post-content', delay: 3000 },
        toolbar: ['bold','italic','heading','|','quote','unordered-list','ordered-list','|','link','image','|','preview','side-by-side','fullscreen','|','guide'],
        status: ['autosave', 'lines', 'words'],
        placeholder: 'Пишете го постот во Markdown формат...',
    });

    // Slug auto-generation
    const titleInput = document.getElementById('title');
    const slugInput  = document.getElementById('slug');

    function makeSlug(str) {
        return str
            .toLowerCase()
            .replace(/[áàäâ]/g, 'a').replace(/[éèëê]/g, 'e')
            .replace(/[íìïî]/g, 'i').replace(/[óòöô]/g, 'o')
            .replace(/[úùüû]/g, 'u')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    titleInput.addEventListener('input', function () {
        if (slugInput.dataset.manual === 'false') {
            slugInput.value = makeSlug(this.value);
        }
    });

    slugInput.addEventListener('input', function () {
        this.dataset.manual = 'true';
    });

    // New category toggle
    const categorySelect    = document.getElementById('category_id');
    const newCategoryField  = document.getElementById('new-category-field');
    const newCategoryInput  = document.getElementById('new_category');

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
