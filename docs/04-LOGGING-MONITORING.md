# 04 — Логирање, мониторинг и безбедност

## 1. Цел

Маркетинг сајтот мора да биде "видлив" однадвор — Гјоргји треба да може да одговори на прашања
од типот: "Зошто формата не работеше вчера?", "Дали некој се обидува да го хакира сајтот?", "Колку
посетители имавме оваа недела?" без да копа рачно низ сервер фајлови.

## 2. Слоеви на логирање

### 2.1 Application logs (Laravel built-in)

Laravel веќе има `storage/logs/laravel.log` преку Monolog. Конфигурација во `config/logging.php`:

```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'slack'],   // slack е опционо, видете §4
    ],

    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'info'),
        'days' => 30,   // чувај 30 дена ротирани логови, потоа auto-delete
    ],
],
```

- **Daily rotation, не еден бесконечен фајл** — спречува огромни логови кои станува тешко да се
  прелистаат или зафаќаат непотребен диск простор.
- **30 дена retention** е разумен баланс за маркетинг сајт (доволно за debug на скорешен проблем,
  не безгранично растење).

### 2.2 Што секогаш се логира

| Настан | Ниво | Содржина |
|---|---|---|
| Contact form submission | `info` | (без лични податоци во log текст — само факт дека е примена порака + ID; самите податоци се во базата, не во log фајл) |
| Contact form validation failure | `notice` | IP адреса + кои полиња не поминале валидација (за detect на bot напади) |
| Admin login успешен | `info` | корисник + IP + timestamp |
| Admin login неуспешен | `warning` | IP + timestamp (повторливи неуспеси од иста IP = сигнал за brute-force обид) |
| Blog post published/unpublished | `info` | кој корисник, кој пост |
| 500 Server Error | `error` | целосен stack trace (built-in Laravel однесување) |
| 404 на rute кои "изгледаат" како stari WP URLs | `notice` | за откривање на пропуштени redirects по миграцијата |

**Никогаш не логирај:** лозинки (дури ни hashed), целосни email содржини на трети лица,
кредитни картички / финансиски детали (не се применливо овде, но важно правило за било кој иден
модул).

### 2.3 Web server logs (Nginx)

Стандардни access/error логови на Nginx веќе постојат на дроплетот:

```
/var/log/nginx/financebuddy-access.log
/var/log/nginx/financebuddy-error.log
```

- Конфигурирај **logrotate** (веројатно веќе стандардно на Ubuntu) со 14-дневна ротација за
  access логови (овие растат побрзо од Laravel логовите).
- Access логовите служат за груба анализа на traffic patterns, bot активност, и потврда дека
  redirects работат правилно по migration (провери за 404 spikes).

## 3. Грешки во продукција — мониторинг сервис

Препорака: интеграција со **бесплатен tier на error tracking сервис**, наместо потпирање само на
`laravel.log` фајл кој некој мора рачно да го отвора.

**Опции (избери една):**

| Сервис | Бесплатен tier | Забелешка |
|---|---|---|
| **Sentry** | Да (5,000 events/месец бесплатно) | Најпопуларен, одличен Laravel SDK (`sentry/sentry-laravel`), email/Slack alerts при нова грешка |
| **Bugsnag** | Да, ограничен | Алтернатива на Sentry, слична функционалност |
| Само email при grешка (built-in) | Да, без надворешен сервис | Најпрост — Laravel `report()` метод во `app/Exceptions/Handler.php` испраќа email при `error` ниво, без trеба од трета страна |

📌 **Препорака за почеток:** Sentry бесплатен tier е доволен за маркетинг сајт со умерен traffic
и дава многу подобар UI за пребарување/филтрирање грешки отколку рачно читање log фајлови. Ако
Гјоргји сака нула надворешни зависности на почеток, built-in email alert е соодветна минимална
алтернатива која може да се надогради подоцна.

## 4. Известувања (alerts) — што треба веднаш да стигне до Гјоргји

- **Нова contact form порака** → email известување веднаш (видете `02-TECH-STACK.md` §8)
- **Критична грешка (500 error) во продукција** → email или Slack/Telegram известување
  (Гјоргји веќе користи Telegram bot за FinanceBuddy портал — истиот патерн може да се
  искористи и тука за конзистентност: мал Telegram webhook кој праќа порака при критична грешка)
- **Неуспешни admin login обиди** (3+ за кратко време) → опционо известување, заради безбедност

## 5. Backup стратегија

| Што | Фреквенција | Каде |
|---|---|---|
| База на податоци (MySQL dump) | Дневно, автоматски (cron + `mysqldump`) | DigitalOcean Spaces или одделен storage, НЕ само на истиот дроплет |
| Uploaded слики (`storage/app/public`) | Дневно или неделно (помалку чести промени) | Исто, надворешен storage |
| Целосен код | Постојано преку Git (GitHub) | GitHub репозиториум — ова е веќе "backup" по дефиниција |

**Критично правило:** backup на база **никогаш не смее да живее само на истиот дроплет** —
ако дроплетот падне или биде компромитиран, локален backup е бескорисен. Минимум: cron job кој
праќа dump до DigitalOcean Spaces (евтино, S3-компатибилно) или дури прост `rclone`/`rsync` до
Google Drive.

```bash
# пример cron (дневно во 03:00)
0 3 * * * mysqldump -u financebuddy_user -p'***' financebuddy_web | gzip > /tmp/fb-backup-$(date +\%F).sql.gz && rclone copy /tmp/fb-backup-$(date +\%F).sql.gz remote:financebuddy-backups/
```

## 6. Безбедносен мониторинг (основно ниво, соодветно за мал сајт)

- **Fail2ban** на дроплетот (ако веќе не е инсталиран за порталот) — автоматски блокира IP
  адреси кои повторливо обидуваат login или прават abuse.
- **UFW firewall** — само портови 22 (SSH, идеално преку non-default port или key-only auth),
  80, 443 отворени.
- **HTTPS задолжително насекаде** — Let's Encrypt сертификат (Certbot), auto-renewal проверен.
- **Laravel `APP_DEBUG=false`** во продукција — секогаш, без исклучок (debug mode во продукција
  излага стек трагови и `.env` детали на јавноста — критичен ризик).
- **Header безбедност:** основни security headers преку Nginx или Laravel middleware
  (`X-Frame-Options`, `X-Content-Type-Options: nosniff`, `Content-Security-Policy` барем basic
  верзија).

## 7. Достапност (uptime) мониторинг

Препорака: бесплатен надворешен uptime checker (на пр. **UptimeRobot** бесплатен tier — провери
секои 5 минути дали сајтот одговара, испраќа email/SMS ако падне). Ова е надворешен сигнал
независен од самиот сервер — ако серверот е целосно недостапен, внатрешно логирање не помага,
треба надворешен набљудувач.

## 8. Чеклиста пред лансирање (безбедност + логирање)

- [ ] `APP_DEBUG=false`, `APP_ENV=production` во `.env`
- [ ] Error tracking сервис конфигуриран (Sentry или email fallback)
- [ ] Дневен database backup cron активен и тестиран (направи тест-restore барем еднаш!)
- [ ] HTTPS активен, auto-renewal на сертификат потврден
- [ ] Rate limiting на contact формата активен
- [ ] UptimeRobot или сличен uptime monitor поставен
- [ ] Log rotation конфигуриран (Laravel + Nginx)
- [ ] Fail2ban / firewall правила потврдени
