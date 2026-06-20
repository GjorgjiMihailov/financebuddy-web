<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нова порака — FinanceBuddy.mk</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #F2ECE1; margin: 0; padding: 24px; color: #1C1A17; }
        .card { background: #FBF8F3; border-radius: 16px; max-width: 600px; margin: 0 auto; overflow: hidden; }
        .header { background: #FF6600; padding: 24px 32px; }
        .header h1 { color: white; font-size: 20px; margin: 0; font-weight: 600; }
        .header p { color: rgba(255,255,255,0.8); margin: 4px 0 0; font-size: 14px; }
        .body { padding: 32px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #6B6358; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1C1A17; line-height: 1.5; }
        .message-box { background: #F2ECE1; border-radius: 10px; padding: 16px; font-size: 15px; line-height: 1.6; color: #1C1A17; white-space: pre-wrap; }
        .divider { border: none; border-top: 1px solid #E5DDD0; margin: 20px 0; }
        .footer { padding: 16px 32px; background: #F2ECE1; font-size: 12px; color: #6B6358; text-align: center; }
        a { color: #FF6600; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Нова порака од financebuddy.mk</h1>
            <p>{{ $contactMessage->created_at->format('d.m.Y H:i') }}</p>
        </div>
        <div class="body">
            <div class="field">
                <div class="label">Ime и презиме</div>
                <div class="value">{{ $contactMessage->name }}</div>
            </div>
            <div class="field">
                <div class="label">Email</div>
                <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
            </div>
            @if($contactMessage->phone)
            <div class="field">
                <div class="label">Телефон</div>
                <div class="value"><a href="tel:{{ $contactMessage->phone }}">{{ $contactMessage->phone }}</a></div>
            </div>
            @endif
            @if($contactMessage->service_interest)
            <div class="field">
                <div class="label">Интересирање за</div>
                <div class="value">{{ $contactMessage->service_interest }}</div>
            </div>
            @endif
            <hr class="divider">
            <div class="field">
                <div class="label">Порака</div>
                <div class="message-box">{{ $contactMessage->message }}</div>
            </div>
            <hr class="divider">
            <div style="text-align:center; margin-top: 8px;">
                <a href="mailto:{{ $contactMessage->email }}?subject=Re: Порака од financebuddy.mk"
                   style="display:inline-block; background:#FF6600; color:white; padding:10px 24px; border-radius:50px; font-weight:600; font-size:14px;">
                    Одговори на пораката
                </a>
            </div>
        </div>
        <div class="footer">
            FinanceBuddy.mk · contact@financebuddy.mk · +389 77 881 701
        </div>
    </div>
</body>
</html>
