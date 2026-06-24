@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Clients</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('secretaire/clients/add') }}" class="btn btn-primary">Ajouter</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Nom</th><th>Entreprise</th><th>Email</th><th>Téléphone</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $v)<tr><td>{{ $v->name }}</td><td>{{ $v->company_name }}</td><td>{{ $v->email }}</td><td>{{ $v->phone }}</td><td>{{ $v->status == 0 ? 'Actif' : 'Inactif' }}</td><td><a href="{{ url('secretaire/clients/show/'.$v->id) }}" class="btn btn-info btn-sm">Historique</a> <a href="{{ url('secretaire/clients/edit/'.$v->id) }}" class="btn btn-primary btn-sm">Éditer</a></td></tr>@empty<tr><td colspan="6" class="text-center">Aucun client.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
