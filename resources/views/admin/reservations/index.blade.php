@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Réservations des Salles</h1>
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
                            <h3 class="card-title">Liste des Réservations</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Salle</th>
                                        <th>Professeur</th>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Motif</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->id }}</td>
                                        <td>{{ $reservation->salle_name }}</td>
                                        <td>{{ $reservation->teacher_name }}</td>
                                        <td>{{ $reservation->date }}</td>
                                        <td>{{ $reservation->heure_debut }} - {{ $reservation->heure_fin }}</td>
                                        <td>{{ Str::limit($reservation->motif, 30) }}</td>
                                        <td>
                                            @if($reservation->statut == 'en_attente')
                                                <span class="badge badge-warning">En attente</span>
                                            @elseif($reservation->statut == 'approuve')
                                                <span class="badge badge-success">Approuvé</span>
                                            @else
                                                <span class="badge badge-danger">Refusé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-reservation-{{ $reservation->id }}">
                                                Gérer
                                            </button>
                                            <a href="{{ url('admin/reservations/delete/'.$reservation->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette réservation?');">Supprimer</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modal-reservation-{{ $reservation->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ url('admin/reservations/update/'.$reservation->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Gérer la réservation #{{ $reservation->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Salle:</strong> {{ $reservation->salle_name }}</p>
                                                                <p><strong>Professeur:</strong> {{ $reservation->teacher_name }}</p>
                                                                <p><strong>Date & Heure:</strong> {{ $reservation->date }} de {{ $reservation->heure_debut }} à {{ $reservation->heure_fin }}</p>
                                                                <p><strong>Motif:</strong><br>{{ $reservation->motif }}</p>
                                                                <hr>
                                                                <div class="form-group">
                                                                    <label>Statut</label>
                                                                    <select class="form-control" name="statut" required>
                                                                        <option value="en_attente" {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                                        <option value="approuve" {{ $reservation->statut == 'approuve' ? 'selected' : '' }}>Approuver</option>
                                                                        <option value="refuse" {{ $reservation->statut == 'refuse' ? 'selected' : '' }}>Refuser</option>
                                                                    </select>
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
