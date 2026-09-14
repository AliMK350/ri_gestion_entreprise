@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Ajouter un Client</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card card-primary"><form method="post">@csrf<div class="card-body">
        <div class="form-group">
            <label>Type de Client *</label>
            <div class="d-flex align-items-center">
                <div class="custom-control custom-radio mr-4">
                    <input class="custom-control-input" type="radio" id="typeEntreprise" name="client_type" value="entreprise" {{ old('client_type', 'entreprise') == 'entreprise' ? 'checked' : '' }} required>
                    <label for="typeEntreprise" class="custom-control-label font-weight-bold">
                        <i class="fas fa-building text-info mr-1"></i> Entreprise
                    </label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="typePersonne" name="client_type" value="personne" {{ old('client_type') == 'personne' ? 'checked' : '' }} required>
                    <label for="typePersonne" class="custom-control-label font-weight-bold">
                        <i class="fas fa-user text-secondary mr-1"></i> Personne (Particulier)
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group"><label>Nom complet *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
        <div class="form-group"><label>Entreprise</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}"></div>
        <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
        <div class="form-group"><label>Téléphone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        <div class="form-group"><label>Ville</label><input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
        <div class="form-group"><label>Adresse</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
    </div><div class="card-footer"><button class="btn btn-primary">Enregistrer</button> <a href="{{ url('secretaire/clients/list') }}" class="btn btn-default">Annuler</a></div></form></div></div></section>
</div>
@endsection
