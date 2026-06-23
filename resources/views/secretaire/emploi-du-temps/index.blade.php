@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Emploi du temps</h1></div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body p-0">
                        @if ($seances->isEmpty())
                            <p class="p-3">Aucune seance planifiee.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Jour</th>
                                        <th>Heure</th>
                                        <th>Matiere</th>
                                        <th>Salle</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($seances as $seance)
                                        <tr>
                                            <td>{{ $seance->jour ?? '-' }}</td>
                                            <td>{{ $seance->heure ?? '-' }}</td>
                                            <td>{{ $seance->subject_name ?? '-' }}</td>
                                            <td>{{ $seance->salle ?? '-' }}</td>
                                            <td>{{ $seance->date_seance ?? '-' }}</td>
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
