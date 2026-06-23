@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Modifier une absence</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.absences.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.absences.update', $getRecord->id) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Etudiant</label>
                                <select name="student_id" class="form-control" required>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ $getRecord->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Matiere</label>
                                <input type="text" name="subject_name" class="form-control" value="{{ $getRecord->subject_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" value="{{ $getRecord->date }}" required>
                            </div>
                            <div class="form-group">
                                <label>Justifiee</label>
                                <select name="justifiee" class="form-control" required>
                                    <option value="0" {{ $getRecord->justifiee == 0 ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ $getRecord->justifiee == 1 ? 'selected' : '' }}>Oui</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Motif</label>
                                <input type="text" name="motif" class="form-control" value="{{ $getRecord->motif }}">
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
