@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestion des Clients</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url('gerant/clients/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Nom</th>
                                <th>Entreprise</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getRecord as $i => $v)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if(($v->client_type ?? 'entreprise') == 'personne')
                                            <span class="badge badge-secondary"><i class="fas fa-user"></i> Personne</span>
                                        @else
                                            <span class="badge badge-info"><i class="fas fa-building"></i> Entreprise</span>
                                        @endif
                                    </td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->company_name ?? '-' }}</td>
                                    <td>{{ $v->email }}</td>
                                    <td>{{ $v->phone ?? '-' }}</td>
                                    <td>{{ $v->city ?? '-' }}</td>
                                    <td>
                                        <a href="{{ url('gerant/clients/history/'.$v->id) }}" class="btn btn-info btn-sm">Historique</a>
                                        <a href="{{ url('gerant/clients/edit/'.$v->id) }}" class="btn btn-primary btn-sm">Éditer</a>
                                        <a href="{{ url('gerant/clients/delete/'.$v->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer ce client ?')">Supprimer</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun client.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-2">
                        {{ $getRecord->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
