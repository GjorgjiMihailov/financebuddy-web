<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BrandUnderline from '@/Components/BrandUnderline.vue'

defineOptions({ layout: PublicLayout })

const services = [
    { num: '01', slug: 'finansisko-smetkovodstvo', name: 'Финансиско сметководство', desc: 'Целосно водење на деловните книги и финансиски извештаи.' },
    { num: '02', slug: 'danocen-konsalting', name: 'Даночен консалтинг', desc: 'Усогласеност со законот и оптимизација на даноците.' },
    { num: '03', slug: 'presmetka-na-plati', name: 'Пресметка на плати', desc: 'Плати, придонеси и пријавување кај УЈП — уредно секој месец.' },
    { num: '04', slug: 'registracija-firma', name: 'Регистрација фирма', desc: 'Брзо основање — ДООЕЛ, СВД, ФЛ — без непотребно чекање.' },
    { num: '05', slug: 'konsalting-za-msp', name: 'Консалтинг за МСП', desc: 'Стратешки финансиски совети прилагодени за твојот бизнис.' },
    { num: '06', slug: 'danocna-optimizacija', name: 'Даночна оптимизација', desc: 'Легални начини за намалување на даночниот товар.' },
]

const stats = [
    {
        value: '38%',
        label: 'Freelancers — ФЛ',
        desc: 'Станавме специјалисти за фриленсерите – физички лица кои работат за странски компании',
    },
    {
        value: '17%',
        label: 'Freelancers — B2B',
        desc: 'Клиенти кои преферираат поголема стабилност и сигурност во нивната работа',
    },
    {
        value: '45%',
        label: 'Друштва и СВД',
        desc: '„Традиционалните" клиенти се уште се „столбот" на нашата индустрија!',
    },
]

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

