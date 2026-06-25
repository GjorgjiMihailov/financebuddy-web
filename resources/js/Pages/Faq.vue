<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

const categories = [
    {
        title: 'Фриленсери',
        items: [
            {
                q: 'Ми бараат TIN број. Кај да го најдам?',
                a: 'Во Македонија физичките лица немаат посебен TIN број. За даночни цели се идентификуваат со ЕМБГ (Единствен матичен број на граѓанин). На странските платформи (Upwork, Fiverr, Toptal и сл.) го внесувате вашиот ЕМБГ во полето за TIN.',
            },
            {
                q: 'Колку данок плаќа фриленсер физичко лице на приход од странство?',
                a: 'Фриленсерот физичко лице плаќа 10% данок на личен доход плус задолжителни придонеси за ПИО и здравство - доколку работи В2В. Точниот износ на придонеси зависи од деловниот и работниот однос, а со тоа и од висината на приходот. Контактирајте нè за точна пресметка според вашата конкретна ситуација.',
            },
            {
                q: 'Колку време имам да пријавам приход од странство?',
                a: 'Приходот од странство се пријавува во рок од 10 дена по истекот на месецот во кој се примени средствата. Пример: ако приходот е примен на 8 август, пријавата мора да се поднесе најдоцна до 10 септември. Плаќањето на данокот е до 15 септември.',
            },
            {
                q: 'Дали мора да отворам фирма за да работам за странски компании?',
                a: 'Не. Може да работите директно како физичко лице и да ги пријавувате приходите лично. Меѓутоа, отворањето ДООЕЛ или регистрирањето како СВД може да биде поповолно во зависност од вашиот обем и структура на приходи. Консултирајте нè за да го одберете вистинскиот пат.',
            },
            {
                q: 'Дали приходите на Payoneer/Wise мора да се пријават иако не ги повлекувам на македонска сметка?',
                a: 'Да. Приходот се смета за примен во моментот кога е ставен на ваше располагање — уплатен на Payoneer, Wise или друга платформска сметка. Повлекувањето на локалната банка не го одложува рокот за пријавување.',
            },
        ],
    },
    {
        title: 'Даноци',
        items: [
            {
                q: 'Кога мора да се регистрирам за ДДВ?',
                a: 'Кога вашиот вкупен годишен промет ќе надмине 2.000.000 денари. По достигнување на прагот, имате обврска веднаш да поднесете пријава за ДДВ регистрација во УЈП.',
            },
            {
                q: 'Издавам деловен простор — дали треба ДДВ регистрација?',
                a: 'Да. Приходите по основ на издавање деловен простор под закуп или подзакуп се оданочуваат со ДДВ доколку се исполнати условите за регистрација (промет над 2.000.000 денари годишно).',
            },
            {
                q: 'Дали услугите кои ги давам на странски компании се оданочуваат со ДДВ?',
                a: 'Начелно не — местото на оданочување на услугите е таму каде е регистриран примателот (странската компанија), па македонскиот ДДВ не се применува. Сепак, правилото варира според видот на услугата, па препорачуваме конкретна консултација.',
            },
            {
                q: 'Ако имам ДООЕЛ, колку данок плаќам на добивката?',
                a: 'Данок на добивка е 10% (рамен данок) на пресметаната добивка по завршување на деловната година. Пријавата и плаќањето се вршат до 28 февруари за претходната календарска година.',
            },
        ],
    },
    {
        title: 'Компании и регистрација',
        items: [
            {
                q: 'Која е разликата помеѓу ДООЕЛ и СВД?',
                a: 'ДООЕЛ (Друштво со ограничена одговорност) е засебен правен субјект — сопственикот не одговара лично за долговите на друштвото. СВД (Самостоен вршач на дејност) е поедноставна форма со пониски трошоци, но со лична одговорност за обврските. Изборот зависи од ризикот и обемот на вашата дејност.',
            },
            {
                q: 'Колку е минималниот основачки капитал за ДООЕЛ?',
                a: 'Во Македонија не постои законски минимален основачки капитал за ДООЕЛ — може да биде и 1 денар. Во практика, препорачуваме основниот капитал да одговара на реалните потреби на бизнисот. Најчеста висина на основачкиот влог е 5000 евра во денарска противредност',
            },
            {
                q: 'Колку трае регистрацијата на фирма?',
                a: 'Со уредна документација, регистрацијата во ЦРРСМ трае 1–3 работни дена. Ние ги подготвуваме сите документи и го следиме процесот — без непотребно чекање.',
            },
            {
                q: 'Дали странски државјанин може да отвори ДООЕЛ во Македонија?',
                a: 'Да. Странски државјани можат да бидат основачи и управители на ДООЕЛ во Македонија. Потребен е важечки пасош, а во одредени случаи и ЕБС (Единствен број на странец).',
            },
        ],
    },
    {
        title: 'Сметководство и работни односи',
        items: [
            {
                q: 'До кога мора да се поднесе годишна сметка?',
                a: 'Завршната сметка за претходната деловна година мора да се поднесе до Централен регистар (ЦРРСМ) најдоцна до 28 февруари (15 март доколку се доставува електронски). Задоцнетото поднесување повлекува казни.',
            },
            {
                q: 'Колку години мора да се чуваат деловните книги?',
                a: 'Деловните книги, финансиски извештаи и сметководствена документација мора да се чуваат минимум 10 години.',
            },
            {
                q: 'Дали управителот на ДООЕЛ мора да биде пријавен и осигуран?',
                a: 'Да — ако управителот активно работи во друштвото! Секое лице кое активно работи во фирмата мора да биде пријавено во Агенцијата за вработување и да му се плаќаат придонеси за ПИО и здравствено осигурување или односот да му биде договорно регулиран. Непријавувањето е прекршок со законски санкции.',
            },
        ],
    },
]

