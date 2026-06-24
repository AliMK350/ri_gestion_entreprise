@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Fiche Employé — {{ $getRecord->name }}</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="card"><div class="card-body">
            <p><strong>Email:</strong> {{ $getRecord->email }} | <strong>Poste:</strong> {{ $getRecord->position }} | <strong>Département:</strong> {{ $getRecord->department }}</p>
        </div></div>
        <div class="card"><div class="card-header"><h3>Absences</h3></div><div class="card-body p-0">
            <table class="table"><thead><tr><th>Date</th><th>Motif</th></tr></thead><tbody>
            @forelse($getRecord->absences as $a)<tr><td>{{ $a->date->format('d/m/Y') }}</td><td>{{ $a->reason }}</td></tr>@empty<tr><td colspan="2">Aucune absence.</td></tr>@endforelse
            </tbody></table>
        </div></div>
        <div class="card"><div class="card-header"><h3>Congés</h3></div><div class="card-body p-0">
            <table class="table"><thead><tr><th>Période</th><th>Type</th><th>Statut</th></tr></thead><tbody>
            @forelse($getRecord->leaves as $l)<tr><td>{{ $l->start_date->format('d/m/Y') }} — {{ $l->end_date->format('d/m/Y') }}</td><td>{{ $l->type }}</td><td>{{ $l->status }}</td></tr>@empty<tr><td colspan="3">Aucun congé.</td></tr>@endforelse
            </tbody></table>
        </div></div>
        <a href="{{ url('admin/employees/list') }}" class="btn btn-default">Retour</a>
    </div></section>
</div>
@endsection
