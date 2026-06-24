@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Modifier le Devis #{{ $getRecord->id }}</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Client *</label><select name="client_id" class="form-control" required>@foreach($clients as $c)<option value="{{ $c->id }}" {{ $getRecord->client_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Montant total *</label><input type="number" step="0.01" name="total_amount" class="form-control" required value="{{ $getRecord->total_amount }}"></div>
        <div class="form-group"><label>Statut *</label><select name="status" class="form-control">@foreach(['draft','sent','accepted','rejected'] as $s)<option value="{{ $s }}" {{ $getRecord->status == $s ? 'selected' : '' }}>{{ $s }}</option>@endforeach</select></div>
        <div class="form-group"><label>Détails</label><textarea name="details" class="form-control" rows="4">{{ $getRecord->details }}</textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Mettre à jour</button> <a href="{{ url('secretaire/devis/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
