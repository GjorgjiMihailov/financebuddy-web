<script setup>
import { computed, onMounted } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

const services = [
    'Финансиско сметководство',
    'Материјално сметководство',
    'Даночен консалтинг',
    'Регистрација фирма',
    'Пресметка на плати',
    'Финансиски извештаи',
    'Консалтинг за МСП',
    'Даночна оптимизација',
    'Општо прашање',
]

const form = useForm({
    name: '',
    email: '',
    phone: '',
    service_interest: '',
    message: '',
    website: '',
})

const page = usePage()
const submitted = computed(() => !!page.props.flash?.success)

function handleSubmit() {
    form.post(route('contact.store'))
}

onMounted(() => {
    const params = new URLSearchParams(window.location.search)
    const usluga = params.get('usluga')
    if (usluga && services.includes(usluga)) {
        form.service_interest = usluga
    }

    const observer = new IntersectionObserver(
        (entries) => entries.forEach(e => e.target.classList.toggle('revealed', e.isIntersecting)),
        { threshold: 0.1 },
    )
    document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el))

    const schema = document.createElement('script')
    schema.type = 'application/ld+json'
    schema.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'ProfessionalService',
        name: 'FinanceBuddy.mk',
        legalName: 'Друштво за трговија и услуги ФАЈНЕНС БАДИ ДООЕЛ Скопје',
        url: 'https://financebuddy.mk',
        logo: 'https://financebuddy.mk/images/logofaktura.png',
        telephone: '+38977881701',
        email: 'contact@financebuddy.mk',
        address: {
            '@type': 'PostalAddress',
            streetAddress: 'ул. Венијамин Мачуковски бр. 34/1-50',
            addressLocality: 'Скопје',
            addressRegion: 'Аеродром',
            postalCode: '1000',
            addressCountry: 'MK',
        },
        openingHoursSpecification: [
            {
                '@type': 'OpeningHoursSpecification',
                dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                opens: '09:00',
                closes: '17:00',
            },
        ],
        sameAs: [
            'https://www.facebook.com/FinanceBuddy.mk/',
            'https://www.instagram.com/financebuddy.mk/',
            'https://x.com/Financebuddymk',
            'https://www.linkedin.com/company/financebuddy-mk',
        ],
    })
    document.head.appendChild(schema)
})
</script>

