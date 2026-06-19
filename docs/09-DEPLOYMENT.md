# 09 — Deployment и инфраструктура (DigitalOcean)

## 1. Контекст — постоечка инфраструктура

FinanceBuddy **порталот** веќе работи на DigitalOcean дроплет. ✅ Потврден stack:

| Компонента | Верзија / Вредност |
|---|---|
| OS | Ubuntu (hostname: `financebuddy-nov-obid`) |
| Web server | **Apache 2.4.52** (Nginx НЕ е инсталиран) |
| PHP | **8.3.31** |
| База | **MySQL** |
| Диск | 25 GB вкупно / 13 GB зафатено / **12 GB слободно (49%)** |

Новата јавна страница се поставува на **истиот дроплет** како посебна апликација,
не вмешана во порталската codebase.

## 2. Web server избор — Nginx наспроти Apache

Порталот користи Apache2. За новата апликација, опции:

**Опција А — Nginx (препорачано ако е возможно):** подобри перформанси за статична содржина и
SSR/Node coexistence (ако SSR е избран според `02-TECH-STACK.md` §4), почист config за
multi-app vhost поставки. Бара Nginx да се инсталира на дроплетот **покрај** Apache (двата можат
коегзистираат на различни портови/домени со внимателна конфигурација, но додава комплексност).

**Опција Б — Apache2 (конзистентно со портал):** поедноставно — еден web server software на целиот
дроплет, познат конфигурациски патерн веќе воспоставен. PHP-FPM + `mod_proxy_fcgi` дава
споредливи перформанси на Apache за овој обем на traffic.

**Препорака:** **Опција Б (Apache2)**, освен ако перформанс тестирање покаже значителна разлика.
Конзистентност на серверска конфигурација (еден web server, едни конвенции за vhost фајлови,
едно место за SSL renewal логика) ја намалува операциската сложеност за соло-одржуван систем
повеќе отколку малата теоретска перформанс придобивка од Nginx би вредела овде.

## 3. Domain / DNS поставка

```
financebuddy.mk              → нова јавна страница (овој проект)
www.financebuddy.mk           → redirect кон financebuddy.mk (non-www канонички избор)
portal.financebuddy.mk         → постоечки клиентски портал (непроменето)
```

DNS A records кон истата дроплет IP адреса за `financebuddy.mk` (root domain) и `www`
subdomain (CNAME или A record). `portal.` субдомен останува непроменет.

## 4. Apache vhost конфигурација (концепт)

```apache
<VirtualHost *:80>
    ServerName financebuddy.mk
    ServerAlias www.financebuddy.mk
    DocumentRoot /var/www/financebuddy-web/public

    <Directory /var/www/financebuddy-web/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/financebuddy-web-error.log
    CustomLog ${APACHE_LOG_DIR}/financebuddy-web-access.log combined
</VirtualHost>
```

Потоа Certbot (`certbot --apache -d financebuddy.mk -d www.financebuddy.mk`) автоматски генерира
HTTPS верзија (port 443 vhost) и поставува auto-renewal cron/systemd timer.

**Изолација од порталот:** секоја апликација живее во сопствена папка
(`/var/www/financebuddy-web/` наспроти `/var/www/financebuddy-portal/` или каде и да е порталот),
со сопствен `.env`, сопствена база, сопствен deploy циклус. Овој proект НИКОГАШ не пристапува
директно до порталската база или фајлови — целосна изолација е намерна заради безбедност (ако
едниот проект е компромитиран, другиот останува заштитен) и заради независно deploy/rollback.

## 5. База на податоци

- Нова, изолирана MySQL база (на пр. `financebuddy_web`), сопствен DB корисник со пристап **само**
  до таа база (не reuse-увај ги порталските DB credentials).
- Лозинката во `.env`, никогаш во код, никогаш во git (видете `03-CODING-STANDARDS.md` §6).

```bash
mysql -u root -p
CREATE DATABASE financebuddy_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'fbweb_user'@'localhost' IDENTIFIED BY '***силна-лозинка***';
GRANT ALL PRIVILEGES ON financebuddy_web.* TO 'fbweb_user'@'localhost';
FLUSH PRIVILEGES;
```

## 6. Deploy процес

### 6.1 MVP пристап — рачен/скриптиран deploy (доволно за мал тим)

