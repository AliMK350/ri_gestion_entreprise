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
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_students }}</h3>
                            <p>Employés actifs</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_teachers }}</h3>
                            <p>Secrétaires actives</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people-outline"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_subjects }}</h3>
                            <p>Missions / Projets</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-compose"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_clients }}</h3>
                            <p>Clients actifs</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-briefcase mr-1"></i>Vue générale</h3>
                        </div>
                        <div class="card-body">
                            <p>Bienvenue sur l’interface d'entreprise. Cette page vous présente les chiffres clés de votre établissement et les dernières informations partagées.</p>
                            <ul class="list-group">
                                <li class="list-group-item">Annonces actives : <strong>{{ $announcements->count() }}</strong></li>
                                <li class="list-group-item">Séances programmées à venir : <strong>{{ $upcoming_sessions }}</strong></li>
                                <li class="list-group-item">Type d’utilisateur : <strong>{{ ['1' => 'Administrateur', '2' => 'Secrétaire', '3' => 'Employé', '4' => 'Gérant'][$userType] ?? 'Utilisateur' }}</strong></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i>Prochaines séances</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($user_schedule) && $user_schedule->count())
                                <ul class="list-group">
                                    @foreach($user_schedule as $session)
                                        <li class="list-group-item">
                                            <strong>{{ \Illuminate\Support\Carbon::parse($session->date_seance)->format('d/m/Y') }}</strong>
                                            <div>{{ $session->subject_name }} - Salle {{ $session->salle }}</div>
                                            <small class="text-muted">{{ $userType == 2 ? 'Département ' . $session->class_id : ($userType == 3 ? 'Secrétaire ' . $session->teacher_id : '') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Aucune séance programmée pour l’instant.</p>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bullhorn mr-1"></i>Dernières annonces</h3>
                        </div>
                        <div class="card-body">
                            @forelse($announcements as $announcement)
                                <div class="mb-3">
                                    <h5>{{ $announcement->title }}</h5>
                                    <p>{{ \Illuminate\Support\Str::limit($announcement->contenu, 120) }}</p>
                                    <small class="text-muted">{{ optional($announcement->created_at)->format('d/m/Y') }}</small>
                                </div>
                            @empty
                                <p>Aucune annonce active pour le moment.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-tasks mr-1"></i>Actions rapides</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">Consulter les plannings de travail</div>
                                <div class="list-group-item">Voir les annonces récentes</div>
                                <div class="list-group-item">Rechercher une mission ou un département</div>
                                <div class="list-group-item">Gérer les employés et les secrétaires</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
