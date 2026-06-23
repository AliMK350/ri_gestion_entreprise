@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Saisie des notes</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.notes.create') }}" class="btn btn-primary">Ajouter une note</a>
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
                        @if ($notes->isEmpty())
                            <p class="p-3">Aucune note enregistree.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Etudiant ID</th>
                                        <th>Matiere</th>
                                        <th>Note</th>
                                        <th>Coef.</th>
                                        <th>Session</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr>
                                            <td>{{ $note->student_id }}</td>
                                            <td>{{ $note->subject_name }}</td>
                                            <td>{{ $note->valeur }}</td>
                                            <td>{{ $note->coefficient }}</td>
                                            <td>{{ $note->session ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('teacher.notes.edit', $note->id) }}" class="btn btn-primary btn-sm">Modifier</a>
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
