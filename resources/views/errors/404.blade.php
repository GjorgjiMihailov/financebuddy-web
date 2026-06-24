<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Страницата не е пронајдена | FinanceBuddy.mk</title>
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700;9..144,900&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #FBF8F3;
            color: #1C1A17;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
        }

        .page {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .brand-link {
            display: inline-block;
            text-decoration: none;
            margin-bottom: 3.5rem;
        }
        .brand-name {
            font-family: 'Fraunces', ui-serif, Georgia, serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1C1A17;
        }
        .brand-orange { color: #FF6600; }
        .brand-stone  { color: #6B6358; }

        .error-wrap {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .error-bg {
            font-family: 'Fraunces', ui-serif, Georgia, serif;
            font-size: clamp(7rem, 22vw, 14rem);
            font-weight: 900;
            line-height: 1;
            color: #FF6600;
            opacity: 0.08;
            user-select: none;
            pointer-events: none;
        }
        .error-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-label span {
            display: inline-block;
            background: #FF6600;
            color: #fff;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
        }

        h1 {
            font-family: 'Fraunces', ui-serif, Georgia, serif;
            font-size: clamp(1.6rem, 4vw, 2.5rem);
            font-weight: 700;
            color: #1C1A17;
            margin-bottom: 1rem;
            line-height: 1.25;
        }

        .lead {
            color: #6B6358;
            font-size: 1rem;
            line-height: 1.75;
            max-width: 36rem;
            margin-bottom: 2rem;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #FF6600;
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: background-color 0.15s;
            border: none;
        }
        .btn-primary:hover { background-color: #D9540A; }
        .btn-primary:focus-visible {
            outline: 2px solid #FF6600;
            outline-offset: 3px;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: transparent;
            color: #1C1A17;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            border: 1.5px solid #E5DDD0;
            transition: border-color 0.15s, color 0.15s;
        }
        .btn-ghost:hover { border-color: #FF6600; color: #FF6600; }
        .btn-ghost:focus-visible {
            outline: 2px solid #FF6600;
            outline-offset: 3px;
        }

        .footer {
            padding: 1.5rem;
            text-align: center;
            border-top: 1px solid #E5DDD0;
        }
        .footer p {
            font-size: 0.8rem;
            color: #6B6358;
        }
        .footer a {
            color: #FF6600;
            text-decoration: none;
        }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <main class="page" role="main">

        <a href="/" class="brand-link" aria-label="FinanceBuddy.mk — Почетна страница">
            <span class="brand-name">
                Finance<span class="brand-orange">Buddy</span><span class="brand-stone">.mk</span>
            </span>
        </a>

        <div class="error-wrap" aria-hidden="true">
            <div class="error-bg">404</div>
            <div class="error-label">
                <span>Грешка 404</span>
            </div>
        </div>

        <h1>Страницата не е пронајдена</h1>

        <p class="lead">
            Страницата која ја барате не постои или е преместена на нова адреса.<br>
            Проверете го линкот или вратете се на почетната страница.
        </p>

        <div class="actions">
            <a href="/" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Назад на почетна
            </a>
            <a href="/kontakt" class="btn-ghost">
                Контактирај нè
            </a>
        </div>

    </main>

    <footer class="footer">
        <p>
            Проблемот продолжува?
            <a href="mailto:contact@financebuddy.mk">contact@financebuddy.mk</a>
        </p>
    </footer>
</body>
</html>
