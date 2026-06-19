<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Наскоро — FinanceBuddy.mk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: #FBF8F3;
            color: #1C1A17;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .logo {
            font-family: 'Fraunces', ui-serif, Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-bottom: 3rem;
        }
        .logo span { color: #FF6600; }
        .logo small { color: #6B6358; font-weight: 400; }
        h1 {
            font-family: 'Fraunces', ui-serif, Georgia, serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1.25rem;
        }
        .accent { color: #FF6600; }
        p {
            font-size: 1.125rem;
            color: #6B6358;
            max-width: 36ch;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }
        a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #FF6600;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: background 150ms;
        }
        a:hover { background: #D9540A; }
        footer {
            margin-top: 4rem;
            font-size: 0.8rem;
            color: #6B6358;
        }
    </style>
</head>
<body>
    <div class="logo">Finance<span>Buddy</span><small>.mk</small></div>

    <h1>Нов сајт е<br><span class="accent">на пат.</span></h1>
    <p>Работиме на нешто подобро. Наскоро се враќаме — посвежи, побрзи и поубави.</p>

    <a href="mailto:financebuddy.mk@gmail.com">
        Контактирај нè
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </a>

    <footer>© {{ date('Y') }} FinanceBuddy.mk</footer>
</body>
</html>
