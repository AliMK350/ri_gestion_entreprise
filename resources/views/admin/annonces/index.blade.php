@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Annonces</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{ url('admin/annonces/add') }}" class="btn btn-primary">Ajouter une Annonce</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Annonces</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>Statut</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($annonces as $annonce)
                                    <tr>
                                        <td>{{ $annonce->id }}</td>
                                        <td>{{ $annonce->title }}</td>
                                        <td>
                                            @if($annonce->status == 'active')
                                                <span class="badge badge-success">Actif</span>
                                            @else
                                                <span class="badge badge-danger">Inactif</span>
                                            @endif
                                        </td>
                                        <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ url('admin/annonces/edit/'.$annonce->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                            <a href="{{ url('admin/annonces/delete/'.$annonce->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette annonce?');">Supprimer</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
