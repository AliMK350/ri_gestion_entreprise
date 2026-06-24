@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Ajouter un Client</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group"><label>Nom *</label><input type="text" name="name" class="form-control" required></div>
        <div class="form-group"><label>Entreprise</label><input type="text" name="company_name" class="form-control"></div>
        <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
        <div class="form-group"><label>Téléphone</label><input type="text" name="phone" class="form-control"></div>
        <div class="form-group"><label>Adresse</label><textarea name="address" class="form-control" rows="2"></textarea></div>
        <div class="form-group"><label>Statut *</label><select name="status" class="form-control"><option value="0">Actif</option><option value="1">Inactif</option></select></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('secretaire/clients/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
