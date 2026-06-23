@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Cahier de texte</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.cahier-texte.create') }}" class="btn btn-primary">Nouvelle entree</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card">
                    <div class="card-body">
                        @if ($entries->isEmpty())
                            <p>Aucune entree dans le cahier de texte.</p>
                        @else
                            @foreach ($entries as $entry)
                                <div class="border-bottom mb-3 pb-2">
                                    <h5>{{ $entry->subject_name }} - {{ $entry->date_seance ?? 'Sans date' }}</h5>
                                    <p>{{ $entry->contenu }}</p>
                                    <a href="{{ route('teacher.cahier-texte.edit', $entry->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