<template>
    <Head>
        <title>Контакт | FinanceBuddy.mk</title>
        <meta name="description" content="Контактирај нè — телефон, email или контакт форма. Закажи бесплатна консултација за сметководство, данок и финансии. FinanceBuddy.mk, Скопје." />
        <link rel="canonical" href="https://financebuddy.mk/kontakt" />
        <meta property="og:title" content="Контакт | FinanceBuddy.mk" />
        <meta property="og:description" content="Контактирај нè — телефон, email или контакт форма. Закажи бесплатна консултација за сметководство, данок и финансии." />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://financebuddy.mk/kontakt" />
        <meta property="og:image" content="https://financebuddy.mk/images/og-default.jpg" />
        <meta property="og:site_name" content="FinanceBuddy.mk" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Financebuddymk" />
    </Head>

    <!-- 1. HERO -->
    <section class="bg-paper pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span
                    class="animate-fade-up mb-6 inline-block rounded-full bg-brand-orange/10 px-4 py-1.5 text-sm font-medium text-brand-orange"
                    style="animation-delay: 0ms"
                >
                    Контакт
                </span>
                <h1
                    class="animate-fade-up font-display text-display-1 leading-tight text-ink"
                    style="animation-delay: 80ms"
                >
                    Да зборуваме.
                </h1>
                <p
                    class="animate-fade-up mx-auto mt-6 max-w-xl text-lg text-stone"
                    style="animation-delay: 160ms"
                >
                    Бесплатна консултација — без обврски. Одговараме во рок од еден работен ден.
                </p>
            </div>
        </div>
    </section>

    <!-- 2. КОНТАКТ ИНФО + ФОРМА -->
    <section class="border-t border-border bg-paper-warm py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-5">

                <!-- Контакт информации -->
                <div class="lg:col-span-2" data-reveal>
                    <p class="text-sm font-medium uppercase tracking-widest text-brand-orange">Информации</p>
                    <h2 class="mt-2 font-display text-display-2 text-ink">Нè најдете</h2>

                    <dl class="mt-10 flex flex-col gap-8">
                        <!-- Телефон -->
                        <div class="flex gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-orange/10">
                                <svg class="h-5 w-5 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-stone">Телефон</dt>
                                <dd class="mt-0.5">
                                    <a href="tel:+38977881701" class="font-semibold text-ink transition-colors hover:text-brand-orange">
                                        +389 77 881 701
                                    </a>
                                </dd>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-orange/10">
                                <svg class="h-5 w-5 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-stone">Email</dt>
                                <dd class="mt-0.5">
                                    <a href="mailto:contact@financebuddy.mk" class="font-semibold text-ink transition-colors hover:text-brand-orange">
                                        contact@financebuddy.mk
                                    </a>
                                </dd>
                            </div>
                        </div>

                        <!-- Адреса -->
                        <div class="flex gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-orange/10">
                                <svg class="h-5 w-5 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-stone">Адреса</dt>
                                <dd class="mt-0.5 font-semibold leading-snug text-ink">
                                    ул. „Венијамин Мачуковски" бр. 34/1-50<br>
                                    1000 Скопје – Аеродром
                                </dd>
                            </div>
                        </div>
                    </dl>

                    <!-- Социјални -->
                    <div class="mt-10">
                        <p class="text-sm font-medium text-stone">Следи нè</p>
                        <div class="mt-3 flex gap-3">
                            <a href="https://facebook.com/FinanceBuddy.mk" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full border border-border bg-paper text-stone transition-colors hover:border-brand-orange/40 hover:text-brand-orange">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://instagram.com/financebuddy.mk" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full border border-border bg-paper text-stone transition-colors hover:border-brand-orange/40 hover:text-brand-orange">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://linkedin.com/company/financebuddy-mk" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="flex h-9 w-9 items-center justify-center rounded-full border border-border bg-paper text-stone transition-colors hover:border-brand-orange/40 hover:text-brand-orange">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="https://x.com/Financebuddymk" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" class="flex h-9 w-9 items-center justify-center rounded-full border border-border bg-paper text-stone transition-colors hover:border-brand-orange/40 hover:text-brand-orange">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Контакт форма -->
                <div class="lg:col-span-3" data-reveal>
                    <!-- Success state -->
                    <div
                        v-if="submitted"
                        class="flex flex-col items-center gap-4 rounded-2xl border border-forest/20 bg-forest/5 p-10 text-center"
                    >
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-forest/10">
                            <svg class="h-7 w-7 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 class="font-display text-h3 font-semibold text-ink">Пораката е примена!</h2>
                        <p class="text-base text-stone">Ќе ви одговориме во рок од еден работен ден. Благодариме за довербата.</p>
                    </div>

                    <!-- Form -->
                    <form
                        v-else
                        class="flex flex-col gap-5 rounded-2xl border border-border bg-paper p-8"
                        @submit.prevent="handleSubmit"
                        novalidate
                    >
                        <h2 class="font-display text-h3 font-semibold text-ink">Испрати порака</h2>

                        <!-- Honeypot -->
                        <input
                            v-model="form.website"
                            type="text"
                            name="website"
                            tabindex="-1"
                            autocomplete="off"
                            aria-hidden="true"
                            style="position:absolute; left:-9999px; width:1px; height:1px; overflow:hidden;"
                        >

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="flex flex-col gap-1.5">
                                <label for="name" class="text-sm font-medium text-ink">Ime и презиме <span class="text-brand-orange" aria-hidden="true">*</span></label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    autocomplete="name"
                                    placeholder="Марко Марковски"
                                    :class="[
                                        'rounded-xl border bg-paper-warm px-4 py-3 text-base text-ink placeholder:text-stone/60 focus:outline-none focus:ring-2',
                                        form.errors.name
                                            ? 'border-red-400 focus:border-red-400 focus:ring-red-200'
                                            : 'border-border focus:border-brand-orange focus:ring-brand-orange/20',
                                    ]"
                                >
                                <p v-if="form.errors.name" class="text-xs text-red-600">{{ form.errors.name }}</p>
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="email" class="text-sm font-medium text-ink">Email <span class="text-brand-orange" aria-hidden="true">*</span></label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    autocomplete="email"
                                    placeholder="marko@email.com"
                                    :class="[
                                        'rounded-xl border bg-paper-warm px-4 py-3 text-base text-ink placeholder:text-stone/60 focus:outline-none focus:ring-2',
                                        form.errors.email
                                            ? 'border-red-400 focus:border-red-400 focus:ring-red-200'
                                            : 'border-border focus:border-brand-orange focus:ring-brand-orange/20',
                                    ]"
                                >
                                <p v-if="form.errors.email" class="text-xs text-red-600">{{ form.errors.email }}</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="flex flex-col gap-1.5">
                                <label for="phone" class="text-sm font-medium text-ink">Телефон <span class="text-stone text-xs font-normal">(опционо)</span></label>
                                <input
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    autocomplete="tel"
                                    placeholder="+389 7X XXX XXX"
                                    class="rounded-xl border border-border bg-paper-warm px-4 py-3 text-base text-ink placeholder:text-stone/60 focus:border-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-orange/20"
                                >
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="service_interest" class="text-sm font-medium text-ink">Тип на интересирање</label>
                                <select
                                    id="service_interest"
                                    v-model="form.service_interest"
                                    class="rounded-xl border border-border bg-paper-warm px-4 py-3 text-base text-ink focus:border-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-orange/20"
                                >
                                    <option value="" disabled>Изберете услуга...</option>
                                    <option v-for="s in services" :key="s" :value="s">{{ s }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="message" class="text-sm font-medium text-ink">Порака <span class="text-brand-orange" aria-hidden="true">*</span></label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                required
                                rows="5"
                                placeholder="Кажете ни накратко со што можеме да ви помогнеме..."
                                :class="[
                                    'resize-none rounded-xl border bg-paper-warm px-4 py-3 text-base text-ink placeholder:text-stone/60 focus:outline-none focus:ring-2',
                                    form.errors.message
                                        ? 'border-red-400 focus:border-red-400 focus:ring-red-200'
                                        : 'border-border focus:border-brand-orange focus:ring-brand-orange/20',
                                ]"
                            />
                            <p v-if="form.errors.message" class="text-xs text-red-600">{{ form.errors.message }}</p>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-orange px-6 py-3 font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 disabled:opacity-60"
                        >
                            <svg v-if="form.processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            {{ form.processing ? 'Се испраќа...' : 'Испрати порака' }}
                        </button>

                        <p class="text-xs text-stone">Задолжителните полиња се означени со <span class="text-brand-orange">*</span>. Одговараме во рок од еден работен ден.</p>
                    </form>
                </div>

            </div>
        </div>
    </section>
</template>
