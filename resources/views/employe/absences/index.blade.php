@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mes absences</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Total d'absences :</strong> {{ $total_absences }}</p>
                        @if (empty($absences) || count($absences) === 0)
                            <p>Aucune absence enregistrée.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Matière</th>
                                        <th>Justifiée ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $absence)
                                        <tr>
                                            <td>{{ $absence->date ?? '-' }}</td>
                                            <td>{{ $absence->subject_name ?? '-' }}</td>
                                            <td>{{ $absence->justifiee ?? '-' }}</td>
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

