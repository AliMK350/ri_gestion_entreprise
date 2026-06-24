@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Devis</h1></div><div class="col-sm-6"><div class="float-sm-right"><a href="{{ url('secretaire/devis/add') }}" class="btn btn-primary">Nouveau devis</a></div></div></div></div></section>
    <section class="content"><div class="container-fluid">@include('_message')
        <div class="card"><div class="card-body p-0"><table class="table table-striped"><thead><tr><th>#</th><th>Client</th><th>Montant</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
        @forelse($getRecord as $q)<tr><td>#{{ $q->id }}</td><td>{{ $q->client->name ?? '-' }}</td><td>{{ number_format($q->total_amount, 2) }} €</td><td>{{ $q->status }}</td><td>
            <a href="{{ url('secretaire/devis/edit/'.$q->id) }}" class="btn btn-primary btn-sm">Éditer</a>
            <a href="{{ url('secretaire/devis/pdf/'.$q->id) }}" class="btn btn-info btn-sm">PDF</a>
            <a href="{{ url('secretaire/devis/delete/'.$q->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td></tr>@empty<tr><td colspan="5" class="text-center">Aucun devis.</td></tr>@endforelse
        </tbody></table></div></div>
    </div></section>
</div>
@endsection
