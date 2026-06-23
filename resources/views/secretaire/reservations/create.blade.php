@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Nouvelle reservation</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.reservations.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.reservations.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Salle</label>
                                <input type="text" name="salle_name" class="form-control" value="{{ old('salle_name') }}" placeholder="Ex: Salle B5" required>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Heure debut</label>
                                <input type="time" name="heure_debut" class="form-control" value="{{ old('heure_debut') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Heure fin</label>
                                <input type="time" name="heure_fin" class="form-control" value="{{ old('heure_fin') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Motif</label>
                                <input type="text" name="motif" class="form-control" value="{{ old('motif') }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Reserver</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
