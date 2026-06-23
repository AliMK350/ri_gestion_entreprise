@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Nouvelle demande administrative</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.demandes.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.demandes.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Objet</label>
                                <input type="text" name="objet" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
