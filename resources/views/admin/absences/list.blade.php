@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Absences</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('admin/absences/add') }}" class="btn btn-primary">Déclarer</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Employé</th><th>Date</th><th>Type</th><th>Source</th><th>Motif</th><th>Justificatif</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $a)<tr><td>{{ $a->employee->name ?? '-' }}</td><td>{{ $a->date->format('d/m/Y') }}</td><td>{{ $a->half_day ? ($a->half_day == 'morning' ? 'Demi-journée matin' : 'Demi-journée après-midi') : 'Journée complète' }}</td><td>@if($a->isDeclaredByAdmin())<span class="badge badge-warning">Administration</span>@else<span class="badge badge-secondary">Employé</span>@endif</td><td>{{ $a->reason ?: '—' }}</td><td>@if(!empty($a->justification_file))<a href="{{ asset('storage/'.$a->justification_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir</a>@else<span class="text-muted">En attente</span>@endif</td><td><a href="{{ url('admin/absences/delete/'.$a->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a></td></tr>@empty<tr><td colspan="7" class="text-center">Aucune absence.</td></tr>@endforelse
        </tbody></table>{{ $getRecord->links() }}</div></div>
    </div></section>
</div>
@endsection
