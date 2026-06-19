# 06 — SEO стратегија (техничка + содржинска)

## 1. Основа — позиција на сајтот

`.mk` домен е силен geo-сигнал сам по себе (country-code TLD), и сајтот е целосно на македонски,
насочен кон корисници во Северна Македонија — нема потреба од сложена меѓународна
hreflang/multi-region поставка. Фокус: **технички совршено изведен monolingual mk-MK сајт.**

## 2. Технички SEO — основни столбови

### 2.1 Meta податоци (на секоја страница, без исклучок)

```html
<title>Конкретен наслов | FinanceBuddy.mk</title>
<meta name="description" content="155-160 карактери, специфично за страницата, не генеричко">
<link rel="canonical" href="https://financebuddy.mk/конкретна-патека">

<meta property="og:title" content="...">
<meta property="og:description" content="...">
<meta property="og:image" content="https://financebuddy.mk/...">
<meta property="og:locale" content="mk_MK">  <!-- ВАЖНО: тековниот сајт има грешка - en_US! -->
<meta property="og:type" content="website">  <!-- "article" за blog постови -->
<meta property="og:site_name" content="FinanceBuddy.mk">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@Financebuddymk">
```

**Имплементација во Laravel/Inertia:** користи `<Head>` компонента од Inertia на секоја `.vue`
страница, со props пренесени од контролерот (особено за blog постови каде title/description се
динамички, од базата — `meta_title`/`meta_description` колоните дефинирани во `02-TECH-STACK.md`).

📌 Поправи ја `og:locale` грешката од стариот сајт веднаш — секогаш `mk_MK`, никогаш `en_US`.

### 2.2 `<html lang="mk">` атрибут

Секоја страница мора да има `<html lang="mk">` во root layout (Laravel Blade root template кој
Inertia го рендерира во). Ова е основен, но често заборавен сигнал и за SEO и за accessibility
(screen readers).

### 2.3 Structured data (JSON-LD schema.org)

| Тип на страница | Schema |
|---|---|
| Секоја страница (глобално, во footer/layout) | `Organization` — име, лого, contact info, социјални профили (`sameAs`) |
| Дома | `Organization` + `WebSite` (со `SearchAction` ако додадете internal search подоцна) |
| Контакт страница | `LocalBusiness` (со `ProfessionalService` подтип — точна категорија за сметководствена фирма) — адреса, телефон, работно време |
| Услуги (секоја поединечна) | `Service` schema по услуга |
| Blog листа | `Blog` |
| Секој blog пост | `Article` (или `BlogPosting`) — наслов, автор, датум на објава, featured image |
| FAQ страница | `FAQPage` — секое прашање/одговор пар, **значителна SEO можност** бидејќи Google директно прикажува FAQ rich results во пребарување |
| Testimonials (на Дома) | `Review` или `AggregateRating` во склоп на `LocalBusiness` (внимание: точните testimonials мора да се реални, не да се "измислуваат" рејтинзи) |

**Пример `Organization` + `LocalBusiness` JSON-LD (за вметнување во root layout):**

```json
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "FinanceBuddy.mk",
  "legalName": "Друштво за трговија и услуги ФАЈНЕНС БАДИ ДООЕЛ Скопје",
  "url": "https://financebuddy.mk",
  "logo": "https://financebuddy.mk/images/logo.png",
  "telephone": "+38977881701",
  "email": "contact@financebuddy.mk",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "ул. Венијамин Мачуковски бр. 34/1-50",
    "addressLocality": "Скопје",
    "addressRegion": "Аеродром",
    "postalCode": "1000",
    "addressCountry": "MK"
  },
  "sameAs": [
    "https://www.facebook.com/FinanceBuddy.mk/",
    "https://www.instagram.com/financebuddy.mk/",
    "https://x.com/Financebuddymk",
    "https://www.linkedin.com/company/financebuddy-mk"
  ]
}
```

**Важна напомена за `legalName`:** ова поле во schema markup е токму местото каде официјалното
правно име треба да се наведе (за усогласеност / правна точност), додека `name` останува
трговското име "FinanceBuddy.mk" кое реално се користи насекаде во UI и комуникација. Ова е
единствено место на сајтот каде правното име треба експлицитно да се прикаже (плус опционо мала
нота во footer-от, видете §7).

### 2.4 Sitemap.xml

Автоматски генериран (Laravel package `spatie/laravel-sitemap` е добра, добро одржувана опција),
регенериран при секој нов/изменет blog пост (cron или triggered при publish action).

```
/sitemap.xml
  → сите статични страници (Дома, За нас, Услуги + подстраници, FAQ, Кариера, Контакт)
  → /blog (листа)
  → секој /blog/{slug} (со lastmod датум = updated_at од базата)
```

### 2.5 Robots.txt

```
User-agent: *
Allow: /
Disallow: /admin/

Sitemap: https://financebuddy.mk/sitemap.xml
```

