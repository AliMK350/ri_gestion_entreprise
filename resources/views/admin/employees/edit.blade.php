@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Modifier l'Employé</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary">
        <form method="post">@csrf
            <div class="card-body">
                <div class="form-group"><label>Nom *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $getRecord->name) }}"></div>
                <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email', $getRecord->email) }}"></div>
                <div class="form-group"><label>Téléphone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $getRecord->phone) }}"></div>
                <div class="form-group"><label>Poste</label><input type="text" name="position" class="form-control" value="{{ old('position', $getRecord->position) }}"></div>
                <div class="form-group"><label>Département</label><input type="text" name="department" class="form-control" value="{{ old('department', $getRecord->department) }}"></div>
                <div class="form-group"><label>Date d'embauche</label><input type="date" name="hired_at" class="form-control" value="{{ old('hired_at', optional($getRecord->hired_at)->format('Y-m-d')) }}"></div>
                <div class="form-group"><label>Statut *</label><select name="status" class="form-control"><option value="0" {{ $getRecord->status == 0 ? 'selected' : '' }}>Actif</option><option value="1" {{ $getRecord->status == 1 ? 'selected' : '' }}>Inactif</option></select></div>
                <div class="form-group"><label>Compte utilisateur lié</label><select name="user_id" class="form-control"><option value="">— Aucun —</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ $getRecord->user_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>@endforeach</select></div>
            </div>
            <div class="card-footer"><button class="btn btn-primary">Mettre à jour</button> <a href="{{ url('admin/employees/list') }}" class="btn btn-default">Annuler</a></div>
        </form>
    </div></div></section>
</div>
@endsection