onMounted(() => {
    const revealObserver = new IntersectionObserver(
        (entries) => entries.forEach(e => e.target.classList.toggle('revealed', e.isIntersecting)),
        { threshold: 0.1 },
    )
    document.querySelectorAll('[data-reveal]').forEach(el => revealObserver.observe(el))

    const schema = document.createElement('script')
    schema.type = 'application/ld+json'
    schema.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'FAQPage',
        mainEntity: categories.flatMap(cat =>
            cat.items.map(item => ({
                '@type': 'Question',
                name: item.q,
                acceptedAnswer: { '@type': 'Answer', text: item.a },
            }))
        ),
    })
    document.head.appendChild(schema)
})
</script>

<template>
    <Head>
        <title>FAQ — Често поставувани прашања | FinanceBuddy.mk</title>
        <meta name="description" content="Одговори на најчестите прашања за сметководство, данок, ДДВ, регистрација на фирма и фриленсерски приходи во Македонија." />
        <link rel="canonical" href="https://financebuddy.mk/faq" />
        <meta property="og:title" content="FAQ — Честопоставувани прашања | FinanceBuddy.mk" />
        <meta property="og:description" content="Одговори на најчестите прашања за сметководство, данок, ДДВ, регистрација на фирма и фриленсерски приходи во Македонија." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/faq" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper pt-24 pb-20 lg:pt-32 lg:pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span
                    class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                    style="animation-delay: 0ms"
                >
                    FAQ
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    Честопоставувани прашања
                </h1>
                <p
                    class="animate-fade-up mx-auto mt-6 max-w-xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    Наоѓаш одговор на своето прашање? Ако не — <Link href="/kontakt" class="font-medium text-brand-orange hover:text-brand-orange-dark">јави ни се директно.</Link>
                </p>
            </div>
        </div>
    </section>

    <!-- 2. FAQ КАТЕГОРИИ -->
    <section class="border-t border-border bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-16">
                <div
                    v-for="category in categories"
                    :key="category.title"
                    data-reveal
                >
                    <h2 class="mb-6 font-display text-h3 font-semibold text-ink">
                        {{ category.title }}
                    </h2>

                    <div class="overflow-hidden rounded-2xl border border-border bg-paper">
                        <details
                            v-for="(item, i) in category.items"
                            :key="item.q"
                            class="group border-b border-border last:border-b-0"
                        >
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-orange">
                                <span class="font-semibold text-ink">{{ item.q }}</span>
                                <svg
                                    class="h-5 w-5 shrink-0 text-stone transition-transform duration-200 group-open:rotate-180"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <div class="border-t border-border/60 bg-paper-warm px-6 py-5">
                                <p class="text-base leading-relaxed text-stone">{{ item.a }}</p>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CTA — уште прашања? -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Не нашол одговор?</p>
            <h2 class="mt-2 font-display text-display-2 text-paper">Прашај нè директно.</h2>
            <p class="mt-4 text-lg text-stone">
                Секое прашање е различно. Закажи бесплатна консултација и ќе добиеш конкретен одговор за твојата ситуација.
            </p>
            <Link
                href="/kontakt"
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