Едноставно, чисто — нема причина да се блокираат делови од јавниот сајт. Admin панелот е
disallow-иран од учтивост кон crawlers (иако веќе е auth-заштитен, не треба да се појавува во
индекс).

### 2.6 Core Web Vitals — таргети

| Метрика | Таргет | Како се постигнува |
|---|---|---|
| LCP (Largest Contentful Paint) | < 2.5s | SSR/prerendering (видете `02-TECH-STACK.md` §4), оптимизирани hero слики (WebP/AVIF, правилна големина, `fetchpriority="high"` на hero слика) |
| INP (Interaction to Next Paint) | < 200ms | Минимален JS bundle, избегнување тешки трети-страна скрипти |
| CLS (Cumulative Layout Shift) | < 0.1 | Експлицитни `width`/`height` на сите слики, резервирани места за динамична содржина (на пр. ads — нема ги овде, но и за fonts: `font-display: swap` со fallback fonts со слични метрики) |

Тестирање: PageSpeed Insights (pagespeed.web.dev) и Google Search Console "Core Web Vitals"
извештај, проверувано редовно по лансирање.

### 2.7 Сликовна оптимизација

- Сите слики во **WebP** формат (со AVIF како progressive enhancement каде е поддржано), со
  правилни `width`/`height` атрибути.
- **Дескриптивни filename-ови** (не `IMG_2024.jpg` туку `tamara-micevska-ceo-financebuddy.webp`)
  — мал, но реален сигнал за Google Images пребарување.
- **Описен `alt` текст** на секоја слика (видете `03-CODING-STANDARDS.md` §4 за пристапност;
  истото правило служи двојна цел и за SEO).
- `loading="lazy"` на сите слики освен hero/above-the-fold.

## 3. Содржинско SEO — структура на страници и keyword насока

### 3.1 Услуги — секоја заслужува своја URL (главна промена од тековен сајт)

Тековниот сајт има 8 услуги наброени, но **сите линкуваат кон /contact** без сопствени страници
(забележано во `01-CONTENT-AUDIT.md` §6). Ова е пропуштена можност — секоја услуга треба своја
URL со специфична содржина, за да може да рангира за специфични пребарувања:

```
/uslugi                                    (overview страница, листа сите)
/uslugi/finansisko-smetkovodstvo
/uslugi/materijalno-smetkovodstvo
/uslugi/danocen-konsalting
/uslugi/administrativen-konsalting
/uslugi/registracija-na-firma
/uslugi/advokatski-uslugi
/uslugi/biznis-razvoj-i-sovetuvanje
/uslugi/tehnicko-sovetuvanje
```

Секоја страница: специфичен наслов/мета опис, конкретна содржина (што точно вклучува услугата,
за кого е наменета — фриленсер vs. компанија, чести прашања специфични за таа услуга, CTA кон
контакт). Ова значително го проширува "thin content" проблемот забележан во audit-от и дава
многу повеќе таргетирани keyword можности.

**Пример keyword насока по услуга** (рачно истражување препорачано пред пишување, но насока):
- "сметководствена агенција скопје"
- "регистрација на фирма македонија цена"
- "даночен консултант фриленсери"
- "сметководство за фриленсери македонија"
- "ДДВ регистрација услови"

### 3.2 Блог — содржинска стратегија

