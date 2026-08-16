{{-- Raccourcis de navigation rapide -- Secrétaire --}}
<div class="mb-3">
    <div class="row">
        <div class="col-12">
            <div class="card card-body py-2 px-3 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9f0fb 100%); border-left: 4px solid #007bff;">
                <div class="d-flex flex-wrap align-items-center gap-2" style="gap: .5rem;">
                    <small class="text-muted font-weight-bold mr-2" style="white-space:nowrap;"><i class="fas fa-bolt text-warning mr-1"></i>Accès rapide :</small>

                    {{-- Clients --}}
                    <a href="{{ url('secretaire/clients/add') }}"
                       class="btn btn-sm btn-outline-secondary{{ request()->is('secretaire/clients/add') ? ' active' : '' }}"
                       title="Ajouter un nouveau client">
                        <i class="fas fa-user-plus mr-1"></i>Nouveau client
                    </a>
                    <a href="{{ url('secretaire/clients/list') }}"
                       class="btn btn-sm btn-outline-secondary{{ request()->is('secretaire/clients*') && !request()->is('secretaire/clients/add') ? ' active' : '' }}"
                       title="Liste des clients">
                        <i class="fas fa-users mr-1"></i>Clients
                    </a>

                    <span class="text-muted mx-1">|</span>

                    {{-- Devis --}}
                    <a href="{{ url('secretaire/devis/add') }}"
                       class="btn btn-sm btn-outline-primary{{ request()->is('secretaire/devis/add') ? ' active' : '' }}"
                       title="Créer un nouveau devis">
                        <i class="fas fa-file-invoice mr-1"></i>Nouveau devis
                    </a>
                    <a href="{{ url('secretaire/devis/list') }}"
                       class="btn btn-sm btn-outline-primary{{ request()->is('secretaire/devis*') && !request()->is('secretaire/devis/add') ? ' active' : '' }}"
                       title="Liste des devis">
                        <i class="fas fa-list mr-1"></i>Devis
                    </a>

                    <span class="text-muted mx-1">|</span>

                    {{-- Factures --}}
                    <a href="{{ url('secretaire/factures/add') }}"
                       class="btn btn-sm btn-outline-success{{ request()->is('secretaire/factures/add') ? ' active' : '' }}"
                       title="Créer une nouvelle facture">
                        <i class="fas fa-file-alt mr-1"></i>Nouvelle facture
                    </a>
                    <a href="{{ url('secretaire/factures/list') }}"
                       class="btn btn-sm btn-outline-success{{ request()->is('secretaire/factures*') && !request()->is('secretaire/factures/add') ? ' active' : '' }}"
                       title="Liste des factures">
                        <i class="fas fa-list mr-1"></i>Factures
                    </a>

                    <span class="text-muted mx-1">|</span>

                    {{-- Reçus --}}
                    <a href="{{ url('secretaire/recus/add') }}"
                       class="btn btn-sm btn-outline-info{{ request()->is('secretaire/recus/add') ? ' active' : '' }}"
                       title="Créer un nouveau reçu">
                        <i class="fas fa-receipt mr-1"></i>Nouveau reçu
                    </a>
                    <a href="{{ url('secretaire/recus/list') }}"
                       class="btn btn-sm btn-outline-info{{ request()->is('secretaire/recus*') && !request()->is('secretaire/recus/add') ? ' active' : '' }}"
                       title="Liste des reçus">
                        <i class="fas fa-list mr-1"></i>Reçus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
