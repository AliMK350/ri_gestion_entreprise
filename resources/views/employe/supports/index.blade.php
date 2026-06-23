@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Supports de cours</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @include('_message')
                        @if (empty($supports) || count($supports) === 0)
                            <p>Aucun support disponible pour le moment.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Matière</th>
                                        <th>Titre</th>
                                        <th>Fichier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supports as $support)
                                        <tr>
                                            <td>{{ $support->subject_name ?? '-' }}</td>
                                            <td>{{ $support->title ?? '-' }}</td>
                                            <td>
                                                @if (!empty($support->file_url))
                                                    <a href="{{ $support->file_url }}" target="_blank">Télécharger</a>
                                                @else
                                                    -
                                                @endif
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

