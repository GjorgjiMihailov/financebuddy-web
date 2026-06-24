<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Техничка грешка | FinanceBuddy.mk</title>
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

        .icon-wrap {
            margin-bottom: 1.75rem;
        }
        .icon-circle {
            width: 5rem;
            height: 5rem;
            border-radius: 9999px;
            background-color: #F2ECE1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            cursor: pointer;
            font-family: inherit;
        }
        .btn-ghost:hover { border-color: #FF6600; color: #FF6600; }
        .btn-ghost:focus-visible {
            outline: 2px solid #FF6600;
            outline-offset: 3px;
        }

        .status-note {
            margin-top: 2.5rem;
            padding: 1rem 1.5rem;
            background-color: #F2ECE1;
            border-radius: 0.75rem;
            max-width: 32rem;
        }
        .status-note p {
            font-size: 0.8rem;
            color: #6B6358;
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

        <div class="icon-wrap" aria-hidden="true">
            <div class="icon-circle">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FF6600" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
        </div>

        <h1>Техничка грешка</h1>

        <p class="lead">
            Настана неочекуван проблем на нашиот сервер.<br>
            Нашиот тим е известен и работиме на решение.
        </p>

        <div class="actions">
            <a href="/" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Назад на почетна
            </a>
            <button type="button" class="btn-ghost" onclick="window.location.reload()">
                Обиди се повторно
            </button>
        </div>

        <div class="status-note">
            <p>
                Ако проблемот продолжува, контактирајте нè на
                <a href="mailto:contact@financebuddy.mk" style="color:#FF6600;text-decoration:none;">contact@financebuddy.mk</a>
            </p>
        </div>

    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} FinanceBuddy.mk — ФАЈНЕНС БАДИ ДООЕЛ Скопје</p>
    </footer>
</body>
</html>
