<!DOCTYPE html><html><head><meta charset="utf-8"><title>Reçu #{{ $receipt->id }}</title><style>body{font-family:sans-serif;padding:40px}h1{color:#333}</style></head><body>
<h1>REÇU DE PAIEMENT #{{ $receipt->id }}</h1>
<p><strong>Client:</strong> {{ $receipt->client->name ?? '' }}<br>
<strong>Facture:</strong> {{ $receipt->invoice->reference ?? '' }}<br>
<strong>Montant:</strong> {{ number_format($receipt->amount, 2) }} MAD<br>
<strong>Date:</strong> {{ $receipt->paid_at->format('d/m/Y') }}<br>
<strong>Mode:</strong> {{ $receipt->payment_method ?? '-' }}</p>
</body></html>
