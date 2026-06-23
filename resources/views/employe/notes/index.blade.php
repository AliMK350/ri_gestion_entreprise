@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mes notes</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @include('_message')
                        @if (empty($notes) || count($notes) === 0)
                            <p>Aucune note disponible pour le moment.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Matière</th>
                                        <th>Note</th>
                                        <th>Coefficient</th>
                                        <th>Session</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr>
                                            <td>{{ $note->subject_name ?? '-' }}</td>
                                            <td>{{ $note->valeur ?? '-' }}</td>
                                            <td>{{ $note->coefficient ?? '-' }}</td>
                                            <td>{{ $note->session ?? '-' }}</td>
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

