<script setup>
import { onMounted, ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BrandUnderline from '@/Components/BrandUnderline.vue'

defineOptions({ layout: PublicLayout })

const props = defineProps({
    latestPosts: { type: Array, default: () => [] },
})

const activeService = ref(0)

const services = [
    { num: '01', slug: 'finansisko-smetkovodstvo', name: 'Финансиско сметководство', desc: 'Целосно водење на деловните книги и финансиски извештаи.' },
    { num: '02', slug: 'danocen-konsalting', name: 'Даночен консалтинг', desc: 'Усогласеност со законот и оптимизација на даноците.' },
    { num: '03', slug: 'presmetka-na-plati', name: 'Пресметка на плати', desc: 'Плати, придонеси и пријавување кај УЈП — уредно секој месец.' },
    { num: '04', slug: 'registracija-firma', name: 'Регистрација на фирма', desc: 'Брзо основање — ДООЕЛ, СВД, ФЛ — без непотребно чекање.' },
    { num: '05', slug: 'konsalting-za-msp', name: 'Консалтинг за МСП', desc: 'Стратешки финансиски совети прилагодени за твојот бизнис.' },
    { num: '06', slug: 'danocna-optimizacija', name: 'Даночна оптимизација', desc: 'Легални начини за намалување на даночниот товар.' },
]

const statsData = [
    { num: 38, suffix: '%', label: 'Freelancers — ФЛ', desc: 'Станавме специјалисти за фриленсерите – физички лица кои работат за странски компании' },
    { num: 17, suffix: '%', label: 'Freelancers — B2B', desc: 'Клиенти кои преферираат поголема стабилност и сигурност во нивната работа' },
    { num: 45, suffix: '%', label: 'Друштва и СВД', desc: '„Традиционалните" клиенти се уште се „столбот" на нашата индустрија!' },
]
const statsDisplay = ref(['0%', '0%', '0%'])
const statsStarted = [false, false, false]

const testimonials = [
    {
        quote: 'Со FinanceBuddy секој месец „штедам" по 2-3 часа во административни обврски. Врвна услуга, топ професионалност и најважно – воопшто не излегувам од дома да средувам пријави за данок. Топла препорака за сите фриленсери што работат за странски фирми!',
        name: 'Марио Божиновски',
        role: 'Senior Software Engineer',
    },
    {
        quote: 'Можам да кажам дека соработката помеѓу FinanceBuddy.mk и Peopleweek Ltd. го надминува односот клиент – консултант. Сигурен сум дека нашиот партнерски однос ќе го развиваме уште повеќе во иднина.',
        name: 'Димитар Спироски',
        role: 'Founder and CTO @ Peopleweek Ltd.',
    },
    {
        quote: 'Со FinanceBuddy.mk имам решение за секој проблем поврзан со администрација. Професионалност, достапност, флексибилност, одлична комуникација и се останато што е потребно за врвен консалтинг. Понудата за услуги В2В е одлична!',
        name: 'Ивана Стружанчева',
        role: 'Marketing Manager',
    },
]

const process = [
    { num: '01', title: 'Прв контакт', desc: 'Закажи бесплатна консултација по телефон, видео или во канцеларија.' },
    { num: '02', title: 'Анализа', desc: 'Ги разгледуваме твоите потреби и подготвуваме персонализирана понуда.' },
    { num: '03', title: 'Договор', desc: 'Потпишуваме договор со јасни услови — без скриени трошоци.' },
    { num: '04', title: 'Работиме', desc: 'Ти се фокусираш на бизнисот, ние се грижиме за администрацијата.' },
]

const reasons = [
    'Специјалисти за фриленсери — единствени во Македонија',
    'Брза реакција — одговор истиот ден, не по неколку дена',
    'Дигитален пристап — работиме онлајн, без физичко носење документи',
    'Персонален консултант — не си само уште еден број во база',
    'Транспарентни цени — фиксна месечна надоместина, без изненадувања',
]

function formatDate(dateString) {
    if (!dateString) return ''
    return new Intl.DateTimeFormat('mk-MK', { day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(dateString))
}

function animateCount(index, target, suffix, duration = 1500) {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        statsDisplay.value[index] = target + suffix
        return
    }
    const start = performance.now()
    function tick(now) {
        const t = Math.min((now - start) / duration, 1)
        const eased = 1 - Math.pow(1 - t, 3)
        statsDisplay.value[index] = Math.round(eased * target) + suffix
        if (t < 1) requestAnimationFrame(tick)
    }
    requestAnimationFrame(tick)
}

onMounted(() => {
    const revealObserver = new IntersectionObserver(
        (entries) => entries.forEach(e => e.target.classList.toggle('revealed', e.isIntersecting)),
        { threshold: 0.1 },
    )
    document.querySelectorAll('[data-reveal]').forEach(el => revealObserver.observe(el))

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            const i = +e.target.dataset.statIndex
            if (e.isIntersecting && !statsStarted[i]) {
                statsStarted[i] = true
                animateCount(i, statsData[i].num, statsData[i].suffix)
            }
        })
    }, { threshold: 0.5 })
    document.querySelectorAll('[data-stat-index]').forEach(el => statsObserver.observe(el))
})
</script>

