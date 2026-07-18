@extends('layouts.app')
@section('content')
<div class="content-wrapper">

    {{-- En-tête de page --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-day mr-2" style="color:#00ADEF;"></i>Jours Fériés</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url('admin/jours-feries/add') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')

            {{-- Filtres --}}
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="type" class="form-control form-control-sm">
                            <option value="">— Tous les types —</option>
                            <option value="fixe"      {{ request('type') === 'fixe'      ? 'selected' : '' }}>Fixe</option>
                            <option value="religieux" {{ request('type') === 'religieux' ? 'selected' : '' }}>Religieux</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="year" class="form-control form-control-sm">
                            <option value="">— Toutes années —</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-filter mr-1"></i> Filtrer
                        </button>
                        <a href="{{ url('admin/jours-feries/list') }}" class="btn btn-sm btn-outline-secondary ml-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>

            {{-- Tableau --}}
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Date</th>
                                <th>Jour</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($getRecord as $i => $v)
                            <tr>
                                <td>{{ $getRecord->firstItem() + $i }}</td>
                                <td><strong>{{ $v->nom }}</strong></td>
                                <td>{{ $v->date->format('d/m/Y') }}</td>
                                <td class="text-muted" style="font-size:0.85rem;">
                                    {{ ucfirst(\Carbon\Carbon::parse($v->date)->locale('fr')->isoFormat('dddd')) }}
                                </td>
                                <td>
                                    @if($v->type === 'fixe')
                                        <span class="badge badge-info">Fixe</span>
                                    @else
                                        <span class="badge badge-warning">Religieux</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/jours-feries/edit/'.$v->id) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Éditer
                                    </a>
                                    <a href="{{ url('admin/jours-feries/delete/'.$v->id) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer ce jour férié ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                    Aucun jour férié enregistré.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="p-3">{{ $getRecord->appends(request()->query())->links() }}</div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
