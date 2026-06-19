# 02 — Технички стек и архитектура

## 1. Одлука: зошто Laravel + Inertia + Vue, а не WordPress

| Критериум | WordPress + Elementor (сегашно) | Laravel + Inertia + Vue (ново) |
|---|---|---|
| Брзина / Core Web Vitals | Слабо — тежок CSS/JS од page builder | Одлично — целосна контрола над секој byte |
| SEO фина контрола (schema, canonical, sitemap) | Ограничено, бара плагини (Yoast/RankMath) | Целосна, рачна контрола во код |
| Безбедност | Зависност од plugin updates, чест target за напади | Помала површина за напад, контролирани зависности |
| Конзистентност со портал | Поинаков стек, поинакво знаење | Ист стек — Гјоргји и Claude Code веќе го знаат патернот |
| Custom admin (блог + пораки) | Можно преку WP admin (туѓ UI) | Сопствен, прилагоден admin — целосна контрола над UX |
| Долгорочно одржување | Бара WP core + plugin + theme updates засекогаш | Composer/npm updates, помалку движечки делови |

**Заклучок:** нов проект, целосно одвоен codebase од порталот, но **истиот стек** заради
конзистентност во знаење и конвенции.

## 2. Стек — конкретни верзии

```
Backend:        Laravel 11.x (PHP 8.3+)
Frontend bridge: Inertia.js 2.x
Frontend:        Vue 3 (Composition API, <script setup>)
Styling:          Tailwind CSS 3.x
Build tool:       Vite
База:             MySQL 8 (конзистентно со портал — провери дали порталот користи MySQL или
                   PostgreSQL и усогласи; ако порталот користи PostgreSQL, овде исто за
                   конзистентност на бекап/restore процедури на серверот)
Image storage:     Локален storage/app/public + symlink, опционо DigitalOcean Spaces подоцна
                   ако сликите растат
Email:             Laravel Mail преку SMTP (видете 09-DEPLOYMENT.md за провајдер)
Cache:             Redis (опционо за почеток — file cache е доволен за мал сајт; Redis ако
                   порталот веќе го користи на истиот сервер, тогаш повторно искористи го)
```

## 3. Зошто Inertia.js (а не чист API + SPA, ниту чист Blade)

- **Чист Blade** би значел повторно пишување на интерактивни делови (форми, admin панел) во
  vanilla JS или Alpine — повеќе работа, помалку реактивност.
- **Чист REST API + одделен Vue SPA** додава непотребна сложеност (CORS, одделен deploy, auth
  токени) за сајт кој не треба да биде full SPA.
- **Inertia.js** дава "SPA чувство" (брзи transitions, без full page reload) додека серверската
  логика останува во Laravel контролери (routes, validation, authorization) — точно патернот кој
  веќе се користи во FinanceBuddy порталот, значи нула нова крива на учење.

## 4. SSR (Server-Side Rendering) — препорака

За маркетинг/SEO сајт, **препорачувам Inertia SSR (Vue SSR преку `@inertiajs/vue3` + Laravel
Vite SSR build)** ако е возможно во рамки на DigitalOcean дроплетот (бара Node процес паралелно
со PHP-FPM, или SSR build при deploy + Node server за SSR рендерирање).

**Зошто SSR е важно овде:** Googlebot денес добро рендерира JS, но SSR/pre-rendered HTML сепак
дава побрз **first contentful paint**, поконзистентно индексирање, и подобри social media preview
картички (Open Graph scrapers често НЕ извршуваат JS). За маркетинг сајт чија единствена цел е
SEO + конверзија, SSR е вреден инвестицијата.

**Алтернатива ако SSR се покаже комплицирано за серверска инфраструктура:** Inertia поддржува
**static prerendering** за страници кои не се динамични (Дома, За нас, Услуги, FAQ, Кариера) —
овие можат да се pre-render-ираат во build-time HTML, додека само блогот (со чести измени) останува
динамичен. Ова е добар среден пат ако полн SSR е премногу operational overhead за еден дроплет.

📌 **Одлука за Гјоргји/Claude Code на почеток на Фаза 3:** пробај SSR прво; ако perf тестот покаже
дека dropleта не може удобно да носи двата PHP-FPM + Node SSR процеси покрај порталот, премини на
prerendering пристапот.

## 5. Структура на проектот (Laravel конвенција)