<template>
    <Head>
        <title>Сметководство за фриленсери | FinanceBuddy.mk</title>
        <meta name="description" content="Сметководство и даночен консалтинг за фриленсери и МСП во Македонија. Дигитален пристап, брза реакција, фиксна цена — без изненадувања." />
        <link rel="canonical" href="https://financebuddy.mk" />
        <meta property="og:title" content="Сметководство за фриленсери | FinanceBuddy.mk" />
        <meta property="og:description" content="Сметководство и даночен консалтинг за фриленсери и МСП во Македонија. Дигитален пристап, брза реакција, фиксна цена — без изненадувања." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper pt-24 pb-20 lg:pt-32 lg:pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-5">

                <!-- Текст 60% — секвенцијален fade-up на load -->
                <div class="lg:col-span-3">
                    <span
                        class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                        style="animation-delay: 0ms"
                    >
                        Сметководство за фриленсери и МСП во Македонија
                    </span>
                    <h1
                        class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                        style="animation-delay: 80ms"
                    >
                        Помалку администрација.<br>
                        Повеќе <BrandUnderline>бизнис.</BrandUnderline>
                    </h1>
                    <p
                        class="animate-fade-up mt-6 max-w-xl text-lg text-stone"
                        style="animation-delay: 160ms"
                    >
                        Препуштете ги бројките нам — ние се грижиме за сметководството, данокот и администрацијата. Вие се фокусирајте на она во кое сте добри.
                    </p>
                    <div
                        class="animate-fade-up mt-8 flex flex-wrap gap-4"
                        style="animation-delay: 240ms"
                    >
                        <Link
                            href="/kontakt"
                            class="inline-flex items-center gap-2 rounded-full bg-brand-orange px-6 py-3 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                        >
                            Побарај понуда
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                        <Link
                            href="/uslugi"
                            class="inline-flex items-center gap-2 rounded-full border border-border px-6 py-3 font-semibold text-ink transition-all duration-150 hover:border-brand-orange hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                        >
                            Нашите услуги
                        </Link>
                    </div>
                </div>

                <!-- Hero декорација 40% — апстрактна геометриска форма во brand бои -->
                <div
                    class="animate-fade-up hidden lg:col-span-2 lg:block"
                    style="animation-delay: 120ms"
                    aria-hidden="true"
                >
                    <svg viewBox="0 0 440 480" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-auto w-full max-w-md">
                        <!-- Background card -->
                        <rect x="20" y="20" width="400" height="440" rx="28" fill="#F2ECE1"/>
                        <!-- Orange glow -->
                        <circle cx="388" cy="78" r="130" fill="#FF6600" opacity="0.09"/>
                        <circle cx="388" cy="78" r="75" fill="#FF6600" opacity="0.11"/>
                        <!-- Document shadow (rotated back) -->
                        <rect x="70" y="95" width="200" height="255" rx="10" fill="white" opacity="0.55" transform="rotate(-5 170 222)"/>
                        <!-- Main document -->
                        <rect x="90" y="112" width="204" height="255" rx="10" fill="white"/>
                        <!-- Orange header strip -->
                        <rect x="90" y="112" width="204" height="10" rx="3" fill="#FF6600"/>
                        <!-- Document content lines -->
                        <rect x="114" y="144" width="148" height="8" rx="4" fill="#E5DDD0"/>
                        <rect x="114" y="164" width="164" height="8" rx="4" fill="#E5DDD0"/>
                        <rect x="114" y="184" width="116" height="8" rx="4" fill="#E5DDD0"/>
                        <rect x="114" y="204" width="155" height="8" rx="4" fill="#E5DDD0"/>
                        <rect x="114" y="224" width="132" height="8" rx="4" fill="#E5DDD0"/>
                        <!-- Stat callout -->
                        <text x="100" y="318" font-family="JetBrains Mono, monospace" font-size="60" font-weight="700" fill="#FF6600">38%</text>
                        <text x="100" y="343" font-family="Inter, sans-serif" font-size="13" fill="#6B6358">Фриленсери</text>
                        <!-- Document tab label -->
                        <rect x="244" y="112" width="50" height="33" rx="5" fill="#14532D"/>
                        <text x="256" y="134" font-family="JetBrains Mono, monospace" font-size="12" font-weight="600" fill="white">01</text>
                        <!-- Forest green accent circle -->
                        <circle cx="340" cy="392" r="52" fill="#14532D" opacity="0.07"/>
                        <circle cx="340" cy="392" r="30" fill="#14532D" opacity="0.09"/>
                        <!-- Accent dots -->
                        <circle cx="312" cy="446" r="5" fill="#FF6600" opacity="0.35"/>
                        <circle cx="329" cy="446" r="5" fill="#FF6600" opacity="0.22"/>
                        <circle cx="346" cy="446" r="5" fill="#FF6600" opacity="0.12"/>
                    </svg>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. УСЛУГИ — картотека/индекс картон лента со нумерирани табови -->
    <section class="border-t border-border bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between" data-reveal>
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Услуги</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">Што покриваме</h2>
                </div>
                <Link
                    href="/uslugi"
                    class="shrink-0 font-semibold text-brand-orange transition-colors hover:text-brand-orange-dark focus-visible:rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                >
                    Сите услуги →
                </Link>
            </div>

            <div data-reveal>
                <!-- Tab лента — папки/досиеа инспирација -->
                <div class="flex flex-wrap gap-1 border-b border-border" role="tablist" aria-label="Услуги на FinanceBuddy">
                    <button
                        v-for="(service, i) in services"
                        :key="service.slug"
                        role="tab"
                        :id="`tab-${service.slug}`"
                        :aria-selected="activeService === i"
                        :aria-controls="`panel-${service.slug}`"
                        @click="activeService = i"
                        @keydown.right.prevent="activeService = (i + 1) % services.length"
                        @keydown.left.prevent="activeService = (i - 1 + services.length) % services.length"
                        class="relative flex items-center gap-2 rounded-t-lg border border-b-0 px-4 py-2.5 -mb-px transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-orange"
                        :class="activeService === i
                            ? 'bg-paper border-border text-brand-orange z-10'
                            : 'bg-paper-warm border-transparent text-stone hover:bg-paper/70 hover:text-ink'"
                    >
                        <span class="font-mono text-xs font-bold">{{ service.num }}</span>
                        <span class="hidden text-sm font-medium sm:inline">{{ service.name }}</span>
                    </button>
                </div>

                <!-- Content panel -->
                <div class="rounded-b-2xl border border-t-0 border-border bg-paper">
                    <div
                        v-for="(service, i) in services"
                        :key="`panel-${service.slug}`"
                        role="tabpanel"
                        :id="`panel-${service.slug}`"
                        :aria-labelledby="`tab-${service.slug}`"
                        v-show="activeService === i"
                        class="grid gap-8 p-8 lg:grid-cols-2 lg:items-center lg:p-12"
                    >
                        <div>
                            <span class="font-mono text-sm font-bold text-brand-orange">{{ service.num }}</span>
                            <h3 class="mt-2 font-display text-h3 font-semibold text-ink">{{ service.name }}</h3>
                            <p class="mt-3 text-base leading-relaxed text-stone">{{ service.desc }}</p>
                            <Link
                                :href="`/uslugi/${service.slug}`"
                                class="mt-6 inline-flex items-center gap-2 font-semibold text-brand-orange transition-colors duration-150 hover:text-brand-orange-dark focus-visible:rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            >
                                Дознај повеќе
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </Link>
                        </div>
                        <!-- Декоративен голем број десно -->
                        <div class="hidden items-center justify-end lg:flex" aria-hidden="true">
                            <span class="select-none font-mono font-bold leading-none text-border" style="font-size: 9rem;">
                                {{ service.num }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. ЗОШТО FINANCEBUDDY -->
    <section class="bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-2 lg:items-center">

                <div data-reveal>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Зошто нас</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">
                        Не само сметководство —<br>
                        вистински <BrandUnderline>партнер.</BrandUnderline>
                    </h2>
                    <p class="mt-4 text-lg text-stone">
                        Разбираме дека за фриленсерот и малиот бизнис времето е пари. Затоа сме тука да го решиме административниот дел — брзо, дигитално, без стрес.
                    </p>
                </div>

                <ul class="flex flex-col gap-3" data-reveal>
                    <li
                        v-for="reason in reasons"
                        :key="reason"
                        class="flex items-start gap-3 rounded-xl border border-border bg-paper p-4 transition-colors duration-150 hover:border-brand-orange/30"
                    >
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-base text-ink">{{ reason }}</span>
                    </li>
                </ul>

            </div>
        </div>
    </section>

    <!-- 4. ПРОЦЕС -->
    <section class="border-y border-border bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Процес</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Како работиме</h2>
            </div>

            <div class="relative grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div class="absolute left-8 right-8 top-8 hidden h-px bg-border lg:block" aria-hidden="true" />

                <div v-for="step in process" :key="step.num" class="relative flex flex-col gap-4" data-reveal>
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

    <!-- 5. СТАТИСТИКИ — count-up при влез во viewport -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 sm:grid-cols-3">
                <div
                    v-for="(stat, i) in statsData"
                    :key="stat.label"
                    class="flex flex-col gap-3"
                    data-reveal
                >
                    <span
                        class="font-mono text-6xl font-bold text-brand-orange lg:text-7xl"
                        :data-stat-index="i"
                    >{{ statsDisplay[i] }}</span>
                    <span class="font-display text-xl font-semibold text-paper">{{ stat.label }}</span>
                    <p class="text-sm text-stone">{{ stat.desc }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. TESTIMONIALS — топла позадина, не бел картон со сенка -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Рецензии</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Што велат клиентите</h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div
                    v-for="t in testimonials"
                    :key="t.name"
                    class="flex flex-col gap-6 rounded-2xl border border-border bg-paper-warm p-6 transition-all duration-150 hover:scale-[1.02] hover:border-brand-orange/25 hover:shadow-sm"
                    data-reveal
                >
                    <div class="flex gap-1" :aria-label="`Оценка 5 од 5 — ${t.name}`">
                        <svg v-for="i in 5" :key="i" class="h-4 w-4 text-brand-orange" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>

                    <blockquote class="grow text-base text-ink">
                        <span class="font-display text-4xl leading-none text-brand-orange" aria-hidden="true">"</span>
                        {{ t.quote }}
                    </blockquote>

                    <div class="border-t border-border/60 pt-4">
                        <p class="font-semibold text-ink">{{ t.name }}</p>
                        <p class="text-sm text-stone">{{ t.role }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 7. BLOG preview -->
    <section class="border-t border-border bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between" data-reveal>
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Блог</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">Корисни совети</h2>
                </div>
                <Link
                    href="/blog"
                    class="shrink-0 font-semibold text-brand-orange transition-colors hover:text-brand-orange-dark focus-visible:rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                >
                    Сите објави →
                </Link>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <Link
                    v-for="post in props.latestPosts"
                    :key="post.id"
                    :href="route('blog.show', post.slug)"
                    class="group flex flex-col gap-4 rounded-2xl border border-border bg-paper p-6 transition-all duration-150 hover:border-brand-orange/30 hover:shadow-sm"
                    data-reveal
                >
                    <img
                        v-if="post.featured_image_path"
                        :src="`/storage/${post.featured_image_path}`"
                        :alt="post.title"
                        class="aspect-video w-full rounded-xl object-cover"
                    />
                    <div v-else class="aspect-video w-full rounded-xl border border-border bg-paper-warm" />
                    <span v-if="post.category" class="inline-block self-start rounded-full bg-forest/10 px-3 py-1 text-xs font-medium text-forest">
                        {{ post.category.name }}
                    </span>
                    <h3 class="font-display text-h3 font-semibold leading-snug text-ink transition-colors duration-150 group-hover:text-brand-orange">
                        {{ post.title }}
                    </h3>
                    <div class="mt-auto flex items-center gap-2 font-mono text-xs text-stone">
                        <span>{{ formatDate(post.published_at) }}</span>
                        <span aria-hidden="true">·</span>
                        <span>{{ post.reading_time }} мин читање</span>
                    </div>
                </Link>
            </div>

        </div>
    </section>

    <!-- 8. NEWSLETTER -->
    <section class="bg-paper py-16 lg:py-20">
        <div class="mx-auto max-w-2xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Newsletter</p>
            <h2 class="mt-2 font-display text-display-2 text-ink">Останете информирани</h2>
            <p class="mt-4 text-base text-stone">
                Newsletter — промени во даноците, корисни совети за МСП и фриленсери. Без спам.
            </p>
            <form class="mt-8 flex flex-col gap-3 sm:flex-row" @submit.prevent>
                <label for="newsletter-email" class="sr-only">Вашата email адреса</label>
                <input
                    id="newsletter-email"
                    type="email"
                    placeholder="vasha@email.com"
                    autocomplete="email"
                    class="grow rounded-full border border-border bg-paper-warm px-5 py-3 text-base text-ink placeholder:text-stone focus:border-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-orange/20"
                >
                <button
                    type="submit"
                    class="shrink-0 rounded-full bg-brand-orange px-6 py-3 font-semibold text-white transition-colors hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                >
                    Претплати се
                </button>
            </form>
            <p class="mt-3 text-xs text-stone">Во секое време можете да се откажете. Без спам.</p>
        </div>
    </section>

    <!-- 9. CTA -->
    <section class="bg-brand-orange py-16 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <h2 class="font-display text-display-2 text-white">Спремни да почнеме?</h2>
            <p class="mt-4 text-lg text-white/80">
                Закажете БЕСПЛАТНА консултација — без обврски, без скриени трошоци.
            </p>
            <Link
                href="/kontakt"
                class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-semibold text-brand-orange transition-all duration-150 hover:bg-paper focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-orange"
            >
                Контактирајте нè
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </Link>
        </div>
    </section>
</template>
