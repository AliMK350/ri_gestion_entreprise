@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="m-0 text-dark"><i class="fas fa-file-alt text-primary mr-2"></i>Détail de la Facture</h1>
                    <small class="text-muted">{{ $getRecord->reference }}</small>
                </div>
                <div>
                    <a href="{{ url('admin/factures/list') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Retour</a>
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
                        <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle mr-1"></i>Informations de la Facture</h3></div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless">
                                <tr><th style="width:40%">Référence</th><td class="font-weight-bold text-primary">{{ $getRecord->reference }}</td></tr>
                                <tr><th>Date d'émission</th><td>{{ $getRecord->issued_at ? date('d/m/Y', strtotime($getRecord->issued_at)) : '-' }}</td></tr>
                                @if($getRecord->due_at)
                                <tr><th>Date d'échéance</th><td>{{ date('d/m/Y', strtotime($getRecord->due_at)) }}</td></tr>
                                @endif
                                <tr><th>Montant</th><td class="font-weight-bold text-success">{{ number_format($getRecord->amount, 2, ',', ' ') }} DH</td></tr>
                                <tr><th>Statut</th><td>
                                    @if($getRecord->status == 'validated')
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Validée</span>
                                    @elseif($getRecord->status == 'sent')
                                        <span class="badge badge-info px-2 py-1"><i class="fas fa-paper-plane mr-1"></i>Envoyée</span>
                                    @elseif($getRecord->status == 'cancelled')
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>Annulée</span>
                                    @else
                                        <span class="badge badge-secondary px-2 py-1"><i class="fas fa-pencil-alt mr-1"></i>Brouillon</span>
                                    @endif
                                </td></tr>
                                <tr><th>Paiement</th><td>
                                    @if($getRecord->paid)
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i>Payée</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i>Non payée</span>
                                    @endif
                                </td></tr>
                                @if($getRecord->details)
                                <tr><th>Détails</th><td>{{ $getRecord->details }}</td></tr>
                                @endif
                                @if($getRecord->quote)
                                <tr><th>Devis lié</th><td>{{ $getRecord->quote->reference ?? ('DEV-'.$getRecord->quote_id) }}</td></tr>
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

            {{-- Actions --}}
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-wrap gap-2">
                    @if(in_array($getRecord->status, ['draft','sent']))
                        <form method="post" action="{{ url('admin/factures/validate/'.$getRecord->id) }}" class="d-inline mr-2">
                            @csrf<input type="hidden" name="status" value="validated">
                            <button class="btn btn-success"><i class="fas fa-check mr-1"></i>Valider la facture</button>
                        </form>
                        <form method="post" action="{{ url('admin/factures/validate/'.$getRecord->id) }}" class="d-inline mr-2">
                            @csrf<input type="hidden" name="status" value="cancelled">
                            <button class="btn btn-warning"><i class="fas fa-ban mr-1"></i>Annuler la facture</button>
                        </form>
                    @endif
                    <a href="{{ url('admin/factures/delete/'.$getRecord->id) }}" class="btn btn-danger mr-2" onclick="return confirm('Voulez-vous vraiment supprimer cette facture ?')">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </a>
                    <a href="{{ url('admin/factures/list') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Retour à la liste
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
