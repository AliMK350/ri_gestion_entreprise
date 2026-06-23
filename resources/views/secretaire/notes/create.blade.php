@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Ajouter une note</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.notes.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.notes.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Etudiant</label>
                                <select name="student_id" class="form-control" required>
                                    <option value="">Selectionner</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Matiere</label>
                                <input type="text" name="subject_name" class="form-control" list="subjects-list" value="{{ old('subject_name') }}" required>
                                <datalist id="subjects-list">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->name }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label>Note (/20)</label>
                                <input type="number" step="0.01" name="valeur" class="form-control" value="{{ old('valeur') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Coefficient</label>
                                <input type="number" step="0.1" name="coefficient" class="form-control" value="{{ old('coefficient', 1) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Session</label>
                                <input type="text" name="session" class="form-control" value="{{ old('session') }}" placeholder="Ex: S1, Examen">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
