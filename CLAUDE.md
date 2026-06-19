# FinanceBuddy.mk — Правила на кодирање

Проект: јавна веб-страница financebuddy.mk (Laravel 11 + Inertia.js + Vue 3 + Tailwind + MySQL)
Одделен проект од portal.financebuddy.mk — никогаш не ги мешај.
Целосна спецификација: /docs папката во овој проект.

## Стек
Laravel 11 / PHP 8.3+ · Inertia.js 2.x · Vue 3 Composition API · Tailwind CSS 3.x · Vite · MySQL 8

## PHP / Laravel
- Тенки контролери — валидација во Form Request класи, логика во модели/сервиси
- Form Requests за секоја валидација (никогаш inline $request->validate() за нетривијални случаи)
- Eloquent relationships експлицитно дефинирани во моделите
- Migrations за секоја промена на шема — никогаш директно во база
- Eager loading секаде каде се прикажуваат листи со релации (нема N+1)
- Сите кориснички видливи стрингови на македонски (flash messages, validation пораки)
- Именување: PascalCase класи, camelCase методи/променливи, snake_case колони/config клучеви

## Vue 3 / Inertia
- Секогаш `<script setup>` Composition API — никогаш Options API
- `defineOptions({ layout: PublicLayout })` за layout (не обвиткување рачно)
- `useForm` за сите форми (contact форма, admin форми)
- `route()` helper (Ziggy) за сите линкови — никогаш hardcoded URL-ови
- Компоненти под 150-200 линии; поголемо → извлечи во Components/
- Props секогаш типизирани (String, Array, Object, Boolean)

## Tailwind / стилизирање
- Дизајн токени дефинирани само во tailwind.config.js — никогаш bg-[#FF6600] во компоненти
- Токени: brand-orange, brand-orange-dark, ink, paper, paper-warm, forest, stone, border
- Фонтови: font-display (Fraunces), font-body (Inter), font-mono (JetBrains Mono)
- Mobile-first: прво мобилен, потоа md:/lg:
- Без custom CSS по компонента — само Tailwind utilities + централен app.css

## Рути (route names)
home · about · services.index · services.show · blog.index · blog.show · faq · career
contact.index · contact.store
admin.dashboard · admin.posts.* · admin.messages.*
URL патеки на македонска латиница: /uslugi, /kontakt, /kariera, /za-nas, /faq

## Безбедност
- Никогаш raw SQL со interpolated input — секогаш Eloquent/Query Builder
- Контакт пораки никогаш не се рендерираат како HTML (escaped text секогаш)
- CSRF заштита никогаш не се disable-ува
- Rate limiting на contact формата (throttle:5,1)
- File uploads: строга MIME валидација, UUID/slug+timestamp filename (никогаш оригинално корисничко ime)

## Git
- Commit пораки на англиски, мали и чести commits
- .env НИКОГАШ не оди во git
- .env.example секогаш ажуриран со сите клучеви (без вредности)

## Целосни преработки на мали/средни фајлови (под ~200 линии) наместо парцијални закрпи.
