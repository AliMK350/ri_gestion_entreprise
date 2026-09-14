@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Ajouter une personne à la CVTech</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf
        <div class="card-body">
            <div class="form-group"><label>Type de profil *</label><select name="person_type" class="form-control" required><option value="manual" {{ old('person_type', 'manual') === 'manual' ? 'selected' : '' }}>Ajout manuel / ancien collaborateur</option><option value="employee" {{ old('person_type') === 'employee' ? 'selected' : '' }}>Employé</option><option value="intern" {{ old('person_type') === 'intern' ? 'selected' : '' }}>Stagiaire</option></select></div>
            <div class="form-row"><div class="form-group col-md-6"><label>Nom complet *</label><input name="name" class="form-control" required value="{{ old('name') }}">@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div><div class="form-group col-md-6"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div></div>
            <div class="form-row"><div class="form-group col-md-4"><label>Téléphone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div><div class="form-group col-md-4"><label>Ville</label><input name="city" class="form-control" value="{{ old('city') }}"></div><div class="form-group col-md-4"><label>Spécialité</label><input name="specialite" class="form-control" value="{{ old('specialite') }}"></div></div>
            <div class="form-row"><div class="form-group col-md-6"><label>Poste</label><input name="position" class="form-control" value="{{ old('position') }}"></div><div class="form-group col-md-6"><label>Niveau d'étude</label><input name="niveau_etude" class="form-control" value="{{ old('niveau_etude') }}"></div></div>
            <div class="form-row"><div class="form-group col-md-4"><label>Début de stage</label><input type="date" name="started_at" class="form-control" value="{{ old('started_at') }}"></div><div class="form-group col-md-4"><label>Fin de stage</label><input type="date" name="ended_at" class="form-control" value="{{ old('ended_at') }}"></div><div class="form-group col-md-4"><label>Date d'embauche</label><input type="date" name="hired_at" class="form-control" value="{{ old('hired_at') }}"></div></div>
            <div class="form-group"><label>Notes</label><textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea></div>
        </div><div class="card-footer"><button class="btn btn-primary"><i class="fas fa-save"></i> Ajouter à la CVTech</button> <a href="{{ url('admin/cvtech/list') }}" class="btn btn-default">Annuler</a></div>
    </form></div></div></section>
</div>
@endsection
