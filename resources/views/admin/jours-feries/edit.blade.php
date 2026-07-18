@extends('layouts.app')
@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1><i class="fas fa-calendar-edit mr-2" style="color:#00ADEF;"></i>Modifier le Jour Férié</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $getRecord->nom }}</h3>
                        </div>

                        <form method="POST" action="{{ url('admin/jours-feries/edit/'.$getRecord->id) }}">
                            @csrf
                            <div class="card-body">

                                {{-- Nom --}}
                                <div class="form-group">
                                    <label for="nom">Nom <span class="text-danger">*</span></label>
                                    <input type="text"
                                           id="nom"
                                           name="nom"
                                           class="form-control @error('nom') is-invalid @enderror"
                                           value="{{ old('nom', $getRecord->nom) }}"
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Date --}}
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                           id="date"
                                           name="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date', $getRecord->date->format('Y-m-d')) }}"
                                           required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Type --}}
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select id="type"
                                            name="type"
                                            class="form-control @error('type') is-invalid @enderror"
                                            required>
                                        <option value="fixe"      {{ old('type', $getRecord->type) === 'fixe'      ? 'selected' : '' }}>Fixe (date constante chaque année)</option>
                                        <option value="religieux" {{ old('type', $getRecord->type) === 'religieux' ? 'selected' : '' }}>Religieux (date variable)</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Les jours <strong>religieux</strong> (Aïd, Mawlid…) ont une date variable et doivent être mis à jour manuellement chaque année.
                                    </small>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Mettre à jour
                                </button>
                                <a href="{{ url('admin/jours-feries/list') }}" class="btn btn-default ml-2">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
