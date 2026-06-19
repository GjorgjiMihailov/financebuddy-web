# 10 — Roadmap (фази на развој)

> Користи го овој документ како главна "todo листа" низ Claude Code/Cowork сесии. Штиклирај
> ставки додека напредуваш, и ажурирај го документот ако планот се промени (видете
> `03-CODING-STANDARDS.md` §10 за филозофијата зад "жива документација").

## Фаза 0 — Документација ✅ (овој пакет документи)

- [x] `00-OVERVIEW.md`
- [x] `01-CONTENT-AUDIT.md`
- [x] `02-TECH-STACK.md`
- [x] `03-CODING-STANDARDS.md`
- [x] `04-LOGGING-MONITORING.md`
- [x] `05-DESIGN-SYSTEM.md`
- [x] `06-SEO-STRATEGY.md`
- [x] `07-SITE-STRUCTURE.md`
- [x] `08-CMS-ADMIN.md`
- [x] `09-DEPLOYMENT.md`
- [x] `10-ROADMAP.md` (овој документ)

## Фаза 1 — Дополнување на content audit (пред кодирање)

Отворени прашања кои бараат рачна потврда од Гјоргји/Тамара пред да продолжи развој (видете
ознаки 📌 низ сите документи за целосна листа):

- [x] Најди ги FB#1–5 блог постови — ✅ потврдени, додадени во `01-CONTENT-AUDIT.md` §9
- [x] Целосна листа на blog категории — ✅ **Business** (сите 20 постови) и **Marketing** (празна). "HR and Leadership" не е WP категорија.
- [x] Точни вредности за statistics counters — ✅ FL 38% / B2B 17% / Друштва 45% / Проекти 25 / Клиенти 12 / Успешност 29%
- [x] Потврди дали YouTube видеото останува релевантно — ✅ **се отстранува** од новиот сајт
- [x] Согласност од testimonial клиенти за повторна употреба — ✅ потврдена, LinkedIn линкови не се додаваат
- [x] Одлука: newsletter функција — ✅ полето се задржува, backend интеграција подоцна
- [x] Точен сервер software stack — ✅ Apache 2.4.52 / PHP 8.3.31 / MySQL / 12 GB слободно. `09-DEPLOYMENT.md` ажуриран.
- [x] Дали порталот користи MySQL или PostgreSQL — ✅ **MySQL**. `02-TECH-STACK.md` е веќе конзистентен.
- [x] WXR export + media backup — ✅ WXR .xml, media .zip (384MB), DB dump .sql зачувани локално

## Фаза 2 — Технички setup

- [ ] `laravel new financebuddy-web` со Inertia + Vue 3 + Tailwind preset
      (`laravel new --vue` или преку `laravel/breeze` Inertia stack installer)
- [ ] Git репозиториум иницијализиран, поврзан со GitHub
- [ ] `.gitignore` потврден (содржи `.env`, `node_modules`, `vendor`, `storage/logs`)
- [ ] Копирај ја `financebuddy-docs/` папката во `/docs` во новиот проект root
- [ ] Копирај содржина од `03-CODING-STANDARDS.md` во `CLAUDE.md` во проект root
- [ ] Tailwind config со design tokens од `05-DESIGN-SYSTEM.md` §10
- [ ] Основни migrations: `posts`, `categories`, `contact_messages`, ажурирана `users` табела
      (видете `02-TECH-STACK.md` §6)
- [ ] Laravel Breeze (Inertia/Vue) инсталиран за admin auth
- [ ] Сервер: нова база креирана, изолирани credentials (видете `09-DEPLOYMENT.md` §5)
- [ ] Сервер: vhost конфигуриран за `financebuddy.mk` (HTTP прво, HTTPS подоцна по DNS
      потврда)

## Фаза 3 — Основни layout компоненти

- [ ] `PublicLayout.vue` (header + footer wrapper)
- [ ] `AppHeader.vue` со целосна навигација + mobile hamburger
- [ ] `AppFooter.vue`
- [ ] `BrandUnderline.vue` (сигнатура елемент)
- [ ] Root Blade template со `<html lang="mk">`, JSON-LD `Organization` schema globalно вметнат
- [ ] Fonts вчитани (Fraunces, Inter, JetBrains Mono) — провери `font-display: swap`

## Фаза 4 — Статични јавни страници

- [ ] Дома (`/`) — целосна, со сите секции од `07-SITE-STRUCTURE.md` §4.1
- [ ] За нас (`/za-nas`) — проширена содржина
- [ ] Услуги overview (`/uslugi`)
- [ ] Услуги поединечни (8× `/uslugi/{slug}`)
- [ ] FAQ (`/faq`) — проширена на 15-20+ прашања, accordion UI, `FAQPage` schema
- [ ] Кариера (`/kariera`)
- [ ] Контакт (`/kontakt`) — форма + контакт инфо + опционо Maps embed

## Фаза 5 — Контакт форма (backend)

