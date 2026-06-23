@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Demandes Administratives</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Demandes</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Type</th>
                                        <th>Objet</th>
                                        <th>Message</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($demandes as $demande)
                                    <tr>
                                        <td>{{ $demande->id }}</td>
                                        <td>{{ $demande->user_name }}</td>
                                        <td>{{ $demande->user_type == 2 ? 'Professeur' : 'Élève' }}</td>
                                        <td>{{ $demande->objet }}</td>
                                        <td>{{ Str::limit($demande->message, 50) }}</td>
                                        <td>
                                            @if($demande->statut == 'en_attente')
                                                <span class="badge badge-warning">En attente</span>
                                            @elseif($demande->statut == 'approuvee')
                                                <span class="badge badge-success">Approuvée</span>
                                            @else
                                                <span class="badge badge-danger">Rejetée</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-demande-{{ $demande->id }}">
                                                Gérer
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modal-demande-{{ $demande->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ url('admin/demandes/update/'.$demande->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Gérer la demande #{{ $demande->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>De:</strong> {{ $demande->user_name }}</p>
                                                                <p><strong>Objet:</strong> {{ $demande->objet }}</p>
                                                                <p><strong>Message:</strong><br>{{ $demande->message }}</p>
                                                                <hr>
                                                                <div class="form-group">
                                                                    <label>Statut</label>
                                                                    <select class="form-control" name="statut" required>
                                                                        <option value="en_attente" {{ $demande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                                        <option value="approuvee" {{ $demande->statut == 'approuvee' ? 'selected' : '' }}>Approuver</option>
                                                                        <option value="rejetee" {{ $demande->statut == 'rejetee' ? 'selected' : '' }}>Rejeter</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Réponse (Optionnel)</label>
                                                                    <textarea name="response" class="form-control" rows="3">{{ $demande->response }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Joindre un fichier (Optionnel)</label>
                                                                    <input type="file" name="response_file" class="form-control-file">
                                                                    @if(!empty($demande->response_file))
                                                                        <a href="{{ url('upload/demandes/'.$demande->response_file) }}" target="_blank" class="mt-2 d-block">Voir le fichier actuel</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
