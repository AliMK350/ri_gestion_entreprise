@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Reçus</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('secretaire/recus/add') }}" class="btn btn-primary">Nouveau reçu</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>#</th><th>Client</th><th>Facture</th><th>Montant</th><th>Date paiement</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $r)<tr><td>#{{ $r->id }}</td><td>{{ $r->client->name ?? '-' }}</td><td>{{ $r->invoice->reference ?? '-' }}</td><td>{{ number_format($r->amount, 2) }} €</td><td>{{ $r->paid_at->format('d/m/Y') }}</td><td>
            <a href="{{ url('secretaire/recus/pdf/'.$r->id) }}" class="btn btn-info btn-sm">PDF</a>
            <a href="{{ url('secretaire/recus/delete/'.$r->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td></tr>@empty<tr><td colspan="6" class="text-center">Aucun reçu.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
