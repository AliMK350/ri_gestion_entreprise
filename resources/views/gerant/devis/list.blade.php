@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Validation des Devis</h1></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>#</th><th>Client</th><th>Montant</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $q)<tr><td>#{{ $q->id }}</td><td>{{ $q->client->name ?? '-' }}</td><td>{{ number_format($q->total_amount, 2) }} MAD</td><td>{{ $q->status }}</td><td>
            @if(in_array($q->status, ['draft','sent']))
            <form method="post" action="{{ url('gerant/devis/validate/'.$q->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="accepted"><button class="btn btn-success btn-sm">Valider</button></form>
            <form method="post" action="{{ url('gerant/devis/validate/'.$q->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="rejected"><button class="btn btn-warning btn-sm">Refuser</button></form>
            @endif
            <a href="{{ url('gerant/devis/delete/'.$q->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td></tr>@empty<tr><td colspan="5" class="text-center">Aucun devis.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
