<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BrandUnderline from '@/Components/BrandUnderline.vue'

defineOptions({ layout: PublicLayout })

const values = [
    {
        icon: 'puzzle',
        title: 'Прилагодени процеси',
        desc: 'Секој клиент е различен. Не нудиме шаблонски пакети — ги прилагодуваме услугите кон твојот бизнис модел, индустрија и работен ритам.',
    },
    {
        icon: 'shield',
        title: 'Транспарентност и доверба',
        desc: 'Фиксни месечни цени, јасни услови, без скриени трошоци. Секогаш знаеш точно што добиваш и колку плаќаш.',
    },
    {
        icon: 'bolt',
        title: 'Брзина и ефикасност',
        desc: 'Одговараме истиот ден. Роковите никогаш не ги пропуштаме — во финансиите секој ден задоцнување може да чини.',
    },
]

const milestones = [
    {
        label: '2021',
        title: 'Основање на FinanceBuddy',
        desc: 'Ги поставивме темелите со јасна визија — да понудиме сметководство прилагодено за дигиталната економија и реалните потреби на македонскиот пазар.',
    },
    {
        label: '2022',
        title: 'Прв пакет за фриленсери',
        desc: 'Станавме први специјалисти за фриленсери во Македонија — физички лица кои работат за странски компании преку Upwork, Toptal, директни договори.',
    },
    {
        label: '2025',
        title: 'FinanceBlog',
        desc: 'Го лансиравме нашиот блог со практични совети за фриленсери и мали бизниси. Знаењето не е привилегија — треба да биде достапно за секого.',
    },
    {
        label: '2026',
        title: 'Нов дигитален сајт',
        desc: 'Со нов онлајн пристап, клиентски портал и проширена листа на услуги — продолжуваме да растеме заедно со нашите клиенти.',
    },
]


onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => entries.forEach(e => e.target.classList.toggle('revealed', e.isIntersecting)),
        { threshold: 0.1 },
    )
    document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el))
})
</script>

