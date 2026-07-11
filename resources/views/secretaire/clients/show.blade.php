@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Historique — {{ $getRecord->name }}</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="card"><div class="card-body"><p><strong>Email:</strong> {{ $getRecord->email }} | <strong>Entreprise:</strong> {{ $getRecord->company_name }}</p></div></div>
        <div class="card"><div class="card-header"><h3>Devis</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>ID</th><th>Montant</th><th>Statut</th><th>Date</th></tr></thead><tbody>@forelse($getRecord->quotes as $q)<tr><td>#{{ $q->id }}</td><td>{{ number_format($q->total_amount, 2) }} MAD</td><td>{{ $q->status }}</td><td>{{ $q->created_at->format('d/m/Y') }}</td></tr>@empty<tr><td colspan="4">Aucun devis.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Factures</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Réf.</th><th>Montant</th><th>Statut</th><th>Date</th></tr></thead><tbody>@forelse($getRecord->invoices as $f)<tr><td>{{ $f->reference }}</td><td>{{ number_format($f->amount, 2) }} €</td><td>{{ $f->status }}</td><td>{{ $f->issued_at->format('d/m/Y') }}</td></tr>@empty<tr><td colspan="4">Aucune facture.</td></tr>@endforelse</tbody></table></div></div>
        <a href="{{ url('secretaire/clients/list') }}" class="btn btn-default">Retour</a>
    </div></section>
</div>
@endsection
