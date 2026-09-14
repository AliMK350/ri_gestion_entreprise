@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Gestion des Congés</h1></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <form method="get" class="card card-body mb-3"><div class="form-row align-items-end">
            <div class="form-group col-md-3 mb-2"><label for="search">Employé</label><input id="search" type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nom de l'employé"></div>
            <div class="form-group col-md-2 mb-2"><label for="status">Statut</label><select id="status" name="status" class="form-control"><option value="">Tous</option><option value="pending" @selected(request('status') === 'pending')>En attente</option><option value="approved" @selected(request('status') === 'approved')>Approuvé</option><option value="rejected" @selected(request('status') === 'rejected')>Refusé</option><option value="cancelled" @selected(request('status') === 'cancelled')>Annulé</option></select></div>
            <div class="form-group col-md-2 mb-2"><label for="type">Type</label><input id="type" type="text" name="type" class="form-control" value="{{ request('type') }}" placeholder="Type de congé"></div>
            <div class="form-group col-md-2 mb-2"><label for="date_from">Du</label><input id="date_from" type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"></div><div class="form-group col-md-2 mb-2"><label for="date_to">Au</label><input id="date_to" type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"></div><div class="form-group col-md-1 mb-2"><button class="btn btn-primary btn-block" title="Filtrer"><i class="fas fa-search"></i></button></div>
        </div>@if(request()->hasAny(['search', 'status', 'type', 'date_from', 'date_to']))<a href="{{ url(request()->path()) }}" class="small">Réinitialiser les filtres</a>@endif</form>
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Employé</th><th>Période</th><th>Type</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $l)<tr>
            <td>{{ $l->employee->name ?? '-' }}</td>
            <td>{{ $l->start_date->format('d/m/Y') }} — {{ $l->end_date->format('d/m/Y') }}</td>
            <td>{{ $l->type }}</td>
            <td><span class="badge badge-{{ $l->status == 'approved' ? 'success' : ($l->status == 'rejected' ? 'danger' : ($l->status == 'cancelled' ? 'secondary' : 'warning')) }}">{{ $l->status }}</span></td>
            <td>
                @if($l->status == 'pending')
                <form method="post" action="{{ url('admin/leaves/status/'.$l->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="approved"><button class="btn btn-success btn-sm">Approuver</button></form>
                <form method="post" action="{{ url('admin/leaves/status/'.$l->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="rejected"><button class="btn btn-warning btn-sm">Refuser</button></form>
                @elseif($l->status == 'approved')
                <form method="post" action="{{ url('admin/leaves/status/'.$l->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="cancelled"><button class="btn btn-secondary btn-sm">Annuler</button></form>
                @endif
                <a href="{{ url('admin/leaves/delete/'.$l->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>@empty<tr><td colspan="5" class="text-center">Aucun congé.</td></tr>@endforelse
        </tbody></table>{{ $getRecord->links() }}</div></div>
    </div></section>
</div>
@endsection
