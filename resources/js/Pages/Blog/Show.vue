<script setup>
import { computed, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BlogPostCard from '@/Components/BlogPostCard.vue'

defineOptions({ layout: PublicLayout })

const props = defineProps({
    post: Object,
    relatedPosts: Array,
})

const metaTitle = computed(() => props.post.meta_title || `${props.post.title} | FinanceBuddy.mk`)
const metaDescription = computed(() => props.post.meta_description || props.post.excerpt || '')
const canonicalUrl = computed(() => `https://financebuddy.mk/blog/${props.post.slug}`)
const ogImage = computed(() =>
    props.post.og_image_path
        ? `https://financebuddy.mk/storage/${props.post.og_image_path}`
        : 'https://financebuddy.mk/images/og-default.jpg',
)

function formatDate(dateString) {
    if (!dateString) return ''
    return new Intl.DateTimeFormat('mk-MK', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }).format(new Date(dateString))
}

onMounted(() => {
    // Article JSON-LD schema — следи го Faq.vue патернот
    const schema = document.createElement('script')
    schema.type = 'application/ld+json'
    schema.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Article',
        headline: props.post.title,
        description: metaDescription.value,
        image: ogImage.value,
        author: {
            '@type': 'Person',
            name: props.post.author_name,
        },
        publisher: {
            '@type': 'Organization',
            name: 'FinanceBuddy.mk',
            logo: {
                '@type': 'ImageObject',
                url: 'https://financebuddy.mk/images/logofaktura.png',
            },
        },
        datePublished: props.post.published_at,
        dateModified: props.post.updated_at,
        url: canonicalUrl.value,
        inLanguage: 'mk',
        articleSection: props.post.category?.name,
    })
    document.head.appendChild(schema)

    const breadcrumb = document.createElement('script')
    breadcrumb.type = 'application/ld+json'
    const crumbs = [
        { '@type': 'ListItem', position: 1, name: 'Дома', item: 'https://financebuddy.mk' },
        { '@type': 'ListItem', position: 2, name: 'Блог', item: 'https://financebuddy.mk/blog' },
    ]
    if (props.post.category) {
        crumbs.push({ '@type': 'ListItem', position: 3, name: props.post.category.name, item: `https://financebuddy.mk/blog/kategorija/${props.post.category.slug}` })
    }
    crumbs.push({ '@type': 'ListItem', position: crumbs.length + 1, name: props.post.title, item: canonicalUrl.value })
    breadcrumb.textContent = JSON.stringify({ '@context': 'https://schema.org', '@type': 'BreadcrumbList', itemListElement: crumbs })
    document.head.appendChild(breadcrumb)
})
</script>

<template>
    <Head>
        <title>{{ metaTitle }}</title>
        <meta name="description" :content="metaDescription" />
        <link rel="canonical" :href="canonicalUrl" />
        <meta property="og:title" :content="post.meta_title || post.title" />
        <meta property="og:description" :content="metaDescription" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="article" />
        <meta property="og:url" :content="canonicalUrl" />
        <meta property="og:image" :content="ogImage" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- HERO / HEADER -->
    <section class="bg-paper pt-24 pb-12 lg:pt-32 lg:pb-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="mb-8 flex flex-wrap items-center gap-1.5 text-sm text-stone" aria-label="Breadcrumb">
                <Link :href="route('home')" class="transition-colors hover:text-brand-orange">Дома</Link>
                <span aria-hidden="true">›</span>
                <Link :href="route('blog.index')" class="transition-colors hover:text-brand-orange">Блог</Link>
                <template v-if="post.category">
                    <span aria-hidden="true">›</span>
                    <Link :href="route('blog.category', post.category.slug)" class="transition-colors hover:text-brand-orange">
                        {{ post.category.name }}
                    </Link>
                </template>
            </nav>

            <!-- Category + reading time -->
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <Link
                    v-if="post.category"
                    :href="route('blog.category', post.category.slug)"
                    class="rounded-full bg-brand-orange/10 px-3 py-1 text-sm font-medium text-brand-orange transition-colors hover:bg-brand-orange/20"
                >
                    {{ post.category.name }}
                </Link>
                <span class="text-sm text-stone">{{ post.reading_time }} мин читање</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-display-2 leading-tight text-ink">
                {{ post.title }}
            </h1>

            <!-- Excerpt -->
            <p v-if="post.excerpt" class="mt-6 text-xl leading-relaxed text-stone">
                {{ post.excerpt }}
            </p>

            <!-- Author + date -->
            <div class="mt-8 flex items-center gap-4 border-t border-border pt-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-orange/10 text-sm font-semibold text-brand-orange"
                    aria-hidden="true"
                >
                    {{ post.author_name.charAt(0) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-ink">{{ post.author_name }}</p>
                    <time class="text-xs text-stone" :datetime="post.published_at">
                        {{ formatDate(post.published_at) }}
                    </time>
                </div>
            </div>

        </div>
    </section>

    <!-- FEATURED IMAGE -->
    <div v-if="post.featured_image_path" class="bg-paper-warm">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <img
                :src="`/storage/${post.featured_image_path}`"
                :alt="post.title"
                class="w-full rounded-2xl object-cover shadow-sm"
                style="max-height: 480px"
            >
        </div>
    </div>

    <!-- CONTENT -->
    <section class="bg-paper-warm py-12 lg:py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- eslint-disable-next-line vue/no-v-html -->
            <div class="prose prose-stone max-w-none" v-html="post.html_content" />
        </div>
    </section>

    <!-- ПОВРЗАНИ ПОСТОВИ -->
    <section v-if="relatedPosts.length > 0" class="border-t border-border bg-paper py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-10 font-display text-display-2 text-ink">Поврзани текстови</h2>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <BlogPostCard
                    v-for="relPost in relatedPosts"
                    :key="relPost.id"
                    :post="relPost"
                />
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Потребна ти е помош?</p>
            <h2 class="mt-2 font-display text-display-2 text-paper">Закажи бесплатна консултација.</h2>
            <p class="mt-4 text-lg text-stone">Конкретни одговори за вашата ситуација — без обврски.</p>
            <Link
                :href="route('contact.index')"
                class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-orange px-8 py-4 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 focus-visible:ring-offset-ink"
            >
                Контактирај нè
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </Link>
        </div>
    </section>
</template>
