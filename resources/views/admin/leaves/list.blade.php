@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Gestion des Congés</h1></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Employé</th><th>Période</th><th>Type</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $l)<tr>
            <td>{{ $l->employee->name ?? '-' }}</td>
            <td>{{ $l->start_date->format('d/m/Y') }} — {{ $l->end_date->format('d/m/Y') }}</td>
            <td>{{ $l->type }}</td>
            <td><span class="badge badge-{{ $l->status == 'approved' ? 'success' : ($l->status == 'rejected' ? 'danger' : 'warning') }}">{{ $l->status }}</span></td>
            <td>
                @if($l->status == 'pending')
                <form method="post" action="{{ url('admin/leaves/status/'.$l->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="approved"><button class="btn btn-success btn-sm">Approuver</button></form>
                <form method="post" action="{{ url('admin/leaves/status/'.$l->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="rejected"><button class="btn btn-warning btn-sm">Refuser</button></form>
                @endif
                <a href="{{ url('admin/leaves/delete/'.$l->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>@empty<tr><td colspan="5" class="text-center">Aucun congé.</td></tr>@endforelse
        </tbody></table>{{ $getRecord->links() }}</div></div>
    </div></section>
</div>
@endsection
