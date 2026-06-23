@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Modifier une Annonce</h1>
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
                                    <label>Titre</label>
                                    <input type="text" class="form-control" name="title" required value="{{ old('title', $annonce->title) }}">
                                </div>
                                <div class="form-group">
                                    <label>Contenu</label>
                                    <textarea class="form-control" name="contenu" rows="5" required>{{ old('contenu', $annonce->contenu) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select class="form-control" name="status" required>
                                        <option value="active" {{ old('status', $annonce->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="inactive" {{ old('status', $annonce->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
