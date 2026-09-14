@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="m-0 text-dark"><i class="fas fa-file-invoice text-primary mr-2"></i>Gestion des Devis</h1>
                    <small class="text-muted">Consultez, éditez et téléchargez vos devis</small>
                </div>
                <div>
                    <a href="{{ url('secretaire/devis/add') }}" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-plus mr-1"></i> Nouveau devis</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            @include('_message')
            @include('secretaire._quicknav')
            <form method="get" class="card card-body mb-3">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4 mb-2"><label for="search">Recherche</label><input id="search" type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Référence, client ou vendeur"></div>
                    <div class="form-group col-md-3 mb-2"><label for="status">Statut</label><select id="status" name="status" class="form-control"><option value="">Tous les statuts</option><option value="draft" @selected(request('status') === 'draft')>Brouillon</option><option value="sent" @selected(request('status') === 'sent')>Envoyé</option><option value="accepted" @selected(request('status') === 'accepted')>Accepté</option><option value="rejected" @selected(request('status') === 'rejected')>Refusé</option></select></div>
                    <div class="form-group col-md-2 mb-2"><label for="date_from">Du</label><input id="date_from" type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"></div>
                    <div class="form-group col-md-2 mb-2"><label for="date_to">Au</label><input id="date_to" type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"></div>
                    <div class="form-group col-md-1 mb-2"><button class="btn btn-primary btn-block" title="Filtrer"><i class="fas fa-search"></i></button></div>
                </div>
                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))<a href="{{ url(request()->path()) }}" class="small">Réinitialiser les filtres</a>@endif
            </form>
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>N° Devis</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Vendeur</th>
                                <th class="text-right">Montant HT</th>
                                <th class="text-right">Total TTC</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getRecord as $q)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $q->reference ?? ('DEV-'.$q->id) }}</td>
                                    <td>{{ $q->quote_date ? date('d/m/Y', strtotime($q->quote_date)) : $q->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $q->client->name ?? '-' }}</strong>
                                        @if(!empty($q->client->company_name))
                                            <br><small class="text-muted">{{ $q->client->company_name }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $q->seller->name ?? 'RI Communication' }}</td>
                                    <td class="text-right font-weight-600">{{ number_format($q->total_ht ?? $q->total_amount, 2, ',', ' ') }} DH</td>
                                    <td class="text-right font-weight-bold text-success">{{ number_format($q->total_ttc ?? $q->total_amount, 2, ',', ' ') }} DH</td>
                                    <td class="text-center">
                                        @if($q->status == 'accepted')
                                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Accepté</span>
                                        @elseif($q->status == 'sent')
                                            <span class="badge badge-info px-2 py-1"><i class="fas fa-paper-plane mr-1"></i>Envoyé</span>
                                        @elseif($q->status == 'rejected')
                                            <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>Refusé</span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1"><i class="fas fa-pencil-alt mr-1"></i>Brouillon</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ url('secretaire/devis/edit/'.$q->id) }}" class="btn btn-sm btn-outline-primary" title="Éditer le devis"><i class="fas fa-edit"></i></a>
                                            <a href="{{ url('secretaire/devis/pdf/'.$q->id) }}" class="btn btn-sm btn-outline-info" title="Télécharger PDF" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                            <a href="{{ url('secretaire/devis/delete/'.$q->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce devis ?')" title="Supprimer"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                        Aucun devis enregistré pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">{{ $getRecord->links() }}</div>
        </div>
    </section>
</div>
@endsection
