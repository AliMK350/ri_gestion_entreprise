@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Demandes administratives</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.demandes.create') }}" class="btn btn-primary">Nouvelle demande</a>
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
                        @if ($demandes->isEmpty())
                            <p class="p-3">Aucune demande.</p>
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
                                            <td>{{ $demande->created_at }}</td>
                                            <td>{{ $demande->objet }}</td>
                                            <td>{{ $demande->statut }}</td>
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
