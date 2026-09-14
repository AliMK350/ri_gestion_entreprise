@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Gestion des Clients</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('secretaire/clients/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <form method="get" class="card card-body mb-3"><div class="form-row align-items-end">
            <div class="form-group col-md-5 mb-2"><label for="search">Recherche</label><input id="search" type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nom, entreprise, email ou ville"></div>
            <div class="form-group col-md-3 mb-2"><label for="client_type">Type</label><select id="client_type" name="client_type" class="form-control"><option value="">Tous les types</option><option value="entreprise" @selected(request('client_type') === 'entreprise')>Entreprise</option><option value="personne" @selected(request('client_type') === 'personne')>Personne</option></select></div>
            <div class="form-group col-md-2 mb-2"><button class="btn btn-primary btn-block" title="Filtrer"><i class="fas fa-search mr-1"></i>Rechercher</button></div>
        </div>@if(request()->hasAny(['search', 'client_type']))<a href="{{ url(request()->path()) }}" class="small">Réinitialiser les filtres</a>@endif</form>
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Type</th><th>Nom</th><th>Entreprise</th><th>Email</th><th>Téléphone</th><th>Ville</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $v)<tr>
            <td>
                @if(($v->client_type ?? 'entreprise') == 'personne')
                    <span class="badge badge-secondary"><i class="fas fa-user"></i> Personne</span>
                @else
                    <span class="badge badge-info"><i class="fas fa-building"></i> Entreprise</span>
                @endif
            </td>
            <td>{{ $v->name }}</td><td>{{ $v->company_name ?? '-' }}</td><td>{{ $v->email }}</td><td>{{ $v->phone ?? '-' }}</td><td>{{ $v->city ?? '-' }}</td><td><a href="{{ url('secretaire/clients/show/'.$v->id) }}" class="btn btn-info btn-sm">Historique</a> <a href="{{ url('secretaire/clients/edit/'.$v->id) }}" class="btn btn-primary btn-sm">Éditer</a></td></tr>@empty<tr><td colspan="7" class="text-center">Aucun client.</td></tr>@endforelse
        </tbody></table></div></div>
        <div class="mt-3">{{ $getRecord->links() }}</div>
    </div></section>
</div>
@endsection
