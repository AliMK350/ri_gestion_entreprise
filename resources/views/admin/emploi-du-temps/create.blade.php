@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajouter une Séance</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card card-primary">
                        <form method="POST" action="">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Classe</label>
                                    <select class="form-control" name="class_id" required>
                                        <option value="">Sélectionner une classe</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Professeur</label>
                                    <select class="form-control" name="teacher_id" required>
                                        <option value="">Sélectionner un professeur</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Matière</label>
                                    <input type="text" class="form-control" name="subject_name" required value="{{ old('subject_name') }}">
                                </div>
                                <div class="form-group">
                                    <label>Jour</label>
                                    <select class="form-control" name="jour" required>
                                        <option value="">Sélectionner un jour</option>
                                        <option value="Lundi" {{ old('jour') == 'Lundi' ? 'selected' : '' }}>Lundi</option>
                                        <option value="Mardi" {{ old('jour') == 'Mardi' ? 'selected' : '' }}>Mardi</option>
                                        <option value="Mercredi" {{ old('jour') == 'Mercredi' ? 'selected' : '' }}>Mercredi</option>
                                        <option value="Jeudi" {{ old('jour') == 'Jeudi' ? 'selected' : '' }}>Jeudi</option>
                                        <option value="Vendredi" {{ old('jour') == 'Vendredi' ? 'selected' : '' }}>Vendredi</option>
                                        <option value="Samedi" {{ old('jour') == 'Samedi' ? 'selected' : '' }}>Samedi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Heure (ex: 08:00 - 10:00)</label>
                                    <input type="text" class="form-control" name="heure" required value="{{ old('heure') }}">
                                </div>
                                <div class="form-group">
                                    <label>Salle</label>
                                    <input type="text" class="form-control" name="salle" required value="{{ old('salle') }}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Soumettre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
