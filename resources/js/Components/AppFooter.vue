<script setup>
import { Link } from '@inertiajs/vue3'

const currentYear = new Date().getFullYear()

const footerServices = [
    { name: 'Финансиско сметководство', slug: 'finansisko-smetkovodstvo' },
    { name: 'Даночен консалтинг', slug: 'danocen-konsalting' },
    { name: 'Регистрација фирма', slug: 'registracija-firma' },
    { name: 'Пресметка на плати', slug: 'presmetka-na-plati' },
]
</script>

<template>
    <footer class="bg-ink text-paper/80">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">

                <!-- Лого + опис -->
                <div class="lg:col-span-1">
                    <Link
                        href="/"
                        class="inline-block rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    >
                        <span class="font-display text-xl font-bold text-paper">
                            Finance<span class="text-brand-orange">Buddy</span><span class="text-stone">.mk</span>
                        </span>
                    </Link>
                    <p class="mt-4 text-sm leading-relaxed text-stone">
                        Сметководствени услуги за фриленсери и мали бизниси.<br>
                        Помалку администрација, повеќе бизнис.
                    </p>
                </div>

                <!-- Линкови -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-stone">
                        Линкови
                    </h3>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <Link href="/za-nas" class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded">
                                За нас
                            </Link>
                        </li>
                        <li>
                            <Link href="/kariera" class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded">
                                Кариера
                            </Link>
                        </li>
                        <li>
                            <Link href="/blog" class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded">
                                Блог
                            </Link>
                        </li>
                        <li>
                            <Link href="/faq" class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded">
                                FAQ
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Услуги -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-stone">
                        Услуги
                    </h3>
                    <ul class="mt-4 space-y-3">
                        <li v-for="service in footerServices" :key="service.slug">
                            <Link
                                :href="`/uslugi/${service.slug}`"
                                class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded"
                            >
                                {{ service.name }}
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/uslugi"
                                class="text-sm font-medium text-brand-orange transition-colors duration-150 hover:text-brand-orange-dark focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded"
                            >
                                Сите услуги →
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Контакт -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-stone">
                        Контакт
                    </h3>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <a
                                href="tel:+38970000000"
                                class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded"
                            >
                                +389 XX XXX XXX
                            </a>
                        </li>
                        <li>
                            <a
                                href="mailto:financebuddy.mk@gmail.com"
                                class="text-sm text-paper/70 transition-colors duration-150 hover:text-paper focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-brand-orange rounded"
                            >
                                financebuddy.mk@gmail.com
                            </a>
                        </li>
                        <li class="text-sm text-stone">
                            Скопје, Македонија
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Долна лента: copyright + правно название -->
            <div class="mt-12 flex flex-col gap-2 border-t border-paper/10 pt-8 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-stone">
                    © {{ currentYear }} FinanceBuddy.mk. Сите права задржани.
                </p>
                <p class="text-xs text-stone/60">
                    Друштво за трговија и услуги ФАЈНЕНС БАДИ ДООЕЛ Скопје
                </p>
            </div>
        </div>
    </footer>
</template>
