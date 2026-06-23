@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Ajouter un support</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.supports.index') }}">Retour</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('teacher.supports.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Matiere</label>
                                <input type="text" name="subject_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Fichier</label>
                                <input type="file" name="fichier" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
