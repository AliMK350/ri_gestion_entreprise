@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Emploi du temps</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @if (empty($seances) || count($seances) === 0)
                            <p>Aucune séance planifiée pour le moment.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Jour</th>
                                        <th>Heure</th>
                                        <th>Matière</th>
                                        <th>Salle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($seances as $seance)
                                        <tr>
                                            <td>{{ $seance->jour ?? '-' }}</td>
                                            <td>{{ $seance->heure ?? '-' }}</td>
                                            <td>{{ $seance->subject_name ?? '-' }}</td>
                                            <td>{{ $seance->salle ?? '-' }}</td>
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

