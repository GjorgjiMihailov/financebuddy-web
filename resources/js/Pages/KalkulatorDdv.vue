<script setup>
import { onBeforeUnmount, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import VatCalculator from '@/Components/VatCalculator.vue'
import { VAT, computeVat, formatMoney } from '@/Utils/vat'

defineOptions({ layout: PublicLayout })

const PAGE_URL = 'https://financebuddy.mk/kalkulator-ddv'
const DESCRIPTION =
    'Бесплатен калкулатор за ДДВ со ставките 5%, 10% и 18%. Пресметајте износ со ДДВ од износ без ДДВ и обратно. Преземете PDF.'

const m = (n) => formatMoney(n)
const ex = (key, value, rate) => computeVat(key, value, rate)

const rateGuide = [
    {
        rate: '18%',
        title: 'Општа стапка',
        text: 'Се применува на повеќето стоки и услуги, вклучително дигитални услуги и софтвер како услуга.',
    },
    {
        rate: '10%',
        title: 'Повластена стапка',
        text: 'Угостителски услуги (ресторани и кетеринг, освен алкохолни пијалаци) и одредени прехранбени производи што не се основни.',
    },
    {
        rate: '5%',
        title: 'Повластена стапка',
        text: 'Основни прехранбени производи, лекови, книги и публикации, вода за пиење од јавни водоводи, компјутери и софтвер, како и сместување во хотели и слични објекти.',
    },
]

const faq = [
    {
        q: 'Кои стапки на ДДВ постојат во Северна Македонија?',
        a: 'Општата стапка на ДДВ е 18%. Покрај неа се применуваат две повластени стапки: 5% и 10%, за одредени стоки и услуги определени со Законот за данокот на додадена вредност.',
    },
    {
        q: 'Како се пресметува износ со ДДВ од износ без ДДВ?',
        a: `Износот без ДДВ се множи со (1 + стапка/100). На пример, ${m(100000)} денари без ДДВ при стапка од 18% е ${m(ex('net', 100000, 18).gross)} денари со ДДВ, а ДДВ е ${m(ex('net', 100000, 18).vat)} денари.`,
    },
    {
        q: 'Како се пресметува износ без ДДВ од износ со ДДВ?',
        a: `Износот со ДДВ се дели со (1 + стапка/100), а ДДВ е разликата. На пример, ${m(118000)} денари со ДДВ при стапка од 18% е ${m(ex('gross', 118000, 18).net)} денари без ДДВ, а ДДВ е ${m(ex('gross', 118000, 18).vat)} денари.`,
    },
    {
        q: 'Што е ДДВ од 5%, а што од 10%?',
        a: 'Стапката од 5% се применува на основни прехранбени производи, лекови, книги, вода за пиење, компјутери и софтвер, како и на сместување во хотели и слични објекти. Стапката од 10% се применува на угостителски услуги (без алкохолни пијалаци) и на одредени прехранбени производи што не се основни. Точното рангирање на конкретна стока или услуга е според Законот за ДДВ.',
    },
    {
        q: 'Може ли да внесам само износот на ДДВ?',
        a: 'Да. Секое од трите полиња е уредливо. Ако го знаете износот на ДДВ и стапката, внесете го во полето „ДДВ“ и калкулаторот ги пресметува износот без ДДВ и износот со ДДВ.',
    },
    {
        q: 'Дали пресметката е точна?',
        a: 'Калкулаторот ги користи наведените стапки и износите ги заокружува на две децимали. Резултатот е информативен. За конкретен случај, на пример за ДДВ-04 пријава или фактурирање, консултирајте се со овластен сметководител.',
    },
]

// JSON-LD (како во другите страници: се додава во <head>, а се чисти при напуштање на страната)
const schemaNodes = []

onMounted(() => {
    const schemas = [
        {
            '@context': 'https://schema.org',
            '@type': 'WebApplication',
            name: 'Калкулатор за ДДВ',
            url: PAGE_URL,
            description: DESCRIPTION,
            applicationCategory: 'FinanceApplication',
            operatingSystem: 'Web',
            inLanguage: 'mk',
            offers: { '@type': 'Offer', price: '0', priceCurrency: 'MKD' },
            publisher: { '@type': 'Organization', name: 'FinanceBuddy.mk', url: 'https://financebuddy.mk' },
        },
        {
            '@context': 'https://schema.org',
            '@type': 'FAQPage',
            inLanguage: 'mk',
            mainEntity: faq.map((item) => ({
                '@type': 'Question',
                name: item.q,
                acceptedAnswer: { '@type': 'Answer', text: item.a },
            })),
        },
        {
            '@context': 'https://schema.org',
            '@type': 'BreadcrumbList',
            itemListElement: [
                { '@type': 'ListItem', position: 1, name: 'Почетна', item: 'https://financebuddy.mk' },
                { '@type': 'ListItem', position: 2, name: 'Калкулатор за ДДВ', item: PAGE_URL },
            ],
        },
    ]

    schemas.forEach((schema) => {
        const node = document.createElement('script')
        node.type = 'application/ld+json'
        node.textContent = JSON.stringify(schema)
        document.head.appendChild(node)
        schemaNodes.push(node)
    })
})

onBeforeUnmount(() => {
    schemaNodes.forEach((node) => node.remove())
})
</script>

<template>
    <Head>
        <title>Калкулатор за ДДВ: 5%, 10% и 18%</title>
        <meta name="description" :content="DESCRIPTION" />
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large" />
        <link rel="canonical" :href="PAGE_URL" />
        <meta property="og:title" content="Калкулатор за ДДВ: 5%, 10% и 18% | FinanceBuddy.mk" />
        <meta property="og:description" :content="DESCRIPTION" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" :content="PAGE_URL" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper pt-16 pb-10 lg:pt-24 lg:pb-14">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-stone" aria-label="Breadcrumb">
                <Link :href="route('home')" class="hover:text-brand-orange">Почетна</Link>
                <span class="mx-2" aria-hidden="true">›</span>
                <span class="text-ink">Калкулатор за ДДВ</span>
            </nav>
            <h1 class="font-display text-display-1 leading-tight text-ink">
                Калкулатор за ДДВ: од нето во бруто и од бруто во нето
            </h1>
            <p class="mt-6 max-w-3xl text-lg text-stone">
                Бесплатен онлајн калкулатор за ДДВ со сите три стапки во Северна Македонија: 5%, 10% и 18%.
                Внесете износ без ДДВ и добијте износ со ДДВ, или внесете износ со ДДВ и добијте колку е ДДВ и колку е износот без ДДВ.
                Работи во сите насоки, а резултатот можете да го преземете како PDF.
            </p>
        </div>
    </section>

    <!-- 2. КАЛКУЛАТОР -->
    <section class="bg-paper-warm py-10 lg:py-14" aria-label="Калкулатор за ДДВ">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <VatCalculator />
        </div>
    </section>

    <!-- 3. ОБЈАСНУВАЊЕ -->
    <section class="bg-paper py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-h3 font-semibold text-ink">Калкулации во сите насоки</h2>
            <ul class="mt-4 space-y-2 text-stone">
                <li><strong class="text-ink">Од нето во бруто:</strong> внесете износ без ДДВ и добивате ДДВ и износ со ДДВ.</li>
                <li><strong class="text-ink">Од бруто во нето:</strong> внесете износ со ДДВ и добивате износ без ДДВ и колку е ДДВ.</li>
                <li><strong class="text-ink">Од износот на ДДВ:</strong> внесете само ДДВ и стапката, а износите без и со ДДВ се пресметуваат.</li>
            </ul>

            <h2 class="mt-14 font-display text-h3 font-semibold text-ink">Ставки на ДДВ во {{ new Date().getFullYear() }} година</h2>
            <div class="mt-5 space-y-4">
                <div
                    v-for="item in rateGuide"
                    :key="item.rate"
                    class="flex gap-4 rounded-2xl border border-border bg-paper-warm p-5"
                >
                    <span class="font-display text-2xl font-bold text-brand-orange">{{ item.rate }}</span>
                    <div>
                        <p class="font-semibold text-ink">{{ item.title }}</p>
                        <p class="mt-1 text-stone">{{ item.text }}</p>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-sm text-stone">
                Примерите се информативни. Која стапка важи за конкретна стока или услуга се определува според Законот за данокот на додадена вредност.
            </p>

            <h2 class="mt-14 font-display text-h3 font-semibold text-ink">Како се пресметува ДДВ</h2>
            <ul class="mt-4 space-y-2 text-stone">
                <li><strong class="text-ink">Износ со ДДВ</strong> = износ без ДДВ × (1 + стапка / 100)</li>
                <li><strong class="text-ink">Износ без ДДВ</strong> = износ со ДДВ ÷ (1 + стапка / 100)</li>
                <li><strong class="text-ink">ДДВ</strong> = износ со ДДВ − износ без ДДВ</li>
            </ul>
            <div class="mt-6 rounded-2xl border border-border bg-paper-warm p-5 text-stone">
                <strong class="text-ink">Пример со {{ m(100000) }} денари без ДДВ:</strong>
                <ul class="mt-2 space-y-1">
                    <li v-for="rate in VAT.rates" :key="rate">
                        При {{ rate }}%: ДДВ {{ m(ex('net', 100000, rate).vat) }}, износ со ДДВ
                        <strong class="text-ink">{{ m(ex('net', 100000, rate).gross) }} денари</strong>.
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 4. FAQ -->
    <section class="border-t border-border bg-paper-warm py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-6 font-display text-h3 font-semibold text-ink">Често поставувани прашања</h2>
            <div class="overflow-hidden rounded-2xl border border-border bg-paper">
                <details v-for="item in faq" :key="item.q" class="group border-b border-border last:border-b-0">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-orange">
                        <span class="font-semibold text-ink">{{ item.q }}</span>
                        <svg class="h-5 w-5 shrink-0 text-stone transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="border-t border-border/60 bg-paper-warm px-6 py-5">
                        <p class="text-base leading-relaxed text-stone">{{ item.a }}</p>
                    </div>
                </details>
            </div>
            <p class="mt-6 text-sm text-stone">
                Последно ажурирано: {{ VAT.updated }}. Пресметката е информативна и не претставува сметководствен или даночен совет.
            </p>

            <div class="mt-10 flex flex-col gap-4 rounded-2xl border border-border bg-paper p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Друга бесплатна алатка</p>
                    <p class="mt-1 font-semibold text-ink">Калкулатор за плата 2026: бруто во нето и нето во бруто</p>
                </div>
                <Link
                    :href="route('salary-calculator')"
                    class="inline-flex shrink-0 items-center gap-2 font-semibold text-brand-orange transition-colors hover:text-brand-orange-dark focus-visible:rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                >
                    Отвори го калкулаторот →
                </Link>
            </div>
        </div>
    </section>

    <!-- 5. CTA -->
    <section class="bg-ink py-16 lg:py-24">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Сметководство и ДДВ</p>
            <h2 class="mt-2 font-display text-display-2 text-paper">Ви треба помош со ДДВ за вашата фирма?</h2>
            <p class="mt-4 text-lg text-stone">
                Книги на излезни и влезни фактури, ДДВ-04 пријава и комуникација со УЈП — навреме и без грешки.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <Link
                    :href="route('services.show', 'finansisko-smetkovodstvo')"
                    class="inline-flex items-center gap-2 rounded-full bg-brand-orange px-8 py-4 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 focus-visible:ring-offset-ink"
                >
                    Погледни ја услугата
                </Link>
                <Link
                    :href="route('contact.index')"
                    class="inline-flex items-center gap-2 rounded-full border border-paper/30 px-8 py-4 font-semibold text-paper transition hover:border-paper focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                >
                    Контактирај нè
                </Link>
            </div>
        </div>
    </section>
</template>
