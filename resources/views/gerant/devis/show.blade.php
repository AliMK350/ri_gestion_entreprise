@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="m-0 text-dark"><i class="fas fa-file-invoice text-primary mr-2"></i>Détail du Devis</h1>
                    <small class="text-muted">{{ $getRecord->reference ?? ('DEV-'.$getRecord->id) }}</small>
                </div>
                <div>
                    <a href="{{ url('gerant/devis/list') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Retour</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')

            <div class="row">
                {{-- Infos générales --}}
                <div class="col-md-6">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle mr-1"></i>Informations du Devis</h3></div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless">
                                <tr><th style="width:40%">N° Devis</th><td class="font-weight-bold text-primary">{{ $getRecord->reference ?? ('DEV-'.$getRecord->id) }}</td></tr>
                                <tr><th>Date</th><td>{{ $getRecord->quote_date ? date('d/m/Y', strtotime($getRecord->quote_date)) : $getRecord->created_at->format('d/m/Y') }}</td></tr>
                                @if($getRecord->validity_date)
                                <tr><th>Validité</th><td>{{ $getRecord->validity_date }}</td></tr>
                                @endif
                                <tr><th>Statut</th><td>
                                    @if($getRecord->status == 'accepted')
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Accepté</span>
                                    @elseif($getRecord->status == 'sent')
                                        <span class="badge badge-info px-2 py-1"><i class="fas fa-paper-plane mr-1"></i>Envoyé</span>
                                    @elseif($getRecord->status == 'rejected')
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>Refusé</span>
                                    @else
                                        <span class="badge badge-secondary px-2 py-1"><i class="fas fa-pencil-alt mr-1"></i>Brouillon</span>
                                    @endif
                                </td></tr>
                                <tr><th>Vendeur</th><td>{{ $getRecord->seller->name ?? 'RI Communication' }}</td></tr>
                                @if($getRecord->payment_conditions)
                                <tr><th>Conditions de paiement</th><td>{{ $getRecord->payment_conditions }}</td></tr>
                                @endif
                                @if($getRecord->notes)
                                <tr><th>Notes</th><td>{{ $getRecord->notes }}</td></tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Infos client --}}
                <div class="col-md-6">
                    <div class="card card-outline card-info shadow-sm">
                        <div class="card-header"><h3 class="card-title"><i class="fas fa-user mr-1"></i>Client</h3></div>
                        <div class="card-body">
                            @if($getRecord->client)
                            <table class="table table-sm table-borderless">
                                <tr><th style="width:40%">Nom</th><td>{{ $getRecord->client->name }}</td></tr>
                                @if($getRecord->client->company_name)
                                <tr><th>Entreprise</th><td>{{ $getRecord->client->company_name }}</td></tr>
                                @endif
                                @if($getRecord->client->email)
                                <tr><th>Email</th><td>{{ $getRecord->client->email }}</td></tr>
                                @endif
                                @if($getRecord->client->phone)
                                <tr><th>Téléphone</th><td>{{ $getRecord->client->phone }}</td></tr>
                                @endif
                                @if($getRecord->client->address)
                                <tr><th>Adresse</th><td>{{ $getRecord->client->address }}</td></tr>
                                @endif
                            </table>
                            @else
                                <p class="text-muted">Client non trouvé.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lignes du devis --}}
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-list mr-1"></i>Lignes du Devis</h3></div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Désignation</th>
                                <th>Description</th>
                                <th class="text-center">Qté</th>
                                <th class="text-center">Unité</th>
                                <th class="text-right">P.U. HT</th>
                                <th class="text-center">TVA</th>
                                <th class="text-right">Total HT</th>
                                <th class="text-right">Total TTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getRecord->items as $item)
                                <tr>
                                    <td><strong>{{ $item->designation }}</strong></td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    <td class="text-center">{{ number_format($item->quantity, 2, ',', ' ') }}</td>
                                    <td class="text-center">{{ $item->unit ?? 'Unité' }}</td>
                                    <td class="text-right">{{ number_format($item->unit_price_ht, 2, ',', ' ') }} DH</td>
                                    <td class="text-center">{{ number_format($item->tva_rate, 0) }}%</td>
                                    <td class="text-right">{{ number_format($item->total_ht, 2, ',', ' ') }} DH</td>
                                    <td class="text-right">{{ number_format($item->total_ttc, 2, ',', ' ') }} DH</td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-3">Aucune ligne dans ce devis.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="6" class="text-right">Total HT :</th>
                                <th class="text-right">{{ number_format($getRecord->total_ht ?? $getRecord->total_amount, 2, ',', ' ') }} DH</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Total TVA :</th>
                                <th class="text-right">{{ number_format($getRecord->total_tva ?? 0, 2, ',', ' ') }} DH</th>
                                <th></th>
                            </tr>
                            <tr class="table-success">
                                <th colspan="6" class="text-right">Total TTC :</th>
                                <th class="text-right font-weight-bold text-success" colspan="2">{{ number_format($getRecord->total_ttc ?? $getRecord->total_amount, 2, ',', ' ') }} DH</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-wrap gap-2">
                    @if(in_array($getRecord->status, ['draft','sent']))
                        <form method="post" action="{{ url('gerant/devis/validate/'.$getRecord->id) }}" class="d-inline mr-2">
                            @csrf<input type="hidden" name="status" value="accepted">
                            <button class="btn btn-success"><i class="fas fa-check mr-1"></i>Valider ce devis</button>
                        </form>
                        <form method="post" action="{{ url('gerant/devis/validate/'.$getRecord->id) }}" class="d-inline mr-2">
                            @csrf<input type="hidden" name="status" value="rejected">
                            <button class="btn btn-warning"><i class="fas fa-ban mr-1"></i>Refuser ce devis</button>
                        </form>
                    @endif
                    <a href="{{ url('gerant/devis/delete/'.$getRecord->id) }}" class="btn btn-danger mr-2" onclick="return confirm('Voulez-vous vraiment supprimer ce devis ?')">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </a>
                    <a href="{{ url('gerant/devis/list') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Retour à la liste
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