<template>
    <Head>
        <title>За нас | FinanceBuddy.mk</title>
        <meta name="description" content="Дознајте повеќе за тимот зад FinanceBuddy.mk — специјалисти за сметководство и даночен консалтинг за фриленсери и МСП во Македонија." />
        <link rel="canonical" href="https://financebuddy.mk/za-nas" />
        <meta property="og:title" content="За нас | FinanceBuddy.mk" />
        <meta property="og:description" content="Дознајте повеќе за тимот зад FinanceBuddy.mk — специјалисти за сметководство и даночен консалтинг за фриленсери и МСП во Македонија." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/za-nas" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper-warm pt-24 pb-20 lg:pt-32 lg:pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-5">

                <div class="lg:col-span-3">
                    <span
                        class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                        style="animation-delay: 0ms"
                    >
                        За нас
                    </span>
                    <h1
                        class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                        style="animation-delay: 80ms"
                    >
                        Не само сметководство —<br>
                        вистински <BrandUnderline>партнер.</BrandUnderline>
                    </h1>
                    <p
                        class="animate-fade-up mt-6 max-w-xl text-lg text-stone"
                        style="animation-delay: 160ms"
                    >
                        Зад FinanceBuddy стои мал тим со голема посветеност — специјалисти кои го разбираат предизвикот на фриленсерите и малите бизниси подобро од кој било.
                    </p>
                </div>

                <!-- Декоративна инфо картичка -->
                <div
                    class="animate-fade-up hidden lg:col-span-2 lg:flex lg:items-center lg:justify-center"
                    style="animation-delay: 120ms"
                    aria-hidden="true"
                >
                    <div class="w-full max-w-sm rounded-2xl border border-border bg-paper p-8 shadow-sm">
                        <div class="mb-6 flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-orange/10">
                                <svg class="h-5 w-5 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="font-semibold text-ink">FinanceBuddy тим</span>
                        </div>
                        <dl class="flex flex-col gap-4">
                            <div class="flex items-center justify-between border-b border-border pb-4">
                                <dt class="text-sm text-stone">Специјализација</dt>
                                <dd class="font-mono text-sm font-semibold text-brand-orange">Фриленсери & МСП</dd>
                            </div>
                            <div class="flex items-center justify-between border-b border-border pb-4">
                                <dt class="text-sm text-stone">Пристап</dt>
                                <dd class="font-mono text-sm font-semibold text-ink">100% дигитален</dd>
                            </div>
                            <div class="flex items-center justify-between border-b border-border pb-4">
                                <dt class="text-sm text-stone">Реакција</dt>
                                <dd class="font-mono text-sm font-semibold text-ink">Истиот ден</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-stone">Локација</dt>
                                <dd class="font-mono text-sm font-semibold text-ink">Скопје</dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. МИСИЈА -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-2 lg:items-start">

                <div class="lg:sticky lg:top-28" data-reveal>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Мисија</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">
                        Зошто постои<br>
                        <BrandUnderline>FinanceBuddy?</BrandUnderline>
                    </h2>
                </div>

                <div class="flex flex-col gap-6 text-lg leading-relaxed text-stone" data-reveal>
                    <p>
                        Започнавме со работа за да им понудиме на фриленсерите и бизнисите сметководствени и даночни услуги што се ефикасни и прилагодени на реалните потреби. Секој клиент заслужува личен пристап, јасни информации и финансиска поддршка што создава вредност.
                    </p>
                    <p>
                        Нашиот тим е составен од искусни професионалци кои се посветени на вашата финансиска сигурност и развој. Без разлика дали ви треба помош со ДДВ, пресметка на плати, даночни пријави или деловни совети — тука сме да го поедноставиме процесот и да ви овозможиме да се фокусирате на она што го работите најдобро.
                    </p>
                    <p>
                        Нашата мисија е да им обезбедиме на фриленсерите и бизнисите сигурна, транспарентна и навремена поддршка. Веруваме во јасна комуникација, ефикасна услуга и вистинско партнерство со нашите клиенти.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. ВРЕДНОСТИ -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Вредности</p>
                <h2 class="mt-2 font-display text-display-2 text-paper">Во што веруваме</h2>
            </div>

            <div class="grid gap-8 sm:grid-cols-3">
                <div
                    v-for="value in values"
                    :key="value.title"
                    class="flex flex-col gap-5 rounded-2xl border border-white/10 bg-white/5 p-8 transition-colors duration-150 hover:border-brand-orange/30"
                    data-reveal
                >
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-orange/10">
                        <svg v-if="value.icon === 'puzzle'" class="h-6 w-6 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                        <svg v-if="value.icon === 'shield'" class="h-6 w-6 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <svg v-if="value.icon === 'bolt'" class="h-6 w-6 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display text-h3 font-semibold text-paper">{{ value.title }}</h3>
                        <p class="mt-2 text-base text-stone">{{ value.desc }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. НАШАТА ПРИКАЗНА — Timeline -->
    <section class="bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Историја</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Нашата приказна</h2>
            </div>

            <div class="relative mx-auto max-w-3xl">
                <!-- Вертикална линија -->
                <div class="absolute left-8 top-0 bottom-0 w-px bg-border lg:left-1/2" aria-hidden="true" />

                <div class="flex flex-col gap-12">
                    <div
                        v-for="(milestone, i) in milestones"
                        :key="milestone.label"
                        class="relative flex gap-8 lg:gap-0"
                        :class="i % 2 === 0 ? 'lg:flex-row' : 'lg:flex-row-reverse'"
                        data-reveal
                    >
                        <!-- Текст -->
                        <div
                            class="pl-16 lg:w-1/2 lg:pl-0"
                            :class="i % 2 === 0 ? 'lg:pr-12 lg:text-right' : 'lg:pl-12'"
                        >
                            <span class="inline-block rounded-full bg-brand-orange/10 px-3 py-1 font-mono text-xs font-bold text-brand-orange">
                                {{ milestone.label }}
                            </span>
                            <h3 class="mt-3 font-display text-h3 font-semibold text-ink">{{ milestone.title }}</h3>
                            <p class="mt-2 text-base text-stone">{{ milestone.desc }}</p>
                        </div>

                        <!-- Dot на линијата -->
                        <div class="absolute left-8 flex -translate-x-1/2 items-start pt-1 lg:left-1/2" aria-hidden="true">
                            <div class="h-4 w-4 rounded-full border-2 border-brand-orange bg-paper-warm" />
                        </div>

                        <!-- Празно место за наизменичен распоред на desktop -->
                        <div class="hidden lg:block lg:w-1/2" />
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 5. ТИМ -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Тим</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Луѓето зад бројките</h2>
            </div>

            <div class="grid items-center gap-12 lg:grid-cols-5" data-reveal>

                <!-- Фото -->
                <div class="flex justify-center lg:col-span-2">
                    <img
                        src="/images/tamara.png"
                        alt="Тамара Мицевска Михаилова — CEO & Правен советник, FinanceBuddy.mk"
                        class="w-64 rounded-2xl object-cover object-top shadow-md lg:w-full"
                        style="max-height: 500px"
                    />
                </div>

                <!-- Текст -->
                <div class="lg:col-span-3 lg:pl-8">
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">CEO & Правен советник</p>
                    <h3 class="mt-3 font-display text-display-2 text-ink">Тамара Мицевска Михаилова</h3>
                    <blockquote class="mt-8 border-l-2 border-brand-orange/40 pl-5">
                        <p class="text-lg italic leading-relaxed text-stone">
                            „Верувам дека секој бизнис заслужува финансиски партнер што ќе му даде сигурност, јасност и поддршка – без компликации."
                        </p>
                    </blockquote>
                </div>

            </div>

        </div>
    </section>

    <!-- 6. CTA -->
    <section class="bg-brand-orange py-16 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <h2 class="font-display text-display-2 text-white">Да се запознаеме?</h2>
            <p class="mt-4 text-lg text-white/80">
                Закажи бесплатна консултација — без обврски, без скриени трошоци.
            </p>
            <Link
                href="/kontakt"
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
