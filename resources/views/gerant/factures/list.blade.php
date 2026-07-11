@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Validation des Factures</h1></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Réf.</th><th>Client</th><th>Montant</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $f)<tr><td>{{ $f->reference }}</td><td>{{ $f->client->name ?? '-' }}</td><td>{{ number_format($f->amount, 2) }} MAD</td><td>{{ $f->status }}</td><td>
            @if(in_array($f->status, ['draft','sent']))
            <form method="post" action="{{ url('gerant/factures/validate/'.$f->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="validated"><button class="btn btn-success btn-sm">Valider</button></form>
            <form method="post" action="{{ url('gerant/factures/validate/'.$f->id) }}" class="d-inline">@csrf<input type="hidden" name="status" value="cancelled"><button class="btn btn-warning btn-sm">Annuler</button></form>
            @endif
            <a href="{{ url('gerant/factures/delete/'.$f->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td></tr>@empty<tr><td colspan="5" class="text-center">Aucune facture.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