```
financebuddy-web/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PageController.php        (Дома, За нас, Услуги, FAQ, Кариера)
│   │   │   ├── BlogController.php        (јавен блог - листа + единечен пост)
│   │   │   ├── ContactController.php     (прима contact form submissions)
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── PostController.php    (CRUD за блог постови)
│   │   │       └── MessageController.php (преглед на contact пораки)
│   │   ├── Requests/
│   │   │   ├── StoreContactMessageRequest.php
│   │   │   └── StorePostRequest.php / UpdatePostRequest.php
│   │   └── Middleware/
│   │       └── (auth за admin рути)
│   ├── Models/
│   │   ├── Post.php
│   │   ├── Category.php
│   │   ├── ContactMessage.php
│   │   └── User.php (само admin корисници — Гјоргји + опционо Тамара)
│   └── Mail/
│       ├── NewContactMessage.php   (известување до admin email)
│       └── ContactMessageReceived.php (потврда до подносителот, опционо)
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Pages/              (Inertia страници)
│   │   │   ├── Home.vue
│   │   │   ├── About.vue
│   │   │   ├── Services.vue
│   │   │   ├── ServiceDetail.vue
│   │   │   ├── Blog/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Show.vue
│   │   │   ├── Faq.vue
│   │   │   ├── Career.vue
│   │   │   ├── Contact.vue
│   │   │   └── Admin/
│   │   │       ├── Dashboard.vue
│   │   │       ├── Posts/ (Index, Create, Edit)
│   │   │       └── Messages/ (Index, Show)
│   │   ├── Components/         (повторно употребливи: Hero, ServiceCard, Testimonial, итн.)
│   │   ├── Layouts/
│   │   │   ├── PublicLayout.vue
│   │   │   └── AdminLayout.vue
│   │   └── app.js
│   └── css/
│       └── app.css             (Tailwind imports + custom design tokens)
├── routes/
│   ├── web.php                 (јавни рути)
│   └── admin.php               (admin рути, auth-заштитени)
├── storage/
├── public/
│   └── build/                  (Vite output)
└── docs/                       (оваа документација — копирана во проектот)
```

## 6. База на податоци — основни табели

```sql
-- posts (блог постови)
id, title, slug, excerpt, content (longtext, HTML или Markdown — види забелешка), 
featured_image_path, category_id, author_name, status (draft/published), 
published_at, meta_title, meta_description, og_image_path,
created_at, updated_at

-- categories (блог категории)
id, name, slug, created_at, updated_at

-- contact_messages
id, name, email, phone (nullable), service_interest (nullable),
message, status (new/read/replied/archived), 
ip_address, user_agent, created_at, updated_at

-- users (само внатрешни admin корисници)
id, name, email, password, role (admin/editor), created_at, updated_at
```

**Забелешка за `content` полето:** препорака е блог содржината да се пишува во **Markdown**
(зачувано како text во базата), а на frontend да се рендерира со Markdown→HTML конвертор
(на пр. `league/commonmark` на PHP страна, рендерирано server-side за SEO-чист HTML на секој
load). Ова е почисто и побезбедно отколку да се чува raw HTML од WYSIWYG editor (намалува XSS
ризик и прави porting/backup полесен). Admin панелот треба да има Markdown editor со live preview
(на пр. `@uiw/react-md-editor` нема Vue верзија директно — користи `md-editor-v3` или сличен Vue 3
Markdown editor пакет).

## 7. Автентикација за admin панел

- Користи **Laravel Breeze** (Inertia + Vue стек верзија) за брз, безбеден auth setup — login,
  logout, password reset, опционо 2FA подоцна.
- Само 1-2 корисници (Гјоргји, опционо Тамара) — нема потреба од регистрација отворена за јавност;
  корисниците се креираат рачно преку `php artisan tinker` или seeder, не преку јавна signup форма.
- Admin рутите (`/admin/*`) заштитени со `auth` middleware + custom `AdminLayout.vue` целосно
  одвоен визуелно од јавниот сајт (за да нема confusion дека е дел од маркетинг страницата).

## 8. Email испраќање

Контакт формата треба да:
1. Зачува секоја порака во базата (`contact_messages` табела) — ова е "извор на вистина", дури и
   ако email испраќањето падне.
2. Испрати email известување до Гјоргји/Тамара (`contact@financebuddy.mk` или специфичен внатрешен
   мејл) веднаш по поднесување.
3. Опционо: испрати автоматска потврда до подносителот ("Ја примивме вашата порака, ќе ви
   одговориме наскоро").

SMTP провајдер опции (детали и одлука во `09-DEPLOYMENT.md`): сопствен SMTP преку домен
(на пр. preку cPanel/Postfix на дроплетот — не препорачано, лесно завршува во spam), или надворешен
транзакциски email сервис (Brevo, Resend, Postmark, Mailgun — препорачано за подобра deliverability).

## 9. Идна проширливост — забелешки

- **Мултијазичност:** ако подоцна сака англиска верзија, Laravel localization (`lang/` фајлови +
  `{locale}/` URL prefix) се додава релативно лесно ако моделите (Post) од почеток имаат
  `locale` колона дури и ако моментално сите се `mk`. Не е задолжително сега, но спомнато за
  свесност при дизајн на migrations.
- **Headless консумирање:** ако некогаш сака содржината (блог постови) да се прикажува и на
  друга платформа (на пр. мобилна апликација), Laravel лесно изложува `/api/posts` JSON endpoint
  паралелно со Inertia страниците — архитектурата веќе го дозволува тоа без преработка.
