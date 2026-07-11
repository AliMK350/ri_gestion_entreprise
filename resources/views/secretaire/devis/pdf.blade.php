<!DOCTYPE html><html><head><meta charset="utf-8"><title>Devis #{{ $quote->id }}</title><style>body{font-family:sans-serif;padding:40px}h1{color:#333}table{width:100%;border-collapse:collapse;margin-top:20px}td,th{border:1px solid #ddd;padding:8px}</style></head><body>
<h1>DEVIS #{{ $quote->id }}</h1>
<p><strong>Client:</strong> {{ $quote->client->name ?? '' }}<br><strong>Date:</strong> {{ $quote->created_at->format('d/m/Y') }}<br><strong>Statut:</strong> {{ $quote->status }}</p>
<table><tr><th>Description</th><th>Montant</th></tr><tr><td>{{ $quote->details ?? 'Prestations' }}</td><td>{{ number_format($quote->total_amount, 2) }} MAD</td></tr></table>
<p style="margin-top:30px"><strong>Total TTC:</strong> {{ number_format($quote->total_amount, 2) }} MAD</p>
</body></html>
