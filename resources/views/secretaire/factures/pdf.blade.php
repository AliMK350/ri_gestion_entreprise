<!DOCTYPE html><html><head><meta charset="utf-8"><title>Facture {{ $invoice->reference }}</title><style>body{font-family:sans-serif;padding:40px}h1{color:#333}table{width:100%;border-collapse:collapse;margin-top:20px}td,th{border:1px solid #ddd;padding:8px}</style></head><body>
<h1>FACTURE {{ $invoice->reference }}</h1>
<p><strong>Client:</strong> {{ $invoice->client->name ?? '' }}<br><strong>Date:</strong> {{ $invoice->issued_at->format('d/m/Y') }}<br><strong>Échéance:</strong> {{ optional($invoice->due_at)->format('d/m/Y') ?? '-' }}</p>
<table><tr><th>Description</th><th>Montant</th></tr><tr><td>{{ $invoice->details ?? 'Prestations' }}</td><td>{{ number_format($invoice->amount, 2) }} €</td></tr></table>
<p style="margin-top:30px"><strong>Total TTC:</strong> {{ number_format($invoice->amount, 2) }} €</p>
</body></html>
