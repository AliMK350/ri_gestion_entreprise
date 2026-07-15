@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('secretaire/clients/add') }}" class="btn btn-success">Créer un client</a>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('secretaire/clients/add') }}" class="btn btn-success">Créer un devis</a>
            </div>
        </div>
    </section>
    <section class="content-header"><div class="container-fluid"><h1>Nouvelle Facture</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Client *</label><select name="client_id" class="form-control" required>@foreach($clients as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Devis lié</label><select name="quote_id" class="form-control"><option value="">— Aucun —</option>@foreach($quotes as $q)<option value="{{ $q->id }}">#{{ $q->id }} — {{ $q->client->name ?? '' }} ({{ number_format($q->total_amount,2) }} MAD)</option>@endforeach</select></div>
        <div class="form-group"><label>Référence *</label><input type="text" name="reference" class="form-control" required placeholder="FAC-2026-001"></div>
        <div class="form-group"><label>Montant *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
        <div class="form-group"><label>Date émission *</label><input type="date" name="issued_at" class="form-control" required></div>
        <div class="form-group"><label>Date échéance</label><input type="date" name="due_at" class="form-control"></div>
        <div class="form-group"><label>Statut *</label><select name="status" class="form-control"><option value="draft">Brouillon</option><option value="sent">Envoyée</option><option value="validated">Validée</option><option value="cancelled">Annulée</option></select></div>
        <div class="form-group"><label>Détails</label><textarea name="details" class="form-control" rows="3"></textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('secretaire/factures/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
