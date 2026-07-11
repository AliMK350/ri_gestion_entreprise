@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Factures</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('secretaire/factures/add') }}" class="btn btn-primary">Nouvelle facture</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>Réf.</th><th>Client</th><th>Montant</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $f)<tr><td>{{ $f->reference }}</td><td>{{ $f->client->name ?? '-' }}</td><td>{{ number_format($f->amount, 2) }} MAD</td><td>{{ $f->status }}</td><td>
            <a href="{{ url('secretaire/factures/edit/'.$f->id) }}" class="btn btn-primary btn-sm">Éditer</a>
            <a href="{{ url('secretaire/factures/pdf/'.$f->id) }}" class="btn btn-info btn-sm">PDF</a>
            <a href="{{ url('secretaire/factures/delete/'.$f->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td></tr>@empty<tr><td colspan="5" class="text-center">Aucune facture.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
