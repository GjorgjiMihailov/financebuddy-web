<script setup>
import { onBeforeUnmount, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SalaryCalculator from '@/Components/SalaryCalculator.vue'
import { SALARY, CONTRIB_TOTAL_PCT, calcSalary, formatMkd, formatPct } from '@/Utils/salary'

defineOptions({ layout: PublicLayout })

const PAGE_URL = 'https://financebuddy.mk/kalkulator-plata'
const DESCRIPTION =
    'Бесплатен калкулатор за плата 2026. Пресметајте бруто во нето и нето во бруто со сите придонеси и данок на личен доход. Преземете PDF.'

const avg = calcSalary(SALARY.avgGross)
const min = calcSalary(SALARY.minGross)
const pct = (n) => formatPct(n)
const mkd = (n) => formatMkd(n)

const rates = [
    { label: 'Придонес за пензиско и инвалидско осигурување (ПИО)', value: pct(SALARY.pio) },
    { label: 'Придонес за здравствено осигурување', value: pct(SALARY.zdr) },
    { label: 'Придонес за осигурување во случај на невработеност', value: pct(SALARY.nev) },
    { label: 'Дополнителен придонес за повреда на работа и професионално заболување', value: pct(SALARY.povr) },
    { label: 'Вкупно придонеси', value: pct(CONTRIB_TOTAL_PCT), strong: true },
    { label: 'Лично ослободување (месечно)', value: `${mkd(SALARY.personal)} денари` },
    { label: 'Данок на личен доход', value: pct(SALARY.tax) },
]

const faq = [
    {
        q: 'Како се пресметува нето плата од бруто плата?',
        a: `Од бруто платата се одземаат придонесите за ПИО (${pct(SALARY.pio)}), здравствено осигурување (${pct(SALARY.zdr)}), невработеност (${pct(SALARY.nev)}) и повреда на работа и професионално заболување (${pct(SALARY.povr)}). Од остатокот се одзема личното ослободување од ${mkd(SALARY.personal)} денари, а на добиената даночна основа се пресметува данок на личен доход од ${pct(SALARY.tax)}. Она што останува е нето платата.`,
    },
    {
        q: 'Може ли да се пресмета бруто плата од нето плата?',
        a: 'Да. Внесете го нето износот во полето „Нето плата“ и калкулаторот автоматски го враќа бруто износот и ги прикажува сите придонеси и данокот.',
    },
    {
        q: 'Може ли да пресметам од друг износ, на пример од придонес или данок?',
        a: 'Да. Секое поле во табелата е уредливо. Ако го знаете износот на придонесот за ПИО, здравственото осигурување, даночната основа или данокот, внесете го и калкулаторот ги пополнува сите останати вредности, вклучително бруто и нето плата.',
    },
    {
        q: 'Колку изнесува минималната плата?',
        a: `Во моментов минималната плата изнесува ${mkd(SALARY.minGross)} денари бруто, односно ${mkd(min.net)} денари нето.`,
    },
    {
        q: 'Колку изнесува просечната плата?',
        a: `Просечната бруто плата што ја користи калкулаторот е ${mkd(SALARY.avgGross)} денари, што е ${mkd(avg.net)} денари нето.`,
    },
    {
        q: 'Дали пресметката е точна?',
        a: 'Калкулаторот ги користи важечките стапки и износи наведени на страницата и ги заокружува на цели денари. Резултатот е информативен, а за конкретен обрачун на плата консултирајте се со овластен сметководител.',
    },
]

// JSON-LD (како во Faq.vue: се додава во <head>, а се чисти при напуштање на страната)
const schemaNodes = []

onMounted(() => {
    const schemas = [
        {
            '@context': 'https://schema.org',
            '@type': 'WebApplication',
            name: 'Калкулатор за плата 2026',
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
                { '@type': 'ListItem', position: 2, name: 'Калкулатор за плата', item: PAGE_URL },
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
        <title>Калкулатор за плата 2026: бруто во нето</title>
        <meta name="description" :content="DESCRIPTION" />
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large" />
        <link rel="canonical" :href="PAGE_URL" />
        <meta property="og:title" content="Калкулатор за плата 2026: бруто во нето и нето во бруто | FinanceBuddy.mk" />
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
                <span class="text-ink">Калкулатор за плата</span>
            </nav>
            <h1 class="font-display text-display-1 leading-tight text-ink">
                Калкулатор за плата 2026: бруто во нето и нето во бруто
            </h1>
            <p class="mt-6 max-w-3xl text-lg text-stone">
                Бесплатен онлајн калкулатор за пресметка на плата во Северна Македонија со сите придонеси и данок на личен доход.
                Работи во сите насоки: внесете бруто, нето, придонес, даночна основа или данок и сите останати износи се пресметуваат автоматски.
                Резултатот можете да го преземете како PDF.
            </p>
        </div>
    </section>

    <!-- 2. КАЛКУЛАТОР -->
    <section class="bg-paper-warm py-10 lg:py-14" aria-label="Калкулатор за плата">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <SalaryCalculator />
        </div>
    </section>

    <!-- 3. ОБЈАСНУВАЊЕ -->
    <section class="bg-paper py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-h3 font-semibold text-ink">Калкулации во сите насоки</h2>
            <p class="mt-4 text-stone">Секое поле во калкулаторот е отворено за внес. Може да почнете од која било вредност што ја знаете:</p>
            <ul class="mt-4 space-y-2 text-stone">
                <li><strong class="text-ink">Од бруто во нето:</strong> внесете ја бруто платата и добивате нето износ.</li>
                <li><strong class="text-ink">Од нето во бруто:</strong> внесете колку сакате да добивате на сметка и добивате потребна бруто плата.</li>
                <li>
                    <strong class="text-ink">Од придонес или данок:</strong> ако го знаете износот на придонесот за ПИО, здравство, невработеност,
                    повреда на работа, вкупните придонеси, даночната основа или данокот, внесете го и се пополнуваат сите останати полиња.
                </li>
            </ul>

            <h2 class="mt-14 font-display text-h3 font-semibold text-ink">Придонеси и данок во 2026 година</h2>
            <div class="mt-5 overflow-hidden rounded-2xl border border-border">
                <table class="w-full text-left text-sm sm:text-base">
                    <thead class="bg-paper-warm text-stone">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Ставка</th>
                            <th class="px-4 py-3 text-right font-semibold">Стапка / износ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rate in rates" :key="rate.label" class="border-t border-border">
                            <td :class="['px-4 py-3', rate.strong ? 'font-semibold text-ink' : 'text-stone']">{{ rate.label }}</td>
                            <td :class="['px-4 py-3 text-right tabular-nums', rate.strong ? 'font-semibold text-ink' : 'text-ink']">{{ rate.value }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="mt-14 font-display text-h3 font-semibold text-ink">Како се пресметува нето плата од бруто плата</h2>
            <ol class="mt-4 list-decimal space-y-2 pl-6 text-stone">
                <li>Од бруто платата се пресметуваат и одземаат придонесите (вкупно {{ pct(CONTRIB_TOTAL_PCT) }}).</li>
                <li>Од остатокот се одзема личното ослободување од {{ mkd(SALARY.personal) }} денари и така се добива даночната основа.</li>
                <li>На даночната основа се пресметува данок на личен доход од {{ pct(SALARY.tax) }}.</li>
                <li>Нето плата = бруто плата − придонеси − данок.</li>
            </ol>
            <div class="mt-6 rounded-2xl border border-border bg-paper-warm p-5 text-stone">
                <strong class="text-ink">Пример со просечна плата:</strong>
                бруто {{ mkd(avg.g) }} денари → придонеси {{ mkd(avg.contrib) }} → бруто намалена за придонеси {{ mkd(avg.after) }} →
                даночна основа {{ mkd(avg.base) }} → данок {{ mkd(avg.tax) }} →
                <strong class="text-brand-orange">нето {{ mkd(avg.net) }} денари</strong>.
            </div>

            <h2 class="mt-14 font-display text-h3 font-semibold text-ink">Минимална и просечна плата</h2>
            <p class="mt-4 text-stone">
                Минималната плата во моментов изнесува <strong class="text-ink">{{ mkd(SALARY.minGross) }} денари бруто</strong>
                (<strong class="text-ink">{{ mkd(min.net) }} денари нето</strong>), а просечната бруто плата што ја користи калкулаторот е
                <strong class="text-ink">{{ mkd(SALARY.avgGross) }} денари</strong> ({{ mkd(avg.net) }} денари нето).
                Двата износи можете да ги прикажете во калкулаторот со копчињата над табелата.
            </p>
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
                Последно ажурирано: {{ SALARY.updated }}. Пресметката е информативна и не претставува сметководствен или даночен совет.
            </p>
        </div>
        <div class="mx-auto mt-10 max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 rounded-2xl border border-border bg-paper p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Друга бесплатна алатка</p>
                    <p class="mt-1 font-semibold text-ink">Калкулатор за ДДВ: 5%, 10% и 18%</p>
                </div>
                <Link
                    :href="route('vat-calculator')"
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
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Пресметка на плати</p>
            <h2 class="mt-2 font-display text-display-2 text-paper">Ви треба обрачун на плати за вашата фирма?</h2>
            <p class="mt-4 text-lg text-stone">
                Месечна пресметка на плати и придонеси, платни листи и пријавување кај УЈП — навреме и без грешки.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <Link
                    :href="route('services.show', 'presmetka-na-plati')"
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
