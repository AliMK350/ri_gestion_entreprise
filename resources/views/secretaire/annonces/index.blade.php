@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Annonces</h1></div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('teacher.annonces.create') }}" class="btn btn-primary">Publier une annonce</a>
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
                        @if ($annonces->isEmpty())
                            <p>Aucune annonce publiee.</p>
                        @else
                            @foreach ($annonces as $annonce)
                                <div class="border-bottom mb-3 pb-2">
                                    <h5>{{ $annonce->title }}</h5>
                                    <p>{{ $annonce->contenu }}</p>
                                    <small class="text-muted">{{ $annonce->created_at }}</small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
