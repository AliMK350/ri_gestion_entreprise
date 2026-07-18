@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Mes Absences & Congés</h1></div><div class="col-sm-6 text-right"><a href="{{ url($personnelUrlPrefix.'/absences/create') }}" class="btn btn-primary">Déclarer absence</a> <a href="{{ url($personnelUrlPrefix.'/leaves/create') }}" class="btn btn-warning">Demander congé</a></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="alert alert-info">Votre solde de congé actuel est de <strong>{{ $employee->leave_balance_days ?? 0 }} jour(s)</strong>.</div>
        @php $pendingJustifications = $absences->filter(fn($a) => $a->needsEmployeeJustification()); @endphp
        @if($pendingJustifications->count())
            <div class="alert alert-warning">
                <strong>{{ $pendingJustifications->count() }} absence(s)</strong> déclarée(s) par l'administration nécessitent un motif et/ou un justificatif de votre part.
            </div>
        @endif
        <div class="card"><div class="card-header"><h3>Absences</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Date</th><th>Type</th><th>Source</th><th>Motif</th><th>Justificatif</th><th>Actions</th></tr></thead><tbody>@forelse($absences as $a)<tr><td>{{ $a->date->format('d/m/Y') }}</td><td>{{ $a->half_day ? ($a->half_day == 'morning' ? 'Demi-journée matin' : 'Demi-journée après-midi') : 'Journée complète' }}</td><td>@if($a->isDeclaredByAdmin())<span class="badge badge-warning">Administration</span>@else<span class="badge badge-secondary">Personnelle</span>@endif</td><td>{{ $a->reason ?: '—' }}</td><td>@if(!empty($a->justification_file))<a href="{{ asset('storage/'.$a->justification_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir</a>@else<span class="text-muted">Aucun</span>@endif</td><td>@if($a->isDeclaredByAdmin())<a href="{{ route($personnelUrlPrefix.'.absences.edit', $a->id) }}" class="btn btn-sm {{ $a->needsEmployeeJustification() ? 'btn-warning' : 'btn-outline-primary' }}">{{ $a->needsEmployeeJustification() ? 'Justifier' : 'Modifier' }}</a>@else<span class="text-muted">—</span>@endif</td></tr>@empty<tr><td colspan="6">Aucune absence.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card"><div class="card-header"><h3>Congés</h3></div><div class="card-body p-0"><table class="table"><thead><tr><th>Période</th><th>Type</th><th>Statut</th><th>Justificatif</th></tr></thead><tbody>@forelse($leaves as $l)<tr><td>{{ $l->start_date->format('d/m/Y') }} — {{ $l->end_date->format('d/m/Y') }}</td><td>{{ $l->type }}</td><td>{{ $l->status }}</td><td>@if(!empty($l->justification_file))<a href="{{ asset('storage/'.$l->justification_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir</a>@else<span class="text-muted">Aucun</span>@endif</td></tr>@empty<tr><td colspan="4">Aucun congé.</td></tr>@endforelse</tbody></table></div></div>
    </div></section>
</div>
@endsection
