<div class="content-wrapper fade-in-up">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">{{ $header_title ?? 'Tableau de bord' }}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                @if(in_array($userType, [1, 4]))
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_employees ?? 0 }}</h3>
                            <p>Employés actifs</p>
                        </div>
                        <div class="icon"><i class="ion ion-person-stalker"></i></div>
                        @if($userType == 1)
                            <a href="{{ url('admin/employees/list') }}" class="small-box-footer">Gérer <i class="fas fa-arrow-circle-right"></i></a>
                        @else
                            <span class="small-box-footer">&nbsp;</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($userType == 1)
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $total_interns ?? 0 }}</h3>
                            <p>Stagiaires</p>
                        </div>
                        <div class="icon"><i class="ion ion-ios-people"></i></div>
                        <a href="{{ url('admin/interns/list') }}" class="small-box-footer">Gérer <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif

                @if(in_array($userType, [1, 2, 4]))
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_clients ?? 0 }}</h3>
                            <p>Clients actifs</p>
                        </div>
                        <div class="icon"><i class="ion ion-briefcase"></i></div>
                        @if($userType == 1)
                            <a href="{{ url('admin/clients/list') }}" class="small-box-footer">Gérer <i class="fas fa-arrow-circle-right"></i></a>
                        @elseif($userType == 2)
                            <a href="{{ url('secretaire/clients/list') }}" class="small-box-footer">Gérer <i class="fas fa-arrow-circle-right"></i></a>
                        @else
                            <a href="{{ url('gerant/clients/list') }}" class="small-box-footer">Gérer <i class="fas fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                @endif

                @if(in_array($userType, [1, 2, 4]))
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_quotes ?? 0 }}</h3>
                            <p>Devis</p>
                        </div>
                        <div class="icon"><i class="ion ion-compose"></i></div>
                        @if($userType == 2)
                            <a href="{{ url('secretaire/devis/list') }}" class="small-box-footer">Accéder <i class="fas fa-arrow-circle-right"></i></a>
                        @elseif($userType == 4)
                            <a href="{{ url('gerant/devis/list') }}" class="small-box-footer">Valider <i class="fas fa-arrow-circle-right"></i></a>
                        @else
                            <span class="small-box-footer">&nbsp;</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($userType == 1)
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $pending_leaves ?? 0 }}</h3>
                            <p>Congés en attente</p>
                        </div>
                        <div class="icon"><i class="ion ion-calendar"></i></div>
                        <a href="{{ url('admin/leaves/list') }}" class="small-box-footer">Traiter <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif

                @if($userType == 3)
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $my_absences ?? 0 }}</h3>
                            <p>Mes absences</p>
                        </div>
                        <div class="icon"><i class="ion ion-calendar"></i></div>
                        <a href="{{ url('employe/absences') }}" class="small-box-footer">Voir <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pending_leaves ?? 0 }}</h3>
                            <p>Congés en attente</p>
                        </div>
                        <div class="icon"><i class="ion ion-clock"></i></div>
                        <a href="{{ url('employe/leaves/create') }}" class="small-box-footer">Demander <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif

            </div>

            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-briefcase mr-1"></i>Vue générale</h3>
                        </div>
                        <div class="card-body">
                            <p>Bienvenue sur le système de gestion de l'entreprise.</p>
                            <ul class="list-group">
                                <li class="list-group-item">Rôle : <strong>{{ ['1' => 'Administrateur', '2' => 'Secrétaire', '3' => 'Employé', '4' => 'Gérant'][$userType] ?? 'Utilisateur' }}</strong></li>
                                @if(in_array($userType, [1, 4]))
                                    <li class="list-group-item">Employés actifs : <strong>{{ $total_employees ?? 0 }}</strong></li>
                                    <li class="list-group-item">Clients actifs : <strong>{{ $total_clients ?? 0 }}</strong></li>
                                @elseif($userType == 2)
                                    <li class="list-group-item">Clients : <strong>{{ $total_clients ?? 0 }}</strong></li>
                                    <li class="list-group-item">Factures : <strong>{{ $total_invoices ?? 0 }}</strong></li>
                                @elseif($userType == 3)
                                    <li class="list-group-item">Mes absences : <strong>{{ $my_absences ?? 0 }}</strong></li>
                                    <li class="list-group-item">Mes congés : <strong>{{ $my_leaves ?? 0 }}</strong></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-tasks mr-1"></i>Actions rapides</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @if($userType == 1)
                                    <a href="{{ url('admin/employees/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-users mr-2"></i>Gérer les employés</a>
                                    <a href="{{ url('admin/interns/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-graduate mr-2"></i>Gérer les stagiaires</a>
                                    <a href="{{ url('admin/leaves/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-umbrella-beach mr-2"></i>Valider les congés</a>
                                    <a href="{{ url('admin/clients/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-tie mr-2"></i>Gérer les clients</a>
                                @elseif($userType == 2)
                                    <a href="{{ url('secretaire/clients/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-users mr-2"></i>Gérer les clients</a>
                                    <a href="{{ url('secretaire/devis/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-file-invoice mr-2"></i>Gérer les devis</a>
                                    <a href="{{ url('secretaire/factures/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-file-invoice-dollar mr-2"></i>Gérer les factures</a>
                                    <a href="{{ url('secretaire/recus/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-receipt mr-2"></i>Gérer les reçus</a>
                                @elseif($userType == 3)
                                    <a href="{{ url('employe/profile') }}" class="list-group-item list-group-item-action"><i class="fas fa-user mr-2"></i>Mon profil</a>
                                    <a href="{{ url('employe/absences') }}" class="list-group-item list-group-item-action"><i class="fas fa-calendar-times mr-2"></i>Mes absences</a>
                                    <a href="{{ url('employe/leaves/create') }}" class="list-group-item list-group-item-action"><i class="fas fa-umbrella-beach mr-2"></i>Demander un congé</a>
                                    <a href="{{ url('employe/personnel') }}" class="list-group-item list-group-item-action"><i class="fas fa-id-card mr-2"></i>Annuaire personnel</a>
                                @elseif($userType == 4)
                                    <a href="{{ url('gerant/clients/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-users mr-2"></i>Gérer les clients</a>
                                    <a href="{{ url('gerant/devis/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-file-invoice mr-2"></i>Valider les devis</a>
                                    <a href="{{ url('gerant/factures/list') }}" class="list-group-item list-group-item-action"><i class="fas fa-file-invoice-dollar mr-2"></i>Valider les factures</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
