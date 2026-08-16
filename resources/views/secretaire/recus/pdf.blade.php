<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu #{{ $receipt->id }}</title>

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
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .logo {
            max-height: 55px;
            width: auto;
            margin-bottom: 6px;
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
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-card {
            width: 48%;
            vertical-align: top;
            background: #f9fbfd;
            border: 1px solid #e1e8ed;
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

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .details-table th {
            background: #00ADEF;
            color: #fff;
            text-transform: uppercase;
            font-size: 9.5pt;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #00ADEF;
        }

        .details-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e1e8ed;
            font-size: 9.5pt;
        }

        .details-table tr:nth-child(even) td {
            background: #fcfdfe;
        }

        .text-right {
            text-align: right;
        }

        .summary-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .summary-table td {
            padding: 7px 10px;
            font-size: 10pt;
        }

        .summary-table .total-row td {
            border-top: 2px solid #00ADEF;
            background: #f4fafc;
            color: #00ADEF;
            font-weight: bold;
            font-size: 12pt;
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

        .signature-table {
            width: 100%;
            margin-top: 35px;
        }
    </style>
</head>

<body>

<!-- En-tête -->
<table class="header-table">
    <tr>

        <td style="width:50%;">

            @php
                $logoPath = public_path('dist/img/ri-logo.png');
            @endphp

            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" class="logo" alt="Logo">
            @endif

            <h2 style="margin:0;color:#111;font-size:16pt;">
                RI COMMUNICATION
            </h2>

            <div style="font-size:9pt;color:#666;margin-top:4px;">
                Agence de Communication & Solutions Digitales<br>
                Tél : +212 5 00 00 00 00<br>
                Email : contact@ricommunication.ma
            </div>

        </td>

        <td style="width:50%;vertical-align:top;">

            <div class="document-title">
                REÇU
            </div>

            <div class="ref-box">
                <strong>N° Reçu :</strong> {{ $receipt->id }}<br>

                <strong>Date :</strong>
                {{ $receipt->paid_at->format('d/m/Y') }}
            </div>

        </td>

    </tr>
</table>

<!-- Informations -->
<table class="info-table">

    <tr>

        <td class="info-card">

            <div class="card-title">
                Émis par
            </div>

            <strong>RI COMMUNICATION</strong><br>

            Agence de Communication & Solutions Digitales<br>

            Email : contact@ricommunication.ma

        </td>

        <td style="width:4%;"></td>

        <td class="info-card">

            <div class="card-title">
                Client
            </div>

            <strong>{{ $receipt->client->name ?? 'Client' }}</strong><br>

            @if(!empty($receipt->client->company_name))
                Société : {{ $receipt->client->company_name }}<br>
            @endif

            @if(!empty($receipt->client->email))
                Email : {{ $receipt->client->email }}<br>
            @endif

            @if(!empty($receipt->client->phone))
                Téléphone : {{ $receipt->client->phone }}<br>
            @endif

            @if(!empty($receipt->client->address))
                Adresse : {{ $receipt->client->address }}
            @endif

        </td>

    </tr>

</table>

<!-- Détails du reçu -->
<table class="details-table">

    <thead>

        <tr>
            <th>Facture</th>
            <th>Mode de paiement</th>
            <th class="text-right">Montant</th>
        </tr>

    </thead>

    <tbody>

        <tr>

            <td>
                {{ $receipt->invoice->reference ?? '-' }}
            </td>

            <td>
                {{ $receipt->payment_method ?? '-' }}
            </td>

            <td class="text-right">
                {{ number_format($receipt->amount,2,',',' ') }} DH
            </td>

        </tr>

    </tbody>

</table>

<!-- Total -->
<table class="summary-table">

    <tr class="total-row">

        <td class="text-right">
            Montant payé
        </td>

        <td class="text-right">
            {{ number_format($receipt->amount,2,',',' ') }} DH
        </td>

    </tr>

</table>

<div class="footer-box">

    <div class="footer-title">
        Confirmation de paiement
    </div>

    Ce document atteste que le montant indiqué ci-dessus a été reçu par
    <strong>RI COMMUNICATION</strong> en règlement de la facture
    <strong>{{ $receipt->invoice->reference ?? '-' }}</strong>.

</div>

<!-- Signature -->
<table class="signature-table">

    <tr>

        <td style="width:50%;font-size:9pt;color:#555;">

            Pour la société <strong>RI COMMUNICATION</strong>

            <br><br><br><br>

            Cachet et Signature

        </td>

        <td style="width:50%;text-align:right;font-size:9pt;color:#555;">

            Signature du client

            <br><br><br><br>

        </td>

    </tr>

</table>

</body>
</html>