- [ ] `ContactMessage` model + migration
- [ ] `StoreContactMessageRequest` валидација
- [ ] `ContactController::store()` 
- [ ] Honeypot поле + throttle middleware (видете `08-CMS-ADMIN.md` §5.3)
- [ ] `NewContactMessage` Mailable + тестирано испраќање
- [ ] Feature тест за contact submission (видете `03-CODING-STANDARDS.md` §7)

## Фаза 6 — Блог систем (јавна страна)

- [ ] `Post`, `Category` models + relationships
- [ ] `BlogController::index()`, `show()`, категорија филтер
- [ ] `Blog/Index.vue`, `Blog/Show.vue` страници
- [ ] Markdown→HTML рендерирање (server-side, `league/commonmark`)
- [ ] "Поврзани постови" логика (иста категорија)
- [ ] `Article` schema на единечен пост
- [ ] Estimated reading time калкулација

## Фаза 7 — Admin панел

- [ ] Auth middleware на сите `/admin/*` рути
- [ ] `AdminLayout.vue` + `AdminSidebar.vue`
- [ ] Dashboard (`/admin`) со брз преглед
- [ ] Blog CRUD (листа, нов, уреди, бриши, preview)
- [ ] Markdown editor компонента интегрирана (`md-editor-v3` или сличен)
- [ ] Categories inline management
- [ ] Contact messages листа + детален приглед + статус управување
- [ ] Admin корисници seed-увани рачно (Гјоргји + опционо Тамара)
- [ ] Feature тестови: auth заштита, draft не е јавно видлив

## Фаза 8 — SEO имплементација

- [ ] Meta tags (title, description, OG, Twitter) на сите страници
- [ ] `og:locale: mk_MK` потврден насекаде
- [ ] JSON-LD: `Organization`/`LocalBusiness`, `Service` по услуга, `Article` по пост, `FAQPage`
- [ ] `sitemap.xml` автоматски генериран (`spatie/laravel-sitemap`)
- [ ] `robots.txt`
- [ ] Сите слики: WebP, дескриптивни filenames, alt текст
- [ ] Redirect мапа имплементирана (видете `06-SEO-STRATEGY.md` §5.2 — целосна листа по
      потврда на сите стари URL-ови од Фаза 1)

## Фаза 9 — Логирање, мониторинг, безбедност

- [ ] Daily log rotation конфигуриран
- [ ] Sentry (или email fallback) поставен
- [ ] Rate limiting на contact формата активен
- [ ] Database backup cron поставен И тестиран (пробен restore)
- [ ] UptimeRobot или сличен external monitor поставен
- [ ] Security headers (CSP, X-Frame-Options, итн.)
- [ ] `APP_DEBUG=false` потврдено пред лансирање

## Фаза 10 — Тестирање и квалитет

- [ ] Responsive тест на реални уреди (не само devtools) — минимум еден Android, еден iOS
- [ ] Accessibility брз аудит (tab navigation, focus states, контраст, screen reader basic тест)
- [ ] PageSpeed Insights резултат проверен (таргет: Core Web Vitals "Good")
- [ ] Cross-browser тест (Chrome, Safari, Firefox минимум)
- [ ] Сите форми тестирани со валидни И невалидни податоци
- [ ] 404 страница дизајнирана (не дифолт Laravel/сервер error page)
- [ ] 500 error страница дизајнирана (генерична, не излага debug инфо)

## Фаза 11 — Миграција на содржина

- [ ] Сите статични страници (Дома, За нас, Услуги, FAQ, Кариера, Контакт) пренесена содржина,
      ревидирана и проширена согласно `07-SITE-STRUCTURE.md`
- [ ] Сите постоечки blog постови (FB#1–20+) пренесени во новата база (рачно или скриптирано
      преку WXR parse)
- [ ] Сите слики пренесени, конвертирани во WebP, ре-именувани дескриптивно
- [ ] Финална рачна проверка: секоја стара URL од `01-CONTENT-AUDIT.md` тестирана дека редиректира
      правилно

## Фаза 12 — Лансирање (DNS cutover)

- [ ] Финален backup на старата WordPress инсталација (WXR + медиа + DB dump) зачуван трајно
- [ ] HTTPS сертификат потврден за новиот домен пред DNS промена
- [ ] DNS A/CNAME records променети кон новиот Laravel проект
- [ ] Веднаш по propagation: тест на сите главни патеки (Дома, форма, blog) на живо
- [ ] Sitemap поднесен во Google Search Console
- [ ] Google Business Profile ажуриран ако е потребно
- [ ] Следи GSC Coverage извештај дневно првите 2 недели

## Фаза 13 — Post-launch (континуирано)

- [ ] Месечен преглед на Core Web Vitals (GSC)
- [ ] Редовно објавување нови blog постови (продолжи FB# серија)
- [ ] Квартален преглед на content/SEO стратегија — кои страници/постови добро перформираат,
      каде треба повеќе содржина
- [ ] Редовни (барем месечни) проверки дека backup системот реално работи
