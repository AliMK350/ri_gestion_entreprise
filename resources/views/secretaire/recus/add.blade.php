@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Nouveau Reçu</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Client *</label><select name="client_id" class="form-control" required>@foreach($clients as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Facture *</label><select name="invoice_id" class="form-control" required>@foreach($invoices as $f)<option value="{{ $f->id }}">{{ $f->reference }} — {{ $f->client->name ?? '' }} ({{ number_format($f->amount,2) }} MAD)</option>@endforeach</select></div>
        <div class="form-group"><label>Montant *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
        <div class="form-group"><label>Date de paiement *</label><input type="date" name="paid_at" class="form-control" required></div>
        <div class="form-group"><label>Mode de paiement</label><input type="text" name="payment_method" class="form-control" placeholder="Virement, chèque, espèces..."></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('secretaire/recus/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
