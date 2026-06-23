@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Modifier une note</h1></div>
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
                    <form method="POST" action="{{ route('teacher.notes.update', $getRecord->id) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Etudiant</label>
                                <select name="student_id" class="form-control" required>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id', $getRecord->student_id) == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Matiere</label>
                                <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name', $getRecord->subject_name) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Note (/20)</label>
                                <input type="number" step="0.01" name="valeur" class="form-control" value="{{ old('valeur', $getRecord->valeur) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Coefficient</label>
                                <input type="number" step="0.1" name="coefficient" class="form-control" value="{{ old('coefficient', $getRecord->coefficient) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Session</label>
                                <input type="text" name="session" class="form-control" value="{{ old('session', $getRecord->session) }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Mettre a jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
