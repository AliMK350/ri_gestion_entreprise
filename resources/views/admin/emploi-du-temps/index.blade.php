@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Emploi du Temps</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{ url('admin/emploi-du-temps/add') }}" class="btn btn-primary">Ajouter une Séance</a>
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
                            <h3 class="card-title">Liste des Séances</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Classe</th>
                                        <th>Professeur</th>
                                        <th>Matière</th>
                                        <th>Jour</th>
                                        <th>Heure</th>
                                        <th>Salle</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emplois as $emploi)
                                    <tr>
                                        <td>{{ $emploi->id }}</td>
                                        <td>{{ $emploi->class_name }}</td>
                                        <td>{{ $emploi->teacher_name }}</td>
                                        <td>{{ $emploi->subject_name }}</td>
                                        <td>{{ $emploi->jour }}</td>
                                        <td>{{ $emploi->heure }}</td>
                                        <td>{{ $emploi->salle }}</td>
                                        <td>
                                            <a href="{{ url('admin/emploi-du-temps/edit/'.$emploi->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                            <a href="{{ url('admin/emploi-du-temps/delete/'.$emploi->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette séance?');">Supprimer</a>
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
