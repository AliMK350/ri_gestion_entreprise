@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Historique — {{ $getRecord->name }}</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="card"><div class="card-header"><h3>Devis ({{ $getRecord->quotes->count() }})</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>ID</th><th>Montant</th><th>Statut</th></tr></thead><tbody>@forelse($getRecord->quotes as $q)<tr><td>#{{ $q->id }}</td><td>{{ number_format($q->total_amount,2) }} MAD</td><td>{{ $q->status }}</td></tr>@empty<tr><td colspan="3">Aucun devis.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Factures ({{ $getRecord->invoices->count() }})</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Réf.</th><th>Montant</th><th>Statut</th></tr></thead><tbody>@forelse($getRecord->invoices as $f)<tr><td>{{ $f->reference }}</td><td>{{ number_format($f->amount,2) }} MAD</td><td>{{ $f->status }}</td></tr>@empty<tr><td colspan="3">Aucune facture.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Reçus ({{ $getRecord->receipts->count() }})</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>ID</th><th>Montant</th><th>Date</th></tr></thead><tbody>@forelse($getRecord->receipts as $r)<tr><td>#{{ $r->id }}</td><td>{{ number_format($r->amount,2) }} MAD</td><td>{{ $r->paid_at->format('d/m/Y') }}</td></tr>@empty<tr><td colspan="3">Aucun reçu.</td></tr>@endforelse</tbody></table></div></div>
        <a href="{{ url('gerant/clients/list') }}" class="btn btn-default">Retour</a>
    </div></section>
</div>
@endsection
