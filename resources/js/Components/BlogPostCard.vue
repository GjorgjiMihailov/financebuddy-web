<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    post: Object,
})

function formatDate(dateString) {
    if (!dateString) return ''
    return new Intl.DateTimeFormat('mk-MK', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }).format(new Date(dateString))
}
</script>

<template>
    <article class="group flex flex-col overflow-hidden rounded-2xl border border-border bg-paper transition-shadow duration-200 hover:shadow-lg">
        <!-- Featured image -->
        <div class="relative aspect-video overflow-hidden bg-paper-warm">
            <img
                v-if="post.featured_image_path"
                :src="`/storage/${post.featured_image_path}`"
                :alt="post.title"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            >
            <div v-else class="flex h-full w-full items-center justify-center">
                <svg class="h-12 w-12 text-border" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <div class="flex flex-1 flex-col gap-3 p-6">
            <!-- Category badge -->
            <div v-if="post.category">
                <Link
                    :href="route('blog.category', post.category.slug)"
                    class="inline-block rounded-full bg-brand-orange/10 px-3 py-1 text-xs font-medium text-brand-orange transition-colors hover:bg-brand-orange/20"
                >
                    {{ post.category.name }}
                </Link>
            </div>

            <!-- Title -->
            <h3 class="font-display text-h3 font-semibold leading-snug text-ink transition-colors group-hover:text-brand-orange">
                <Link
                    :href="route('blog.show', post.slug)"
                    class="focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                >
                    {{ post.title }}
                </Link>
            </h3>

            <!-- Excerpt -->
            <p v-if="post.excerpt" class="line-clamp-3 flex-1 text-sm leading-relaxed text-stone">
                {{ post.excerpt }}
            </p>

            <!-- Date + reading time -->
            <div class="mt-auto flex items-center gap-3 border-t border-border pt-4 text-xs text-stone">
                <time :datetime="post.published_at">{{ formatDate(post.published_at) }}</time>
                <span aria-hidden="true">·</span>
                <span>{{ post.reading_time }} мин читање</span>
            </div>
        </div>
    </article>
</template>
