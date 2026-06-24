<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FF6600">

    <title inertia>{{ config('app.name', 'FinanceBuddy.mk') }}</title>

    <!-- Preload логото — LCP елемент на повеќето страни -->
    <link rel="preload" href="/images/logofaktura.png" as="image">

    <!-- Google Fonts: Fraunces (display) + Inter (body) + JetBrains Mono (utility) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,700;0,9..144,900;1,9..144,400&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- JSON-LD: Organization / ProfessionalService schema (глобален за цел сајт) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "ProfessionalService",
        "name": "FinanceBuddy.mk",
        "legalName": "Друштво за трговија и услуги ФАЈНЕНС БАДИ ДООЕЛ Скопје",
        "url": "https://financebuddy.mk",
        "logo": "https://financebuddy.mk/images/logofaktura.png",
        "telephone": "+38977881701",
        "email": "contact@financebuddy.mk",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "ул. Венијамин Мачуковски бр. 34/1-50",
            "addressLocality": "Скопје",
            "addressRegion": "Аеродром",
            "postalCode": "1000",
            "addressCountry": "MK"
        },
        "areaServed": "MK",
        "sameAs": [
            "https://www.facebook.com/FinanceBuddy.mk/",
            "https://www.instagram.com/financebuddy.mk/",
            "https://x.com/Financebuddymk",
            "https://www.linkedin.com/company/financebuddy-mk"
        ]
    }
    </script>

    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-body bg-paper text-ink antialiased">
    @inertia
</body>
</html>
