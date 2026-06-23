@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Modifier cahier de texte</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.cahier-texte.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.cahier-texte.update', $getRecord->id) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Matiere</label>
                                <input type="text" name="subject_name" class="form-control" value="{{ $getRecord->subject_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Date de seance</label>
                                <input type="date" name="date_seance" class="form-control" value="{{ $getRecord->date_seance }}">
                            </div>
                            <div class="form-group">
                                <label>Contenu</label>
                                <textarea name="contenu" rows="6" class="form-control" required>{{ $getRecord->contenu }}</textarea>
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
