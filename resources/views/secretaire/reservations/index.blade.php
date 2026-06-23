@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Reservations de salles</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.reservations.create') }}" class="btn btn-primary">Nouvelle reservation</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card">
                    <div class="card-body p-0">
                        @if ($reservations->isEmpty())
                            <p class="p-3">Aucune reservation.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Salle ID</th>
                                        <th>Date</th>
                                        <th>Debut</th>
                                        <th>Fin</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->salle_id }}</td>
                                            <td>{{ $reservation->date }}</td>
                                            <td>{{ $reservation->heure_debut }}</td>
                                            <td>{{ $reservation->heure_fin }}</td>
                                            <td>{{ $reservation->statut }}</td>
                                            <td>
                                                <a href="{{ route('teacher.reservations.delete', $reservation->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Supprimer cette reservation ?');">Supprimer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
