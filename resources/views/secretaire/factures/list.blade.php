@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="m-0 text-dark"><i class="fas fa-file-alt text-success mr-2"></i>Gestion des Factures</h1>
                    <small class="text-muted">Consultez, éditez et gérez vos factures</small>
                </div>
                <div>
                    <a href="{{ url('secretaire/factures/add') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-plus mr-1"></i> Nouvelle facture</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            @include('secretaire._quicknav')
            <div class="card card-outline card-success shadow-sm">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Réf.</th>
                                <th>Client</th>
                                <th class="text-right">Montant</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getRecord as $f)
                                <tr>
                                    <td class="font-weight-bold text-success">{{ $f->reference }}</td>
                                    <td>
                                        <strong>{{ $f->client->name ?? '-' }}</strong>
                                        @if(!empty($f->client->company_name))
                                            <br><small class="text-muted">{{ $f->client->company_name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-right font-weight-bold">{{ number_format($f->amount, 2, ',', ' ') }} DH</td>
                                    <td class="text-center">
                                        @if($f->status == 'validated')
                                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Validée</span>
                                        @elseif($f->status == 'sent')
                                            <span class="badge badge-info px-2 py-1"><i class="fas fa-paper-plane mr-1"></i>Envoyée</span>
                                        @elseif($f->status == 'cancelled')
                                            <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>Annulée</span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1"><i class="fas fa-pencil-alt mr-1"></i>Brouillon</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ url('secretaire/factures/edit/'.$f->id) }}" class="btn btn-sm btn-outline-primary" title="Éditer"><i class="fas fa-edit"></i></a>
                                            <a href="{{ url('secretaire/factures/pdf/'.$f->id) }}" class="btn btn-sm btn-outline-info" title="Télécharger PDF" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                            <a href="{{ url('secretaire/factures/delete/'.$f->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette facture ?')" title="Supprimer"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                        Aucune facture enregistrée pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
