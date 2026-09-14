@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Liste des Employés</h1></div>
                <div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('admin/employees/add') }}" class="btn btn-primary">Ajouter</a></div></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('_message')
            <form method="get" class="card card-body mb-3">
                <div class="form-row align-items-end">
                    <div class="form-group col-lg-4 mb-2"><label for="search">Recherche globale</label><input id="search" type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nom, email, téléphone ou ville"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="city">Ville</label><input id="city" type="text" name="city" class="form-control" value="{{ request('city') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="position">Poste</label><input id="position" type="text" name="position" class="form-control" value="{{ request('position') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="specialite">Spécialité</label><input id="specialite" type="text" name="specialite" class="form-control" value="{{ request('specialite') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="status">Statut</label><select id="status" name="status" class="form-control"><option value="">Tous</option><option value="0" @selected(request('status') === '0')>Actifs</option><option value="1" @selected(request('status') === '1')>Inactifs</option></select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="account">Compte utilisateur</label><select id="account" name="account" class="form-control"><option value="">Tous</option><option value="yes" @selected(request('account') === 'yes')>Avec compte</option><option value="no" @selected(request('account') === 'no')>Sans compte</option></select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="cv">CV</label><select id="cv" name="cv" class="form-control"><option value="">Tous</option><option value="yes" @selected(request('cv') === 'yes')>Avec CV</option><option value="no" @selected(request('cv') === 'no')>Sans CV</option></select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="hired_from">Embauché du</label><input id="hired_from" type="date" name="hired_from" class="form-control" value="{{ request('hired_from') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="hired_to">Embauché au</label><input id="hired_to" type="date" name="hired_to" class="form-control" value="{{ request('hired_to') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><button class="btn btn-primary btn-block"><i class="fas fa-search mr-1"></i>Filtrer</button></div>
                </div>
                @if(request()->hasAny(['search','city','position','specialite','status','account','cv','hired_from','hired_to']))<a href="{{ url(request()->path()) }}" class="small">Réinitialiser les filtres</a>@endif
            </form>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Ville</th><th>Poste</th><th>Spécialité</th><th>Actions</th></tr></thead>
                        <tbody>
                        @forelse($getRecord as $i => $value)
                            <tr>
                                <td>{{ $getRecord->firstItem() + $i }}</td>
                                <td>{{ $value->name }}</td><td>{{ $value->email }}</td><td>{{ $value->phone }}</td>
                                <td>{{ $value->city ?? '-' }}</td><td>{{ $value->position }}</td><td>{{ $value->specialite ?? '-' }}</td>
                                <td>
                                    <a href="{{ url('admin/employees/show/'.$value->id) }}" class="btn btn-info btn-sm">Voir</a>
                                    <a href="{{ url('admin/employees/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Éditer</a>
                                    <a href="{{ url('admin/attestations/travail/'.$value->id) }}" target="_blank" class="btn btn-info btn-sm" title="Imprimer l'attestation de travail"><i class="fas fa-print"></i> Attestation</a>
                                    @if(Auth::user()->user_type != 4)
                                        <a href="{{ url('admin/employees/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Aucun employé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $getRecord->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
