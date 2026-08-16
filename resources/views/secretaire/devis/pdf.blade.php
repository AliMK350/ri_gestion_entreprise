<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Devis {{ $quote->reference }}</title>
    <style>
        @page {
            margin: 30px 35px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #2b2b2b;
            font-size: 11pt;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .logo {
            max-height: 55px;
            width: auto;
        }
        .document-title {
            font-size: 22pt;
            font-weight: bold;
            color: #00ADEF;
            text-transform: uppercase;
            text-align: right;
            margin: 0;
        }
        .ref-box {
            text-align: right;
            font-size: 10pt;
            color: #555;
            margin-top: 5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .info-card {
            width: 48%;
            vertical-align: top;
            background: #f9fbfd;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            padding: 12px 15px;
        }
        .card-title {
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            color: #00ADEF;
            border-bottom: 1px solid #00ADEF;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background: #00ADEF;
            color: #ffffff;
            font-weight: bold;
            font-size: 9.5pt;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #00ADEF;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e1e8ed;
            font-size: 9.5pt;
            vertical-align: top;
        }
        .items-table tr:nth-child(even) td {
            background-color: #fcfdfe;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .summary-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-table td {
            padding: 6px 10px;
            font-size: 10pt;
        }
        .summary-table .total-row td {
            font-weight: bold;
            font-size: 12pt;
            color: #00ADEF;
            border-top: 2px solid #00ADEF;
            background: #f4fafc;
        }
        .footer-box {
            margin-top: 30px;
            background: #f8fafc;
            border-left: 4px solid #00ADEF;
            padding: 12px 15px;
            font-size: 9pt;
        }
        .footer-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        .stamp-box {
            margin-top: 35px;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- En-tête avec Logo et Titre -->
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                @php
                $logoPath = public_path('dist/img/ri-logo.png');
            @endphp

            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" class="logo" alt="Logo">
            @endif
                <h2 style="margin: 0; color: #111; font-size: 16pt;">RI COMMUNICATION</h2>
                <div style="font-size: 9pt; color: #666; margin-top: 4px;">
                    Agence de Communication & Solutions Digitales<br>
                    Tél : +212 5 00 00 00 00 | Email : contact@ricommunication.ma
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <div class="document-title">DEVIS</div>
                <div class="ref-box">
                    <strong>N° Devis :</strong> {{ $quote->reference }}<br>
                    <strong>Date :</strong> {{ $quote->quote_date ? date('d/m/Y', strtotime($quote->quote_date)) : $quote->created_at->format('d/m/Y') }}<br>
                    @if($quote->validity_date)
                        <strong>Validité :</strong> {{ $quote->validity_date }}<br>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Cartes Émetteur et Client -->
    <table class="info-table">
        <tr>
            <td class="info-card">
                <div class="card-title">Émis par (Vendeur)</div>
                <strong>{{ $quote->seller->name ?? 'RI Communication' }}</strong><br>
                Email : {{ $quote->seller->email ?? 'contact@ricommunication.ma' }}<br>
                Statut du devis : 
                @if($quote->status == 'accepted')
                    <span style="color: #27ae60; font-weight: bold;">Accepté</span>
                @elseif($quote->status == 'sent')
                    <span style="color: #2980b9; font-weight: bold;">Envoyé</span>
                @elseif($quote->status == 'rejected')
                    <span style="color: #c0392b; font-weight: bold;">Refusé</span>
                @else
                    <span style="color: #7f8c8d; font-weight: bold;">Brouillon</span>
                @endif
            </td>
            <td style="width: 4%;"></td>
            <td class="info-card">
                <div class="card-title">Destiné à (Client)</div>
                <strong>{{ $quote->client->name ?? 'Client' }}</strong><br>
                @if(!empty($quote->client->company_name))
                    Société : {{ $quote->client->company_name }}<br>
                @endif
                @if(!empty($quote->client->email))
                    Email : {{ $quote->client->email }}<br>
                @endif
                @if(!empty($quote->client->phone))
                    Tél : {{ $quote->client->phone }}<br>
                @endif
                @if(!empty($quote->client->address))
                    Adresse : {{ $quote->client->address }}
                @endif
            </td>
        </tr>
    </table>

    <!-- Tableau des Lignes du Devis -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 35%;">Désignation & Description</th>
                <th class="text-center" style="width: 10%;">Qté</th>
                <th class="text-center" style="width: 10%;">Unité</th>
                <th class="text-right" style="width: 15%;">P.U. HT</th>
                <th class="text-center" style="width: 10%;">TVA</th>
                <th class="text-right" style="width: 20%;">Total HT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quote->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->designation }}</strong>
                        @if(!empty($item->description))
                            <div style="font-size: 8.5pt; color: #666; margin-top: 2px;">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->quantity, 2, ',', ' ') }}</td>
                    <td class="text-center">{{ $item->unit ?? 'Unité' }}</td>
                    <td class="text-right">{{ number_format($item->unit_price_ht, 2, ',', ' ') }} DH</td>
                    <td class="text-center">{{ number_format($item->tva_rate, 0) }}%</td>
                    <td class="text-right">{{ number_format($item->total_ht, 2, ',', ' ') }} DH</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #999;">Aucune prestation définie dans ce devis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tableau Récapitulatif des Totaux -->
    <table class="summary-table">
        <tr>
            <td class="text-right"><strong>Montant Total HT :</strong></td>
            <td class="text-right">{{ number_format($quote->total_ht ?? $quote->total_amount, 2, ',', ' ') }} DH</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Montant Total TVA :</strong></td>
            <td class="text-right">{{ number_format($quote->total_tva ?? 0, 2, ',', ' ') }} DH</td>
        </tr>
        <tr class="total-row">
            <td class="text-right">TOTAL TTC :</td>
            <td class="text-right">{{ number_format($quote->total_ttc ?? $quote->total_amount, 2, ',', ' ') }} DH</td>
        </tr>
    </table>

    <!-- Conditions de Paiement et Notes -->
    @if(!empty($quote->payment_conditions) || !empty($quote->notes))
        <div class="footer-box">
            @if(!empty($quote->payment_conditions))
                <div class="footer-title">Conditions de paiement :</div>
                <div>{{ $quote->payment_conditions }}</div>
            @endif
            
            @if(!empty($quote->notes))
                <div class="footer-title" style="margin-top: 8px;">Observations :</div>
                <div>{{ $quote->notes }}</div>
            @endif
        </div>
    @endif

    <!-- Bloc Signature & Bon pour accord -->
    <table class="stamp-box">
        <tr>
            <td style="width: 50%; font-size: 9pt; color: #555;">
                Pour la société <strong>RI COMMUNICATION</strong><br><br><br><br>
                Cachet et Signature
            </td>
            <td style="width: 50%; font-size: 9pt; color: #555; text-align: right;">
                <strong>Bon pour accord et confirmation du client</strong><br>
                Date, Cachet et Signature :<br><br><br><br>
            </td>
        </tr>
    </table>

</body>
</html>
