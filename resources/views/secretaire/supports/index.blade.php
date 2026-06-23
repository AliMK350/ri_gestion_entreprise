@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Supports de cours</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.supports.create') }}" class="btn btn-primary">Ajouter un support</a>
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
                        @if ($supports->isEmpty())
                            <p class="p-3">Aucun support publie.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Matiere</th>
                                        <th>Titre</th>
                                        <th>Fichier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supports as $support)
                                        <tr>
                                            <td>{{ $support->subject_name }}</td>
                                            <td>{{ $support->title }}</td>
                                            <td>
                                                @if ($support->file_url)
                                                    <a href="{{ $support->file_url }}" target="_blank">Telecharger</a>
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