const blogPosts = [
    { category: 'Фриленсери', title: 'Kako да станеш фриленсер во Македонија — целосен водич', date: '15 ноември 2024', readTime: '8 мин' },
    { category: 'Данок', title: 'ДДВ за мали бизниси — кога мора да се регистрираш?', date: '2 ноември 2024', readTime: '5 мин' },
    { category: 'Сметководство', title: 'Разлика помеѓу трошок и инвестиција — зошто е важно за твојот данок', date: '20 октомври 2024', readTime: '6 мин' },
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
        <title>Сметководство за фриленсери и МСП</title>
        <meta name="description" content="Сметководство, даночен консалтинг и регистрација фирма за фриленсери и мали бизниси во Македонија. Дигитален пристап, брза реакција, без скриени трошоци." />
    </Head>

    <!-- 1. Hero -->
    <section class="bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-5">

                <!-- Текст (60%) -->
                <div class="lg:col-span-3" data-reveal>
                    <span class="mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange">
                        Сметководство за фриленсери и МСП во Македонија
                    </span>
                    <h1 class="font-display text-display-1 leading-tight text-ink">
                        Помалку администрација.<br>
                        Повеќе <BrandUnderline>бизнис.</BrandUnderline>
                    </h1>
                    <p class="mt-6 max-w-xl text-lg text-stone">
                        Препуштете ги бројките нам — ние се грижиме за сметководството, данокот и администрацијата. Вие се фокусирајте на она во кое сте добри.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
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

                <!-- Placeholder — ќе се замени со илустрација/фото -->
                <div class="hidden lg:col-span-2 lg:flex" data-reveal>
                    <div class="flex aspect-square w-full items-center justify-center rounded-3xl border border-border bg-paper-warm">
                        <span class="text-sm text-stone">[илустрација]</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Услуги preview -->
    <section class="border-t border-border bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between" data-reveal>
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

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="service in services"
                    :key="service.slug"
                    :href="`/uslugi/${service.slug}`"
                    class="group flex flex-col gap-4 rounded-2xl border border-border bg-paper p-6 transition-all duration-150 hover:scale-[1.02] hover:border-brand-orange/30 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    data-reveal
                >
                    <span class="font-mono text-sm font-bold text-brand-orange">{{ service.num }}</span>
                    <div>
                        <h3 class="font-display text-h3 font-semibold text-ink">{{ service.name }}</h3>
                        <p class="mt-1.5 text-sm text-stone">{{ service.desc }}</p>
                    </div>
                    <svg
                        class="mt-auto h-5 w-5 text-stone transition-transform duration-150 group-hover:translate-x-1 group-hover:text-brand-orange"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </Link>
            </div>

        </div>
    </section>

    <!-- 3. Зошто FinanceBuddy -->
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

                <ul class="flex flex-col gap-4" data-reveal>
                    <li v-for="reason in reasons" :key="reason" class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-base text-ink">{{ reason }}</span>
                    </li>
                </ul>

            </div>
        </div>
    </section>

    <!-- 4. Процес -->
    <section class="border-y border-border bg-paper py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-16 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Процес</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Kako работиме</h2>
            </div>

            <div class="relative grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Поврзувачка линија — само на десктоп -->
                <div class="absolute left-8 right-8 top-8 hidden h-px bg-border lg:block" aria-hidden="true" />

                <div v-for="step in process" :key="step.num" class="relative flex flex-col gap-4" data-reveal>
                    <div class="z-10 flex h-16 w-16 shrink-0 items-center justify-center rounded-full border-2 border-border bg-paper">
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

    <!-- 5. Статистики -->
    <section class="bg-ink py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 sm:grid-cols-3">
                <div v-for="stat in stats" :key="stat.value" class="flex flex-col gap-3" data-reveal>
                    <span class="font-mono text-6xl font-bold text-brand-orange lg:text-7xl">{{ stat.value }}</span>
                    <span class="font-display text-xl font-semibold text-paper">{{ stat.label }}</span>
                    <p class="text-sm text-stone">{{ stat.desc }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Testimonials -->
    <section class="bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 text-center" data-reveal>
                <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Рецензии</p>
                <h2 class="mt-2 font-display text-display-2 text-ink">Што велат клиентите</h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div
                    v-for="t in testimonials"
                    :key="t.name"
                    class="flex flex-col gap-6 rounded-2xl bg-paper p-6 shadow-sm"
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

                    <div>
                        <p class="font-semibold text-ink">{{ t.name }}</p>
                        <p class="text-sm text-stone">{{ t.role }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 7. Blog preview (статични placeholder картички — ќе се поврзат со реалните постови во подоцнежна фаза) -->
    <section class="border-t border-border bg-paper py-20 lg:py-28">
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
                    Сите написи →
                </Link>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <article
                    v-for="post in blogPosts"
                    :key="post.title"
                    class="flex flex-col gap-4 rounded-2xl border border-border bg-paper p-6"
                    data-reveal
                >
                    <div class="aspect-video w-full rounded-xl border border-border bg-paper-warm" />
                    <span class="inline-block self-start rounded-full bg-forest/10 px-3 py-1 text-xs font-medium text-forest">
                        {{ post.category }}
                    </span>
                    <h3 class="font-display text-h3 font-semibold leading-snug text-ink">
                        {{ post.title }}
                    </h3>
                    <div class="mt-auto flex items-center gap-2 font-mono text-xs text-stone">
                        <span>{{ post.date }}</span>
                        <span aria-hidden="true">·</span>
                        <span>{{ post.readTime }} читање</span>
                    </div>
                </article>
            </div>

        </div>
    </section>

    <!-- 8. Newsletter -->
    <section class="bg-paper-warm py-16 lg:py-20">
        <div class="mx-auto max-w-2xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
            <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Newsletter</p>
            <h2 class="mt-2 font-display text-display-2 text-ink">Останете информирани</h2>
            <p class="mt-4 text-base text-stone">
                Месечен дајџест — промени во даноците, корисни совети за МСП и фриленсери. Без спам.
            </p>
            <form class="mt-8 flex flex-col gap-3 sm:flex-row" @submit.prevent>
                <label for="newsletter-email" class="sr-only">Вашата email адреса</label>
                <input
                    id="newsletter-email"
                    type="email"
                    placeholder="vasha@email.com"
                    autocomplete="email"
                    class="grow rounded-full border border-border bg-paper px-5 py-3 text-base text-ink placeholder:text-stone focus:border-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-orange/20"
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

    <!-- 9. Контакт CTA -->
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
