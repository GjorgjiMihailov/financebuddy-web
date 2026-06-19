# 03 — Правила на кодирање (CLAUDE.md)

> 💡 **Препорака:** копирај ја содржината од овој фајл (или направи симлинк) во root на проектот
> како `CLAUDE.md`. Claude Code автоматски го чита тој фајл на почеток на секоја сесија во тој
> проект, што значи правилата важат автоматски без рачно потсетување секој пат.

## 1. Општа филозофија

- **Конзистентност > креативност.** Ако веќе постои патерн воспоставен во кодот (на пр. како се
  именува контролер, како се валидира form request), нов код го следи истиот патерн, не
  изнаоѓа нов начин.
- **Целосни преработки на фајл, не парцијални закрпи**, кога фајлот е мал/среден (под ~200 линии)
  — ова е навика веќе воспоставена во FinanceBuddy порталот и треба да продолжи и тука. За
  поголеми фајлови, користи прецизни str_replace измени.
- **Секоја функција треба да прави едно нешто.** Контролер методи остануваат тенки — валидацијата
  оди во Form Request класи, бизнис логиката во Service класи или Model методи, не сѐ во
  контролерот.
- **Без premature optimization.** Овој сајт е маркетинг сајт, не high-traffic апликација. Чист,
  читлив код > микро-оптимизации.

## 2. PHP / Laravel конвенции

```php
// Контролери: тенки, само ја орекстрираат логиката
class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        Mail::to(config('mail.admin_address'))->send(new NewContactMessage($message));

        return back()->with('success', 'Вашата порака е успешно испратена!');
    }
}
```

- **Именување:** PascalCase за класи, camelCase за методи и променливи, snake_case за колони во
  база и за конфигурациски клучеви.
- **Form Requests за секоја валидација** — никогаш inline `$request->validate([...])` во
  контролер за нешто повеќе од тривијален случај.
- **Eloquent relationships** експлицитно дефинирани во моделите (`Post belongsTo Category`).
- **Migrations:** секоја промена на шема оди преку нова migration фајл, никогаш рачна измена на
  база директно во продукција.
- **Без N+1 queries** — користи `->with('category')` eager loading секаде каде се прикажуваат
  листи со релации.
- **Сите кориснички видливи стрингови во контролери/модели на македонски** (валидациски пораки,
  flash messages) — апликацијата е 100% македонска, нема потреба од `lang` фајлови со англиски
  fallback, освен ако подоцна се додава мултијазичност (видете `02-TECH-STACK.md` §9).

## 3. Vue 3 / Inertia конвенции

```vue
<script setup>
import { ref, computed } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineOptions({ layout: PublicLayout })

const props = defineProps({
  posts: Array,
})

const form = useForm({
  name: '',
  email: '',
  message: '',
})

function submit() {
  form.post(route('contact.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <Head title="Контакт — FinanceBuddy.mk" />
  <!-- ... -->
</template>
```

- **Секогаш `<script setup>` Composition API**, никогаш Options API.
- **`defineOptions({ layout: ... })`** наместо обвиткување на секоја страница рачно — конзистентно
  и помалку бојлерплејт.
- **Inertia `useForm`** за сите форми (contact форма, admin форми) — дава built-in loading states,
  error handling, и progress indicators бесплатно.
- **`route()` helper** (Ziggy package) за сите линкови — никогаш hardcoded URL патеки во Vue
  компоненти, за да рутите остануваат единствен извор на вистина во `routes/web.php`.
- **Компоненти под 150-200 линии.** Ако страница расте преку тоа, извлечи делови во
  `Components/` (на пр. `ServiceCard.vue`, `TestimonialCard.vue`, `BlogPostCard.vue`).
- **Props секогаш типизирани** (барем основни типови: String, Array, Object, Boolean), не
  generic.

## 4. Стилизирање (Tailwind)

- **Дизајн токени дефинирани централно** во `tailwind.config.js` (бои, фонтови, spacing scale) —
  видете `05-DESIGN-SYSTEM.md` за точните вредности. Никогаш hardcoded hex бои во компоненти
  (`bg-[#ff6600]` е забрането) — секогаш преку именувани токени (`bg-brand-orange` или сл.,
  дефинирани во config).
- **Mobile-first** — секоја компонента се гради прво за мобилен екран, потоа `md:`/`lg:` за
  поголеми.
- **Без custom CSS фајлови по компонента** — се користи исклучиво Tailwind utility classes плус
  еден централен `app.css` за глобални токени/animations кои не можат да се изразат preku utility
  classes (на пр. custom keyframes).
- **Пристапност (accessibility) не е опционо:** секое интерактивно копче/линк има видлив focus
  state, контраст на бои минимум WCAG AA (4.5:1 за текст), сите слики имаат `alt` атрибут со
  опишувачки текст (не "image1.jpg" туку "Тамара Мицевска Михаилова, CEO на FinanceBuddy.mk").

## 5. Именување рути (route names) — конвенција

