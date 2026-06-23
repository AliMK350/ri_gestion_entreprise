@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Détail de la demande</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('student.demandes.index') }}" class="btn btn-secondary btn-sm">Retour à la liste</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card glass-card">
                <div class="card-body">
                    <h5 class="card-title">Objet : {{ $demande->objet }}</h5>
                    <p class="card-text">{{ $demande->message }}</p>
                    <p class="text-muted">Créée le {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                    <span class="badge {{ $demande->statut == 'en_attente' ? 'badge-warning' : ($demande->statut == 'accepte' ? 'badge-success' : 'badge-danger') }}">
                        {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
