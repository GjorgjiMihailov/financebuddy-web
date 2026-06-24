<script setup>
import { onMounted, computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

const props = defineProps({
    service: Object,
})

const kontaktUrl = computed(() => `/kontakt?usluga=${encodeURIComponent(props.service.name)}`)

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => entries.forEach(e => e.target.classList.toggle('revealed', e.isIntersecting)),
        { threshold: 0.1 },
    )
    document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el))

    const schema = document.createElement('script')
    schema.type = 'application/ld+json'
    schema.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Service',
        name: props.service.name,
        description: props.service.shortDesc,
        url: `https://financebuddy.mk/uslugi/${props.service.slug}`,
        provider: {
            '@type': 'ProfessionalService',
            name: 'FinanceBuddy.mk',
            url: 'https://financebuddy.mk',
            telephone: '+38977881701',
            address: {
                '@type': 'PostalAddress',
                streetAddress: 'ул. Венијамин Мачуковски бр. 34/1-50',
                addressLocality: 'Скопје',
                addressRegion: 'Аеродром',
                postalCode: '1000',
                addressCountry: 'MK',
            },
        },
        areaServed: 'MK',
        inLanguage: 'mk',
    })
    document.head.appendChild(schema)
})
</script>

<template>
    <Head>
        <title>{{ service.name }} | FinanceBuddy.mk</title>
        <meta name="description" :content="service.metaDesc" />
        <link rel="canonical" :href="`https://financebuddy.mk/uslugi/${service.slug}`" />
        <meta property="og:title" :content="`${service.name} | FinanceBuddy.mk`" />
        <meta property="og:description" :content="service.metaDesc" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" :content="`https://financebuddy.mk/uslugi/${service.slug}`" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper-warm pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav
                class="animate-fade-up mb-8 flex items-center gap-2 text-sm text-stone"
                aria-label="Breadcrumb"
                style="animation-delay: 0ms"
            >
                <Link href="/" class="transition-colors hover:text-brand-orange">Дома</Link>
                <span aria-hidden="true">/</span>
                <Link href="/uslugi" class="transition-colors hover:text-brand-orange">Услуги</Link>
                <span aria-hidden="true">/</span>
                <span class="text-ink">{{ service.name }}</span>
            </nav>

            <div class="max-w-3xl">
                <span
                    class="animate-fade-up mb-4 inline-block font-mono text-sm font-bold text-brand-orange"
                    style="animation-delay: 40ms"
                >
                    {{ service.num }}
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    {{ service.name }}
                </h1>
                <p
                    class="animate-fade-up mt-6 max-w-2xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    {{ service.shortDesc }}
                </p>
                <div class="animate-fade-up mt-8" style="animation-delay: 240ms">
                    <Link
                        :href="kontaktUrl"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-orange px-6 py-3 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                    >
                        Побарај понуда
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. ШТО ДОБИВАТЕ -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Вклучено</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Што добивате</h2>
            </div>

            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <li
                    v-for="benefit in service.benefits"
                    :key="benefit"
                    class="flex items-start gap-3 rounded-xl border border-border bg-paper-warm p-4"
                    data-reveal
                >
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-base text-ink">{{ benefit }}</span>
                </li>
            </ul>

        </div>
    </section>

    <!-- 3. ЗА КОГО Е НАМЕНЕТО -->
    <section class="bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">

                <div data-reveal>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Целна група</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">За кого е наменето</h2>
                </div>

                <div data-reveal>
                    <p class="text-lg leading-relaxed text-stone">{{ service.forWho }}</p>
                    <Link
                        :href="kontaktUrl"
                        class="mt-6 inline-flex items-center gap-2 font-semibold text-brand-orange transition-colors duration-150 hover:text-brand-orange-dark focus-visible:rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        Закажи бесплатна консултација
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. CTA -->
    <section class="bg-brand-orange py-16 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <h2 class="font-display text-display-2 text-white">Спремни да почнеме?</h2>
            <p class="mt-4 text-lg text-white/80">
                Закажи бесплатна консултација — без обврски, без скриени трошоци.
            </p>
            <Link
                :href="kontaktUrl"
                class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-semibold text-brand-orange transition-all duration-150 hover:bg-paper focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-orange"
            >
                Контактирај нè
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </Link>
        </div>
    </section>
</template>
