<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const isScrolled = ref(false)
const isMobileOpen = ref(false)
const isServicesOpen = ref(false)
const servicesRef = ref(null)

function handleScroll() {
    isScrolled.value = window.scrollY > 20
}

function handleClickOutside(event) {
    if (servicesRef.value && !servicesRef.value.contains(event.target)) {
        isServicesOpen.value = false
    }
}

function closeMobile() {
    isMobileOpen.value = false
    isServicesOpen.value = false
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true })
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
    document.removeEventListener('click', handleClickOutside)
})

// Ажурирај ги slug-овите кога се создаваат страниците во Фаза 4
const services = [
    { name: 'Финансиско сметководство', slug: 'finansisko-smetkovodstvo' },
    { name: 'Материјално сметководство', slug: 'materijalno-smetkovodstvo' },
    { name: 'Даночен консалтинг', slug: 'danocen-konsalting' },
    { name: 'Регистрација фирма', slug: 'registracija-firma' },
    { name: 'Пресметка на плати', slug: 'presmetka-na-plati' },
    { name: 'Финансиски извештаи', slug: 'finansiski-izvestai' },
    { name: 'Консалтинг за МСП', slug: 'konsalting-za-msp' },
    { name: 'Даночна оптимизација', slug: 'danocna-optimizacija' },
]
</script>

<template>
    <header
        class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="isScrolled
            ? 'bg-paper shadow-sm border-b border-border'
            : 'bg-transparent'"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between lg:h-20">

                <!-- Лого -->
                <Link
                    href="/"
                    class="flex shrink-0 items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                >
                    <img
                        src="/images/logofaktura.png"
                        alt="FinanceBuddy.mk"
                        class="h-9 w-auto lg:h-11"
                    >
                </Link>

                <!-- Десктоп навигација -->
                <nav class="hidden items-center gap-1 lg:flex" aria-label="Главна навигација">
                    <Link
                        href="/"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        Дома
                    </Link>
                    <Link
                        href="/za-nas"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        За нас
                    </Link>

                    <!-- Услуги со dropdown -->
                    <div ref="servicesRef" class="relative">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            :aria-expanded="isServicesOpen"
                            aria-haspopup="true"
                            @click="isServicesOpen = !isServicesOpen"
                            @keydown.escape="isServicesOpen = false"
                        >
                            Услуги
                            <svg
                                class="h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': isServicesOpen }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <Transition
                            enter-active-class="transition duration-150 ease-out"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-show="isServicesOpen"
                                class="absolute left-0 top-full mt-2 w-64 rounded-xl border border-border bg-paper shadow-lg"
                            >
                                <div class="py-2">
                                    <Link
                                        href="/uslugi"
                                        class="block px-4 py-2.5 text-sm font-semibold text-brand-orange transition-colors hover:bg-paper-warm"
                                        @click="isServicesOpen = false"
                                    >
                                        Сите услуги →
                                    </Link>
                                    <div class="my-1 border-t border-border" />
                                    <Link
                                        v-for="service in services"
                                        :key="service.slug"
                                        :href="`/uslugi/${service.slug}`"
                                        class="block px-4 py-2 text-sm text-stone transition-colors hover:bg-paper-warm hover:text-ink"
                                        @click="isServicesOpen = false"
                                    >
                                        {{ service.name }}
                                    </Link>
                                </div>
                            </div>
                        </Transition>
                    </div>

                    <Link
                        href="/blog"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        Блог
                    </Link>
                    <Link
                        href="/faq"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        FAQ
                    </Link>
                    <Link
                        href="/kontakt"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone transition-colors duration-150 hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        Контакт
                    </Link>
                </nav>

                <!-- CTA копче (десктоп) -->
                <div class="hidden lg:block">
                    <Link
                        href="/kontakt"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-orange px-5 py-2.5 text-sm font-semibold text-white transition-all duration-150 hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                    >
                        Побарај понуда
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>

                <!-- Hamburger копче (мобилен) -->
                <button
                    type="button"
                    class="flex items-center justify-center rounded-lg p-2 text-ink transition-colors hover:bg-paper-warm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange lg:hidden"
                    :aria-expanded="isMobileOpen"
                    :aria-label="isMobileOpen ? 'Затвори мени' : 'Отвори мени'"
                    @click="isMobileOpen = !isMobileOpen"
                >
                    <svg v-if="!isMobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Мобилно мени -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div v-show="isMobileOpen" class="border-t border-border bg-paper lg:hidden">
                <nav class="mx-auto max-w-7xl px-4 py-4 sm:px-6" aria-label="Мобилна навигација">
                    <div class="flex flex-col gap-1">
                        <Link
                            href="/"
                            class="rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            @click="closeMobile"
                        >
                            Дома
                        </Link>
                        <Link
                            href="/za-nas"
                            class="rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            @click="closeMobile"
                        >
                            За нас
                        </Link>

                        <!-- Услуги — expand/collapse на мобилен (не hover) -->
                        <div>
                            <button
                                type="button"
                                class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                                :aria-expanded="isServicesOpen"
                                @click="isServicesOpen = !isServicesOpen"
                            >
                                Услуги
                                <svg
                                    class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': isServicesOpen }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div v-show="isServicesOpen" class="ml-4 mt-1 flex flex-col gap-0.5 border-l-2 border-border pl-4">
                                <Link
                                    href="/uslugi"
                                    class="rounded px-2 py-2 text-sm font-semibold text-brand-orange transition-colors hover:bg-paper-warm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                                    @click="closeMobile"
                                >
                                    Сите услуги
                                </Link>
                                <Link
                                    v-for="service in services"
                                    :key="service.slug"
                                    :href="`/uslugi/${service.slug}`"
                                    class="rounded px-2 py-2 text-sm text-stone transition-colors hover:bg-paper-warm hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                                    @click="closeMobile"
                                >
                                    {{ service.name }}
                                </Link>
                            </div>
                        </div>

                        <Link
                            href="/blog"
                            class="rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            @click="closeMobile"
                        >
                            Блог
                        </Link>
                        <Link
                            href="/faq"
                            class="rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            @click="closeMobile"
                        >
                            FAQ
                        </Link>
                        <Link
                            href="/kontakt"
                            class="rounded-lg px-3 py-2.5 text-base font-medium text-ink transition-colors hover:bg-paper-warm hover:text-brand-orange focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            @click="closeMobile"
                        >
                            Контакт
                        </Link>

                        <div class="mt-4 border-t border-border pt-4">
                            <Link
                                href="/kontakt"
                                class="flex items-center justify-center gap-2 rounded-full bg-brand-orange px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                                @click="closeMobile"
                            >
                                Побарај понуда →
                            </Link>
                        </div>
                    </div>
                </nav>
            </div>
        </Transition>
    </header>
</template>