```
home                    GET  /
about                   GET  /about
services.index          GET  /uslugi
services.show           GET  /uslugi/{service}
blog.index              GET  /blog
blog.show               GET  /blog/{post:slug}
faq                      GET  /faq
career                   GET  /kariera
contact.index            GET  /kontakt
contact.store             POST /kontakt

admin.dashboard           GET  /admin
admin.posts.index         GET  /admin/blog
admin.posts.create        GET  /admin/blog/novo
admin.posts.store          POST /admin/blog
admin.posts.edit          GET  /admin/blog/{post}/uredi
admin.posts.update         PUT  /admin/blog/{post}
admin.posts.destroy        DELETE /admin/blog/{post}
admin.messages.index       GET  /admin/poraki
admin.messages.show        GET  /admin/poraki/{message}
```

📌 **Забелешка за URL-ови:** јавните URL патеки се на **македонска латиница без дијакритички
знаци** (на пр. `/uslugi`, `/kontakt`, `/kariera`) бидејќи Google добро ги индексира и луѓето
природно ги пишуваат вака. Постојните blog URL-ови (slug-ови) се ЗАДРЖУВААТ точно какви што се
во moментов (видете `01-CONTENT-AUDIT.md` §9) — не се менуваат заради SEO continuity, дури и ако
не следат идентична конвенција со новите страници.

## 6. Git конвенции

```
main                — продукциска гранка, секогаш deployable
develop              — интеграциона гранка (опционо, ако работи тимски; за соло работа main е ОК)

Commit пораки на македонски или англиски (избери едно и биди конзистентен — препорака: англиски
за commit пораки бидејќи е универзален стандард, дури и ако содржината е македонска):

feat: add contact form with validation
fix: correct VAT calculation in service pricing display
refactor: extract ServiceCard component from Services page
docs: update CLAUDE.md with new route conventions
```

- **Мали, чести commits**, не еден огромен commit на крајот од сесија.
- **`.env` НИКОГАШ не оди во git** — провери `.gitignore` го содржи од самиот почеток.
- **`.env.example`** секогаш ажуриран со сите потребни клучеви (без вистински вредности).

## 7. Тестирање — минимален но не нулти стандард

За маркетинг сајт целосно покритие со тестови е претерано, но следново е минимум:

- **Feature тест за contact form submission** (валидни и невалидни податоци, провери дека
  пораката се зачувува во база).
- **Feature тест за admin auth** (неавторизиран корисник не може да пристапи до `/admin/*`).
- **Feature тест за blog post creation/publish flow** (draft не е видлив на јавна страница,
  published е).

```php
// tests/Feature/ContactFormTest.php
public function test_valid_contact_submission_is_stored(): void
{
    $response = $this->post('/kontakt', [
        'name' => 'Тест Корисник',
        'email' => 'test@example.com',
        'message' => 'Тестна порака',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('contact_messages', ['email' => 'test@example.com']);
}
```

## 8. Безбедносни правила (важи и за AI-генериран код)

- **Никогаш не пишувај raw SQL** со interpolated кориснички内put — секогаш Eloquent / Query
  Builder со параметризирани upiti.
- **Никогаш не рендерирај user-submitted HTML без sanitization.** Blog content од admin (доверлив
  извор — само Гјоргји/Тамара пишуваат) може да биде Markdown→HTML без проблем, но контакт пораки
  (недоверлив, јавен извор) никогаш не се рендерираат како HTML — секогаш escaped text.
- **CSRF заштита** е built-in во Laravel/Inertia — никогаш не disable-увај го `VerifyCsrfToken`
  middleware за било која рута.
- **Rate limiting на contact формата** (на пр. `throttle:5,1` — 5 обиди во минута по IP) за да се
  спречи spam/abuse без потреба од CAPTCHA.
- **File upload валидација** (за featured images на blog постови): строга проверка на MIME тип,
  максимална големина (на пр. 5MB), и **никогаш** не се чува upload-ираниот фајл со оригиналното
  име од корисникот — секогаш генерирано safe filename (UUID или slug + timestamp).

## 9. Перформанси — чеклиста при секоја нова страница

- [ ] Слики во modern формат (WebP/AVIF) со `loading="lazy"` за сѐ освен above-the-fold
- [ ] Eager loading на релации (нема N+1)
- [ ] Нема непотребни npm пакети додадени само за мала функционалност (провери дали Tailwind
      utility или мала custom функција го решава проблемот пред да додадеш нова зависност)
- [ ] Animations/transitions користат CSS transforms (GPU-accelerated), не layout-trigger-ing
      својства (avoid animating `width`/`height`/`top`/`left` директно)

## 10. Документирање промени

При секоја поголема архитектурна одлука донесена во текот на развој (на пр. "одлучивме SSR не е
изводлив, преминавме на prerendering"), **ажурирај го соодветниот документ во `/docs`**, не само
кодот. Документацијата треба да остане жив извор на вистина, не статичен снимок од денот кога е
напишана.
