@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mes demandes administratives</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('student.demandes.create') }}" class="btn btn-primary">Nouvelle demande</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @include('_message')
                        @if (empty($demandes) || count($demandes) === 0)
                            <p>Aucune demande pour le moment.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Objet</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($demandes as $demande)
                                        <tr>
                                            <td>{{ $demande->created_at ?? '-' }}</td>
                                            <td>{{ $demande->objet ?? '-' }}</td>
                                            <td>{{ $demande->statut ?? '-' }}</td>
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

