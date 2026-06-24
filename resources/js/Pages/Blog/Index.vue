<script setup>
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BlogPostCard from '@/Components/BlogPostCard.vue'

defineOptions({ layout: PublicLayout })

defineProps({
    posts: Object,
    categories: Array,
    activeCategory: String,
})
</script>

<template>
    <Head>
        <title>Блог | FinanceBuddy.mk</title>
        <meta name="description" content="Практични совети за сметководство, данок, фриленсерски приходи и деловно работење во Македонија. Читај го FinanceBlog." />
        <link rel="canonical" href="https://financebuddy.mk/blog" />
        <meta property="og:title" content="Блог | FinanceBuddy.mk" />
        <meta property="og:description" content="Практични совети за сметководство, данок и деловно работење во Македонија." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/blog" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- HERO -->
    <section class="bg-paper pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span
                    class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                    style="animation-delay: 0ms"
                >
                    FinanceBlog
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    Совети и увиди за вашиот бизнис.
                </h1>
                <p
                    class="animate-fade-up mx-auto mt-6 max-w-xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    Практични текстови за сметководство, данок и деловно работење во Македонија.
                </p>
            </div>
        </div>
    </section>

    <!-- КАТЕГОРИИ + ПОСТОВИ -->
    <section class="border-t border-border bg-paper-warm py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Category filter -->
            <div v-if="categories.length > 0" class="mb-12 flex flex-wrap gap-2">
                <Link
                    :href="route('blog.index')"
                    :class="[
                        'rounded-full px-4 py-2 text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange',
                        !activeCategory
                            ? 'bg-brand-orange text-white'
                            : 'border border-border bg-paper text-stone hover:border-brand-orange/40 hover:text-brand-orange',
                    ]"
                >
                    Сите
                </Link>
                <Link
                    v-for="cat in categories"
                    :key="cat.id"
                    :href="route('blog.category', cat.slug)"
                    :class="[
                        'rounded-full px-4 py-2 text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange',
                        activeCategory === cat.slug
                            ? 'bg-brand-orange text-white'
                            : 'border border-border bg-paper text-stone hover:border-brand-orange/40 hover:text-brand-orange',
                    ]"
                >
                    {{ cat.name }}
                    <span class="ml-1 opacity-60">({{ cat.published_posts_count }})</span>
                </Link>
            </div>

            <!-- Posts grid -->
            <div v-if="posts.data.length > 0" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <BlogPostCard
                    v-for="post in posts.data"
                    :key="post.id"
                    :post="post"
                />
            </div>

            <!-- Empty state -->
            <div v-else class="py-20 text-center">
                <p class="text-lg text-stone">Нема објавени постови во оваа категорија.</p>
                <Link
                    :href="route('blog.index')"
                    class="mt-4 inline-block font-medium text-brand-orange hover:underline"
                >
                    Прикажи ги сите постови
                </Link>
            </div>

            <!-- Pagination -->
            <nav
                v-if="posts.last_page > 1"
                class="mt-16 flex flex-wrap items-center justify-center gap-2"
                aria-label="Пагинација"
            >
                <template v-for="link in posts.links" :key="link.label">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        :aria-current="link.active ? 'page' : undefined"
                        :class="[
                            'inline-flex h-10 min-w-10 items-center justify-center rounded-full px-3 text-sm font-medium transition-colors',
                            link.active
                                ? 'bg-brand-orange text-white'
                                : 'border border-border bg-paper text-stone hover:border-brand-orange/40 hover:text-brand-orange',
                        ]"
                        v-html="link.label"
                    />
                    <span
                        v-else
                        class="inline-flex h-10 min-w-10 items-center justify-center rounded-full border border-border bg-paper px-3 text-sm font-medium text-stone opacity-40"
                        v-html="link.label"
                    />
                </template>
            </nav>

        </div>
    </section>
</template>
