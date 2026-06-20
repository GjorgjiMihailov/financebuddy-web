<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BrandUnderline from '@/Components/BrandUnderline.vue'

defineOptions({ layout: PublicLayout })

const services = [
    { num: '01', slug: 'finansisko-smetkovodstvo', name: 'Финансиско сметководство', desc: 'Целосно водење деловни книги, финансиски извештаи и усогласеност со законска регулатива — уредно и навреме.' },
    { num: '02', slug: 'materijalno-smetkovodstvo', name: 'Материјално сметководство', desc: 'Евиденција на залихи, основни средства и материјали. Точни записи за секое движење на имотот.' },
    { num: '03', slug: 'danocen-konsalting', name: 'Даночен консалтинг', desc: 'Пресметки, пријави и рокови кај УЈП — без стрес. Совети за усогласеност и оптимално даночно планирање.' },
    { num: '04', slug: 'registracija-firma', name: 'Регистрација фирма', desc: 'Брзо основање ДООЕЛ, СВД или ФЛ. Ги водиме сите чекори до регистрација во ЦРРСМ, без непотребно чекање.' },
    { num: '05', slug: 'presmetka-na-plati', name: 'Пресметка на плати', desc: 'Пресметка на нето и бруто плати, придонеси и пријавување кај УЈП — прецизно, секој месец.' },
    { num: '06', slug: 'finansiski-izvestai', name: 'Финансиски извештаи', desc: 'Подготовка на годишни и периодични извештаи: биланс на состојба, биланс на успех и буџетирање.' },
    { num: '07', slug: 'konsalting-za-msp', name: 'Консалтинг за МСП', desc: 'Стратешки финансиски совети за мали и средни претпријатија — при планирање, раст и деловни одлуки.' },
    { num: '08', slug: 'danocna-optimizacija', name: 'Даночна оптимизација', desc: 'Анализа на тековната даночна структура и легални начини за намалување на даночниот товар.' },
]

const process = [
    { num: '01', title: 'Контакт и консултација', desc: 'Нè контактирајте и накратко кажете ни што ви е потребно. Почетната консултација е целосно бесплатна.' },
    { num: '02', title: 'Прилагодено решение', desc: 'Врз основа на вашите потреби, предлагаме конкретна понуда и план на работа — брзо, јасно, без скриени трошоци.' },
    { num: '03', title: 'Соработка и поддршка', desc: 'Го преземаме сметководството, ги следиме роковите и сме тука за сè — постојано и навремено.' },
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
        <title>Услуги | FinanceBuddy.mk</title>
        <meta name="description" content="Сметководство, даночен консалтинг, пресметка на плати, регистрација на фирма и повеќе — целосна финансиска поддршка за фриленсери и МСП во Македонија." />
        <link rel="canonical" href="https://financebuddy.mk/uslugi" />
        <meta property="og:title" content="Услуги | FinanceBuddy.mk" />
        <meta property="og:description" content="Сметководство, даночен консалтинг, пресметка на плати, регистрација на фирма и повеќе — целосна финансиска поддршка за фриленсери и МСП во Македонија." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/uslugi" />
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
                    Услуги
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    Сè на едно <BrandUnderline>место.</BrandUnderline>
                </h1>
                <p
                    class="animate-fade-up mx-auto mt-6 max-w-xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    Од сметководство и даночни пријави до регистрација и стратешки совети — целосна финансиска поддршка прилагодена за твојот бизнис.
                </p>
            </div>
        </div>
    </section>

    <!-- 2. УСЛУГИ GRID -->
    <section class="border-t border-border bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    v-for="service in services"
                    :key="service.slug"
                    :href="`/uslugi/${service.slug}`"
                    class="group flex flex-col gap-5 rounded-2xl border border-border bg-paper p-6 transition-all duration-150 hover:border-brand-orange/40 hover:shadow-sm"
                    data-reveal
                >
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-xs font-bold text-brand-orange">{{ service.num }}</span>
                        <svg
                            class="h-4 w-4 shrink-0 text-border transition-colors duration-150 group-hover:text-brand-orange"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-display text-h3 font-semibold leading-snug text-ink transition-colors duration-150 group-hover:text-brand-orange">
                            {{ service.name }}
                        </h2>
                        <p class="mt-2 text-sm leading-relaxed text-stone">{{ service.desc }}</p>
                    </div>
                </Link>
            </div>
        </div>
    </section>

    <!-- 3. ПРОЦЕС -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Процес</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Kako работиме</h2>
            </div>

            <div class="relative grid gap-10 lg:grid-cols-3">
                <div class="absolute left-8 right-8 top-8 hidden h-px bg-border lg:block" aria-hidden="true" />

                <div
                    v-for="step in process"
                    :key="step.num"
                    class="relative flex flex-col gap-4"
                    data-reveal
                >
                    <div class="z-10 flex h-16 w-16 shrink-0 items-center justify-center rounded-full border-2 border-brand-orange/25 bg-paper">
                        <span class="font-mono text-sm font-bold text-brand-orange">{{ step.num }}</span>
                    </div>
                    <div>
                        <h3 class="font-display text-h3 font-semibold text-ink">{{ step.title }}</h3>
                        <p class="mt-1.5 text-sm text-stone">{{ step.desc }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. CTA -->
    <section class="bg-brand-orange py-16 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <h2 class="font-display text-display-2 text-white">Готови да почнеме?</h2>
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
