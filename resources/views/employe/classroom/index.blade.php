@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Classroom</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Annonces</h3>
                            </div>
                            <div class="card-body">
                                @if (empty($annonces) || count($annonces) === 0)
                                    <p>Aucune annonce pour le moment.</p>
                                @else
                                    @foreach ($annonces as $annonce)
                                        <div class="mb-3 border-bottom pb-2">
    <h5>{{ $annonce->titre ?? 'Annonce' }}</h5>
    <p>{{ $annonce->contenu ?? '' }}</p>
    <small class="text-muted">{{ $annonce->created_at ?? '' }}</small>
    <form action="{{ route('student.classroom.store') }}" method="POST" class="mt-2">
        @csrf
        <input type="hidden" name="annonce_id" value="{{ $annonce->id ?? '' }}">
        <div class="form-group">
            <textarea name="contenu" class="form-control" rows="2" placeholder="Ajouter un commentaire..." required>{{ old('contenu') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm mt-1">Envoyer</button>
    </form>
</div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Commentaires récents</h3>
                            </div>
                            <div class="card-body">
                                @if (empty($commentaires) || count($commentaires) === 0)
                                    <p>Aucun commentaire pour le moment.</p>
                                @else
                                    @foreach ($commentaires as $commentaire)
                                        <div class="mb-2 border-bottom pb-1">
                                            <p>{{ $commentaire->contenu ?? '' }}</p>
                                            <small class="text-muted">
                                                {{ $commentaire->created_at ?? '' }}
                                            </small>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

