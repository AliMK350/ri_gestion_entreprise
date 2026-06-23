@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Gestion des absences</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.absences.create') }}" class="btn btn-primary">Enregistrer une absence</a>
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
                        @if ($absences->isEmpty())
                            <p class="p-3">Aucune absence enregistree.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Etudiant ID</th>
                                        <th>Matiere</th>
                                        <th>Date</th>
                                        <th>Justifiee</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $absence)
                                        <tr>
                                            <td>{{ $absence->student_id }}</td>
                                            <td>{{ $absence->subject_name }}</td>
                                            <td>{{ $absence->date }}</td>
                                            <td>{{ $absence->justifiee ? 'Oui' : 'Non' }}</td>
                                            <td>
                                                <a href="{{ route('teacher.absences.edit', $absence->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
