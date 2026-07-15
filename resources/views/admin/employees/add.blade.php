@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Ajouter un Employé</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary">
        <form method="post" enctype="multipart/form-data">@csrf
            <div class="card-body">
                <div class="form-group"><label>Nom *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"><div class="text-danger">{{ $errors->first('email') }}</div></div>
                <div class="form-group"><label>Téléphone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                <div class="form-group"><label>Poste</label><input type="text" name="position" class="form-control" value="{{ old('position') }}"></div>
                <div class="form-group"><label>Département</label><input type="text" name="department" class="form-control" value="{{ old('department') }}"></div>
                <div class="form-group"><label>CV (PDF / Word)</label><input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"></div>
                <div class="form-group"><label>Date d'embauche</label><input type="date" name="hired_at" class="form-control" value="{{ old('hired_at') }}"></div>
                <div class="form-group"><label>Statut *</label><select name="status" class="form-control"><option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Actif</option><option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactif</option></select></div>
                <div class="form-group"><label>Compte utilisateur lié</label><select name="user_id" class="form-control"><option value="">— Aucun —</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>@endforeach</select></div>
                <div class="border rounded p-3 mt-3">
                    <h5>Créer un compte utilisateur</h5>
                    <div class="form-group"><label>Nom du compte</label><input type="text" name="new_user_name" class="form-control" value="{{ old('new_user_name') }}"><div class="text-danger">{{ $errors->first('new_user_name') }}</div></div>
                    <div class="form-group"><label>Email du compte</label><input type="email" name="new_user_email" class="form-control" value="{{ old('new_user_email') }}"><div class="text-danger">{{ $errors->first('new_user_email') }}</div></div>
                    <div class="form-group"><label>Mot de passe</label><input type="password" name="new_user_password" class="form-control"><div class="text-danger">{{ $errors->first('new_user_password') }}</div></div>
                    <small class="form-text text-muted">Remplissez ces champs pour créer automatiquement un compte utilisateur lié.</small>
                </div>
            </div>
            <div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('admin/employees/list') }}" class="btn btn-default">Annuler</a></div>
        </form>
    </div></div></section>
</div>
@endsection
