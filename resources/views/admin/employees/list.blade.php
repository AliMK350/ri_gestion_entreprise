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
            <div class="card">
                <div class="card-header"><h3 class="card-title">Rechercher</h3></div>
                <form method="get"><div class="card-body row">
                    <div class="col-md-4"><input type="text" name="name" class="form-control" placeholder="Nom" value="{{ Request::get('name') }}"></div>
                    <div class="col-md-4"><input type="text" name="email" class="form-control" placeholder="Email" value="{{ Request::get('email') }}"></div>
                    <div class="col-md-4"><button class="btn btn-primary">Rechercher</button></div>
                </div></form>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Poste</th><th>Département</th><th>Statut</th><th>Actions</th></tr></thead>
                        <tbody>
                        @forelse($getRecord as $i => $value)
                            <tr>
                                <td>{{ $getRecord->firstItem() + $i }}</td>
                                <td>{{ $value->name }}</td><td>{{ $value->email }}</td><td>{{ $value->phone }}</td>
                                <td>{{ $value->position }}</td><td>{{ $value->department }}</td>
                                <td><span class="badge badge-{{ $value->status == 0 ? 'success' : 'danger' }}">{{ $value->status == 0 ? 'Actif' : 'Inactif' }}</span></td>
                                <td>
                                    <a href="{{ url('admin/employees/show/'.$value->id) }}" class="btn btn-info btn-sm">Voir</a>
                                    <a href="{{ url('admin/employees/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Éditer</a>
                                    <a href="{{ url('admin/attestations/travail/'.$value->id) }}" target="_blank" class="btn btn-info btn-sm" title="Imprimer l'attestation de travail"><i class="fas fa-print"></i> Attestation</a>
                                    <a href="{{ url('admin/employees/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
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
