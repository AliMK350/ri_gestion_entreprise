@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stagiaires</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url('admin/interns/add') }}" class="btn btn-primary">Ajouter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            <form method="get" class="card card-body mb-3">
                <div class="form-row align-items-end">
                    <div class="form-group col-lg-4 mb-2"><label for="search">Recherche globale</label><input id="search" type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nom, email, téléphone ou ville"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="city">Ville</label><input id="city" type="text" name="city" class="form-control" value="{{ request('city') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="specialite">Spécialité</label><input id="specialite" type="text" name="specialite" class="form-control" value="{{ request('specialite') }}"></div>
                    <div class="form-group col-lg-2 mb-2"><label for="niveau_etude">Niveau d'étude</label><select id="niveau_etude" name="niveau_etude" class="form-control"><option value="">Tous</option>@foreach($niveauEtudes as $niveau)<option value="{{ $niveau }}" @selected(request('niveau_etude') === $niveau)>{{ $niveau }}</option>@endforeach</select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="period">Période</label><select id="period" name="period" class="form-control"><option value="">Toutes</option><option value="current" @selected(request('period') === 'current')>En cours</option><option value="upcoming" @selected(request('period') === 'upcoming')>À venir</option><option value="finished" @selected(request('period') === 'finished')>Terminés</option></select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="cv">CV</label><select id="cv" name="cv" class="form-control"><option value="">Tous</option><option value="yes" @selected(request('cv') === 'yes')>Avec CV</option><option value="no" @selected(request('cv') === 'no')>Sans CV</option></select></div>
                    <div class="form-group col-lg-2 mb-2"><label for="started_from">Début du</label><input id="started_from" type="date" name="started_from" class="form-control" value="{{ request('started_from') }}"></div><div class="form-group col-lg-2 mb-2"><label for="started_to">Début au</label><input id="started_to" type="date" name="started_to" class="form-control" value="{{ request('started_to') }}"></div><div class="form-group col-lg-2 mb-2"><label for="ended_to">Fin au</label><input id="ended_to" type="date" name="ended_to" class="form-control" value="{{ request('ended_to') }}"></div><div class="form-group col-lg-2 mb-2"><button class="btn btn-primary btn-block"><i class="fas fa-search mr-1"></i>Filtrer</button></div>
                </div>
                @if(request()->hasAny(['search','city','specialite','niveau_etude','period','cv','started_from','started_to','ended_to']))<a href="{{ url(request()->path()) }}" class="small">Réinitialiser les filtres</a>@endif
            </form>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Spécialité</th>
                                <th>Niveau d'étude</th>
                                <th>Période</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getRecord as $i => $v)
                                <tr>
                                    <td>{{ $getRecord->firstItem() + $i }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->email }}</td>
                                    <td>{{ $v->phone ?? '-' }}</td>
                                    <td>{{ $v->city ?? '-' }}</td>
                                    <td>{{ $v->specialite ?? '-' }}</td>
                                    <td>{{ $v->niveau_etude ?? '-' }}</td>
                                    <td>{{ optional($v->started_at)->format('d/m/Y') }} — {{ optional($v->ended_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ url('admin/interns/edit/' . $v->id) }}" class="btn btn-primary btn-sm">Éditer</a>
                                        <a href="{{ url('admin/attestations/stage/' . $v->id) }}" target="_blank" class="btn btn-info btn-sm" title="Imprimer l'attestation de stage">
                                            <i class="fas fa-print"></i> Attestation
                                        </a>
                                        @if($v->cv_path)
                                            <a href="{{ url('admin/interns/download-cv/' . $v->id) }}" class="btn btn-success btn-sm" title="Télécharger le CV">
                                                <i class="fas fa-download"></i> CV
                                            </a>
                                        @else
                                            <span class="badge badge-secondary" title="Aucun CV uploadé">Pas de CV</span>
                                        @endif
                                        @if(Auth::user()->user_type != 4)
                                            <a href="{{ url('admin/interns/delete/' . $v->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucun stagiaire.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $getRecord->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
