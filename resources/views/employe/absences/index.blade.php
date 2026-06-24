@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Mes Absences & Congés</h1></div><div class="col-sm-6 text-right"><a href="{{ url('employe/absences/create') }}" class="btn btn-primary">Déclarer absence</a> <a href="{{ url('employe/leaves/create') }}" class="btn btn-warning">Demander congé</a></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-header"><h3>Absences</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Date</th><th>Motif</th></tr></thead><tbody>@forelse($absences as $a)<tr><td>{{ $a->date->format('d/m/Y') }}</td><td>{{ $a->reason }}</td></tr>@empty<tr><td colspan="2">Aucune absence.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Congés</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Période</th><th>Type</th><th>Statut</th></tr></thead><tbody>@forelse($leaves as $l)<tr><td>{{ $l->start_date->format('d/m/Y') }} — {{ $l->end_date->format('d/m/Y') }}</td><td>{{ $l->type }}</td><td>{{ $l->status }}</td></tr>@empty<tr><td colspan="3">Aucun congé.</td></tr>@endforelse</tbody></table></div></div>
    </div></section>
</div>
@endsection