Постоечкиот блог (20+ постови, FB# серија) е силна основа — содржината е специфична, практична,
одговара на реални прашања (Payoneer, УЈП, freelance даноци). Препораки за продолжување:

1. **Задржи го FB# нумерирачкиот систем** — дава чувство на континуитет/архива, и брендирана е
   ("FB#21" наместо генерички наслов).
2. **Категоризирај построго** — тековно е видена само "HR and Leadership" категорија; добра
   структура би била: *Даноци и УЈП* / *Фриленсери* / *HR и лидерство* / *Бизнис развој* /
   *Правни прашања*. Категориите стануваат `/blog/kategorija/danoci-i-ujp` — дополнителни
   индексирани страници со таргетирана содржина.
3. **Internal linking** — секој нов пост треба да линкува кон 2-3 релевантни постари постови
   и кон релевантна услуга страница (на пр. пост за ДДВ регистрација линкува кон
   `/uslugi/danocen-konsalting`). Ова е еден од најмоќните, а најчесто занемарени SEO фактори.
4. **"Поврзани постови" секција** на дното на секој blog пост (автоматска, базирана на иста
   категорија).

### 3.3 FAQ страница — значителна можност

Само 3 прашања тековно (видено во audit) — мал инвестмент со голем потенцијален поврат бидејќи
`FAQPage` schema директно се прикажува во Google пребарување резултати (rich snippet, повеќе
простор на резултатската страница = повеќе кликови). Препорака: прошири на минимум 15-20
прашања, групирани по категорија (Даноци, Фриленсерство, Регистрација на фирма, ДДВ, итн.) —
многу од содржината веројатно веќе постои имплицитно во blog постовите и може да се
"екстрахира"/преформулира во FAQ формат.

### 3.4 Naslov хиерархија (H1-H6) — правило

Секоја страница: **точно еден `<h1>`** (главниот наслов на таа конкретна страница, не логото).
`<h2>` за главни секции, `<h3>` за подсекции. Никогаш не се прескокнуваат нивоа (h1 → h3 директно)
заради и SEO и accessibility причини.

## 4. Локален SEO (Google Business Profile)

Не е дел од кодот, но критично дополнение:

- [ ] Провери/направи **Google Business Profile** за FinanceBuddy.mk со точна адреса, телефон,
      категорија ("Сметководствена фирма" / "Accounting firm"), работно време.
- [ ] NAP конзистентност (Name, Address, Phone) — точно истите податоци на сајтот, Google
      Business Profile, и сите социјални профили. И малите разлики (на пр. "ул." vs "улица")
      можат да го ослабнат локалниот SEO сигнал.
- [ ] Поттикни задоволни клиенти да остават Google рецензии (директно влијае на локално
      рангирање).

## 5. Миграција и редиректи — критично за да не се изгуби постоечки SEO ranking

### 5.1 Принцип

Секоја постоечка индексирана URL **мора** да има 301 (permanent) redirect кон новата
соодветна URL, или (за blog постови) да ја задржи **истата URL точно** ако е possible.

### 5.2 Конкретен план

| Стара URL | Нова URL | Акција |
|---|---|---|
| `/` | `/` | Без редирект (исто) |
| `/about/` | `/za-nas` (или `/about` ако се задржи) | 301 redirect |
| `/services/` | `/uslugi` | 301 redirect |
| `/contact/` | `/kontakt` | 301 redirect |
| `/faq` | `/faq` | Без редирект (исто, ако се задржи патеката) |
| `/career` | `/kariera` | 301 redirect |
| `/financeblog/` | `/blog` | 301 redirect |
| Секој `/{post-slug}/` | **истиот** `/{post-slug}` (без trailing slash промена ако е можно, или 301 ако серверот менува) | Задржи точно или 301 една-кон-една, видете `01-CONTENT-AUDIT.md` §9 за целосна листа на slug-ови |

**Имплементација во Laravel:** прост redirect routes фајл или `routes/redirects.php` мапа која
се вчитува во `routes/web.php`:

```php
// routes/redirects.php — конзистентна мапа на стари→нови патеки
Route::redirect('/about', '/za-nas', 301);
Route::redirect('/services', '/uslugi', 301);
Route::redirect('/contact', '/kontakt', 301);
Route::redirect('/career', '/kariera', 301);
Route::redirect('/financeblog', '/blog', 301);
// blog slug-ови: ако новата шема е /blog/{slug}, а старата беше root-level /{slug},
// потребен е redirect по секој конкретен slug бидејќи нема automatic pattern match
Route::redirect('/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat', '/blog/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat', 301);
// ... (повтори за секој од 20+ постови, користејќи целосната листа во 01-CONTENT-AUDIT.md)
```

📌 **Алтернатива која штеди работа:** ако новата blog шема е дизајнирана да остане на root-level
(`/{slug}` директно, без `/blog/` prefix, исто како сега), тогаш речиси **нула redirects** се
потребни за постовите — само за главните страници (about, services, contact, career,
financeblog index). Ова е силна причина да се размисли дали навистина вреди да се воведе
`/blog/` prefix наспроти задржување на постоечката root-level shema за индивидуални постови. Оваа
одлука треба свесно да се донесе во `07-SITE-STRUCTURE.md`.

### 5.3 По лансирање

- [ ] Поднеси нов sitemap во Google Search Console веднаш по DNS cutover.
- [ ] Следи "Coverage" и "Page Indexing" извештаи во GSC секојдневно првите 2 недели за detect
      на crawl errors или неочекувани де-индексирања.
- [ ] Следи 404 логови (видете `04-LOGGING-MONITORING.md` §2.2) за пропуштени redirects кои не
      се предвидени во планот.
- [ ] НЕ менувај ја content/URL структурата повторно веднаш по миграцијата — дозволи Google да
      се "смири" (обично 2-4 недели) пред дополнителни структурни промени.

## 6. Чеклиста пред лансирање (SEO)

- [ ] Секоја страница има уникатен `<title>` и meta description
- [ ] `og:locale` поправено на `mk_MK`
- [ ] `html lang="mk"` присутен глобално
- [ ] JSON-LD `Organization`/`LocalBusiness` schema на секоја страница
- [ ] `FAQPage` schema на FAQ страница
- [ ] `Article` schema на секој blog пост
- [ ] `sitemap.xml` генериран и валиден
- [ ] `robots.txt` правилен
- [ ] Целосна redirect мапа имплементирана и тестирана (рачно провери секоја стара URL)
- [ ] Core Web Vitals минимум "needs improvement", идеално "good" (тестирано на PageSpeed
      Insights пред лансирање)
- [ ] Google Search Console verified за новиот домен/property
- [ ] Google Business Profile ажуриран
- [ ] Сите слики имаат alt текст и се WebP оптимизирани
