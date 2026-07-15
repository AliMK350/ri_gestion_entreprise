@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Nouveau Devis</h1>
                <a href="{{ url('secretaire/clients/add') }}" class="btn btn-success">Créer un client</a>
            </div>
        </div>
    </section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Client *</label><select name="client_id" class="form-control" required>@foreach($clients as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Montant total *</label><input type="number" step="0.01" name="total_amount" class="form-control" required></div>
        <div class="form-group"><label>Statut *</label><select name="status" class="form-control"><option value="draft">Brouillon</option><option value="sent">Envoyé</option><option value="accepted">Accepté</option><option value="rejected">Refusé</option></select></div>
        <div class="form-group"><label>Détails</label><textarea name="details" class="form-control" rows="4"></textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('secretaire/devis/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
