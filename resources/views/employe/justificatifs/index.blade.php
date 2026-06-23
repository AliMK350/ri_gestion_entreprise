@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mes justificatifs</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('student.justificatifs.create') }}" class="btn btn-primary">Déposer un
                                justificatif</a>
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
                        @if (empty($justificatifs) || count($justificatifs) === 0)
                            <p>Aucun justificatif déposé pour le moment.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Fichier</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($justificatifs as $justificatif)
                                        <tr>
                                            <td>{{ $justificatif->created_at ?? '-' }}</td>
                                            <td>{{ $justificatif->file_name ?? '-' }}</td>
                                            <td>{{ $justificatif->statut ?? '-' }}</td>
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

