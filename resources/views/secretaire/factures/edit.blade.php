@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Modifier la Facture {{ $getRecord->reference }}</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Client *</label><select name="client_id" class="form-control" required>@foreach($clients as $c)<option value="{{ $c->id }}" {{ $getRecord->client_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Devis lié</label><select name="quote_id" class="form-control"><option value="">— Aucun —</option>@foreach($quotes as $q)<option value="{{ $q->id }}" {{ $getRecord->quote_id == $q->id ? 'selected' : '' }}>#{{ $q->id }}</option>@endforeach</select></div>
        <div class="form-group"><label>Référence *</label><input type="text" name="reference" class="form-control" required value="{{ $getRecord->reference }}"></div>
        <div class="form-group"><label>Montant *</label><input type="number" step="0.01" name="amount" class="form-control" required value="{{ $getRecord->amount }}"></div>
        <div class="form-group"><label>Date émission *</label><input type="date" name="issued_at" class="form-control" required value="{{ $getRecord->issued_at->format('Y-m-d') }}"></div>
        <div class="form-group"><label>Date échéance</label><input type="date" name="due_at" class="form-control" value="{{ optional($getRecord->due_at)->format('Y-m-d') }}"></div>
        <div class="form-group"><label>Statut *</label><select name="status" class="form-control">@foreach(['draft','sent','validated','cancelled'] as $s)<option value="{{ $s }}" {{ $getRecord->status == $s ? 'selected' : '' }}>{{ $s }}</option>@endforeach</select></div>
        <div class="form-group"><label>Détails</label><textarea name="details" class="form-control" rows="3">{{ $getRecord->details }}</textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Mettre à jour</button> <a href="{{ url('secretaire/factures/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
