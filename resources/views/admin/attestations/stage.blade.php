<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attestation de stage - {{ $intern->name }}</title>
    <style>
        @page { margin: 90px 70px 70px 70px; }
        body {
            font-family: 'Helvetica', 'DejaVu Sans', sans-serif;
            color: #222;
            font-size: 13px;
            line-height: 1.7;
        }
        .header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            text-align: center;
            border-bottom: 3px solid #00ADEF;
            padding-bottom: 12px;
        }
        .header .company-name {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #222;
        }
        .header .company-name span { color: #00ADEF; }
        .header .tagline {
            font-size: 10px;
            color: #888;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        h1 {
            text-align: center;
            font-size: 20px;
            letter-spacing: 2px;
            color: #00ADEF;
            text-transform: uppercase;
            margin-top: 40px;
            margin-bottom: 45px;
        }
        .content { text-align: justify; }
        .content p { margin-bottom: 18px; }
        .highlight { font-weight: bold; }
        .signature {
            margin-top: 70px;
            text-align: right;
        }
        .signature .place-date { margin-bottom: 60px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">RI <span>COMMUNICATION</span></div>
        <div class="tagline">Développement &amp; Solutions IT</div>
    </div>

    <div class="footer">
        RI COMMUNICATION — Document généré automatiquement
    </div>

    <h1>Attestation de stage</h1>

    <div class="content">
        <p>
            Nous soussignés, la société <span class="highlight">RI COMMUNICATION</span>, certifions par la présente
            que <span class="highlight">{{ $intern->name }}</span>
            @if($intern->department)
                a effectué un stage au sein de notre société, dans le département <span class="highlight">{{ $intern->department }}</span>,
            @else
                a effectué un stage au sein de notre société,
            @endif
            @if($started_at_fr && $ended_at_fr)
                du <span class="highlight">{{ $started_at_fr }}</span> au <span class="highlight">{{ $ended_at_fr }}</span>.
            @elseif($started_at_fr)
                à partir du <span class="highlight">{{ $started_at_fr }}</span>.
            @else
                sur la période convenue avec notre société.
            @endif
        </p>

        <p>
            Durant cette période, {{ $intern->name }} a fait preuve de sérieux, de motivation et d'un bon esprit
            d'équipe dans l'accomplissement des missions qui lui ont été confiées.
        </p>

        <p>
            Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.
        </p>
    </div>

    <div class="signature">
        <div class="place-date">Fait à Rabat, le {{ $today_fr }}</div>
        <div>Le Directeur</div>
    </div>
</body>
</html>
