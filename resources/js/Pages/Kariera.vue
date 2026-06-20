<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

const benefits = [
    'Можност за професионален и личен напредок',
    'Работа во пријателска и поддржувачка средина',
    'Флексибилност и баланс работа–приватен живот',
    'Континуирана едукација и обуки',
    'Поддршка во кариерното градење',
    'Можност за вклучување во интересни проекти',
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
        <title>Кариера | FinanceBuddy.mk</title>
        <meta name="description" content="Придружи се на тимот на FinanceBuddy.mk — сметководствена агенција во Скопје. Отворени сме за нови, талентирани и посветени професионалци." />
        <link rel="canonical" href="https://financebuddy.mk/kariera" />
        <meta property="og:title" content="Кариера | FinanceBuddy.mk" />
        <meta property="og:description" content="Придружи се на тимот на FinanceBuddy.mk — сметководствена агенција во Скопје. Отворени сме за нови, талентирани и посветени професионалци." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/kariera" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper-warm pt-24 pb-20 lg:pt-32 lg:pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span
                    class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                    style="animation-delay: 0ms"
                >
                    Кариера
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    Придружете се на тимот<br>што прави разлика.
                </h1>
                <p
                    class="animate-fade-up mx-auto mt-6 max-w-xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    Во FinanceBuddy.mk веруваме дека вистинските луѓе создаваат вистински резултати. Постојано сме отворени за нови, талентирани и посветени професионалци.
                </p>
            </div>
        </div>
    </section>

    <!-- 2. ЗОШТО FINANCEBUDDY -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-2 lg:items-center">

                <div data-reveal>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Работна средина</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">
                        Зошто FinanceBuddy?
                    </h2>
                    <p class="mt-4 text-lg leading-relaxed text-stone">
                        Веруваме дека квалитетните луѓе заслужуваат квалитетна средина. Кај нас нема „само уште еден вработен" — секој член на тимот има глас, можност за раст и конкретна вредност за клиентите.
                    </p>
                </div>

                <ul class="flex flex-col gap-3" data-reveal>
                    <li
                        v-for="benefit in benefits"
                        :key="benefit"
                        class="flex items-start gap-3 rounded-xl border border-border bg-paper-warm p-4 transition-colors duration-150 hover:border-brand-orange/30"
                    >
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-base text-ink">{{ benefit }}</span>
                    </li>
                </ul>

            </div>
        </div>
    </section>

    <!-- 3. АПЛИЦИРАЈ -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Отворени позиции</p>
            <h2 class="mt-2 font-display text-display-2 text-paper">Имаш што да понудиш?</h2>
            <p class="mt-4 text-lg text-stone">
                Сите квалитетни кандидати се добредојдени да аплицираат — дури и кога немаме активно отворени позиции. Испрати CV (и опционо мотивациско писмо) на нашата email адреса.
            </p>
            <a
                href="mailto:contact@financebuddy.mk?subject=Апликација за работа — FinanceBuddy.mk"
                class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-orange px-8 py-4 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 focus-visible:ring-offset-ink"
            >
                Испрати апликација
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </a>
            <p class="mt-4 font-mono text-sm text-stone">contact@financebuddy.mk</p>
        </div>
    </section>
</template>
