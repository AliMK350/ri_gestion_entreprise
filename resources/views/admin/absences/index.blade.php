@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Absences</h1>
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
                            <h3 class="card-title">Liste des Absences</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Élève</th>
                                        <th>Matière</th>
                                        <th>Date</th>
                                        <th>Justifiée</th>
                                        <th>Motif</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absences as $absence)
                                    <tr>
                                        <td>{{ $absence->id }}</td>
                                        <td>{{ $absence->student_name }}</td>
                                        <td>{{ $absence->subject_name }}</td>
                                        <td>{{ $absence->date }}</td>
                                        <td>
                                            @if($absence->justifiee == 1)
                                                <span class="badge badge-success">Oui</span>
                                            @else
                                                <span class="badge badge-danger">Non</span>
                                            @endif
                                        </td>
                                        <td>{{ $absence->motif }}</td>
                                        <td>
                                            <a href="{{ url('admin/absences/delete/'.$absence->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?');">Supprimer</a>
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
