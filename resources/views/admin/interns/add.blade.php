@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Ajouter un Stagiaire</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nom *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label>Spécialité</label>
                            <input type="text" name="specialite" class="form-control" value="{{ old('specialite') }}" placeholder="ex: Informatique, Gestion, Marketing...">
                        </div>
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                        </div>
                        <div class="form-group">
                            <label>Niveau d'étude</label>
                            <select name="niveau_etude" class="form-control">
                                <option value="">-- Sélectionner le niveau d'étude (Optionnel) --</option>
                                <option value="Bac+1" {{ old('niveau_etude') == 'Bac+1' ? 'selected' : '' }}>Bac+1</option>
                                <option value="Bac+2" {{ old('niveau_etude') == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                <option value="Bac+3" {{ old('niveau_etude') == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                <option value="Bac+4" {{ old('niveau_etude') == 'Bac+4' ? 'selected' : '' }}>Bac+4</option>
                                <option value="Bac+5" {{ old('niveau_etude') == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>CV (PDF / Word)</label>
                            <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                        <div class="form-group">
                            <label>Début</label>
                            <input type="date" name="started_at" class="form-control" value="{{ old('started_at') }}">
                        </div>
                        <div class="form-group">
                            <label>Fin</label>
                            <input type="date" name="ended_at" class="form-control" value="{{ old('ended_at') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Enregistrer</button>
                        <a href="{{ url('admin/interns/list') }}" class="btn btn-default">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