Целосен CI/CD pipeline (GitHub Actions со automated tests + auto-deploy) е вреден инвестмент, но
не е строго неопходен за MVP лансирање. Минимален, безбеден рачен пристап:

```bash
# deploy.sh — скрипта на серверот, се повикува по секој git push
cd /var/www/financebuddy-web
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload apache2   # или php-fpm restart, зависно од setup
```

### 6.2 Препорачана надградба (Фаза подоцна, не блокира лансирање)

GitHub Actions workflow кој на секој push кон `main`:
1. Извршува тестови (`php artisan test`)
2. Само ако тестовите поминат, се SSH-конектира до дроплетот и го извршува `deploy.sh`

Ова спречува "счупен код стигна во продукција" сценарио, но бара дополнително GitHub Actions
setup + SSH deploy keys конфигурација — добра идна инвестиција, не критична за лансирање.

## 7. Environment променливи (`.env`) — клучни поставки

```env
APP_NAME="FinanceBuddy.mk"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://financebuddy.mk

DB_CONNECTION=mysql
DB_DATABASE=financebuddy_web
DB_USERNAME=fbweb_user
DB_PASSWORD=***

MAIL_MAILER=smtp
MAIL_HOST=*** (видете §8 за провајдер избор)
MAIL_FROM_ADDRESS=contact@financebuddy.mk
MAIL_FROM_NAME="FinanceBuddy.mk"

ADMIN_NOTIFICATION_EMAIL=contact@financebuddy.mk

SENTRY_LARAVEL_DSN=*** (опционо, видете 04-LOGGING-MONITORING.md §3)
```

## 8. Email/SMTP провајдер избор

Препорака: **транзакциски email сервис** наместо сопствен SMTP преку дроплетот директно (сопствен
SMTP од нов IP/домен често завршува во spam папки заради недостаток на sender reputation).

| Опции | Бесплатен tier | Забелешка |
|---|---|---|
| **Brevo** (поранешен Sendinblue) | Да, 300 емаили/ден бесплатно | Добра опција за мал обем, лесен Laravel setup |
| **Resend** | Да, ограничен | Модерен, developer-friendly, добра documentation |
| **Mailgun** | Ограничен trial, потоа платено | Силен избор, малку посложен setup |

За волумен на contact form известувања (веројатно неколку дневно), кој било бесплатен tier е
повеќе од доволен.

## 9. SSL/HTTPS

Certbot (Let's Encrypt) — бесплатно, auto-renewal преку systemd timer (стандардно поставено при
Certbot инсталација). Потврди дека auto-renewal реално работи (`certbot renew --dry-run`) при
почетен setup, не само претпоставувај.

## 10. Storage за upload-увани слики (blog featured images)

За MVP: локален storage на дроплетот (`storage/app/public`, symlink-иран до `public/storage`).

**Кога да се премине на DigitalOcean Spaces (S3-compatible object storage):**
- Ако storage на дроплетот почне да станува тесно (диск простор споделен со порталот + OS)
- Ако сака CDN-ниво на испорака на слики (Spaces + CDN е лесна надградба)
- Не е итно за лансирање, but Laravel `filesystems.php` конфигурацијата треба да остане flexible
  (користи `Storage::disk('public')` апстракција насекаде во кодот, никогаш hardcoded патеки) за
  премин кон Spages подоцна да биде едноставна конфигурациска промена, не code rewrite.

## 11. Чеклиста пред лансирање (инфраструктура)

- [ ] Точен сервер stack потврден (не претпоставен) пред финален setup
- [ ] Изолирана база, изолирани credentials од порталот
- [ ] Apache/Nginx vhost конфигуриран и тестиран
- [ ] HTTPS активен, auto-renewal потврден со dry-run
- [ ] DNS records точни (root domain + www redirect)
- [ ] `.env` правилно поставен, `APP_DEBUG=false`, `APP_ENV=production`
- [ ] Deploy скрипта тестирана барем еднаш рачно пред да се потпира на неа за вистинско
      лансирање
- [ ] Email SMTP тестиран (реална порака стигнува до inbox)
- [ ] Backup cron активен (видете `04-LOGGING-MONITORING.md` §5)
- [ ] Storage permissions точни (`storage/` и `bootstrap/cache/` writable од web server корисник)
