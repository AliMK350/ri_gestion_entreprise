<div class="content-wrapper ri-dashboard">

    {{-- ============================================================
         HERO HEADER — greeting + heure dynamique
    ============================================================ --}}
    <div class="ri-hero">
        <div class="ri-hero-bg"></div>
        <div class="ri-hero-content container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <p class="ri-hero-eyebrow">
                        <span id="ri-time-greeting"></span> &nbsp;·&nbsp;
                        <span id="ri-clock"></span>
                    </p>
                    <h1 class="ri-hero-title">
                        {{ Auth::user()->name }}
                    </h1>
                    <p class="ri-hero-sub">
                        @php
                            $roleLabel = ['1' => 'Administrateur', '2' => 'Secrétaire', '3' => 'Employé', '4' => 'Gérant'][$userType] ?? 'Utilisateur';
                        @endphp
                        <span class="ri-role-badge">{{ $roleLabel }}</span>
                        &nbsp;— Ri Communication
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
                    <img src="{{ url('/dist/img/ri-logo.png') }}" alt="Ri Communication" class="ri-hero-logo">
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    {{-- ============================================================
         STAT CARDS
    ============================================================ --}}
    <section class="content ri-stats-section">
        <div class="container-fluid">
            <div class="row">

                @if(in_array($userType, [1, 4]))
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-blue">
                        <div class="ri-stat-icon"><i class="fas fa-users"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $total_employees ?? 0 }}</div>
                            <div class="ri-stat-label">Employés actifs</div>
                        </div>
                        @if($userType == 1)
                        <a href="{{ url('admin/employees/list') }}" class="ri-stat-link">
                            Gérer <i class="fas fa-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if($userType == 1)
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-navy">
                        <div class="ri-stat-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $total_interns ?? 0 }}</div>
                            <div class="ri-stat-label">Stagiaires</div>
                        </div>
                        <a href="{{ url('admin/interns/list') }}" class="ri-stat-link">
                            Gérer <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endif

                @if(in_array($userType, [1, 2, 4]))
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-teal">
                        <div class="ri-stat-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $total_clients ?? 0 }}</div>
                            <div class="ri-stat-label">Clients actifs</div>
                        </div>
                        @if($userType == 1)
                        <a href="{{ url('admin/clients/list') }}" class="ri-stat-link">Gérer <i class="fas fa-arrow-right"></i></a>
                        @elseif($userType == 2)
                        <a href="{{ url('secretaire/clients/list') }}" class="ri-stat-link">Gérer <i class="fas fa-arrow-right"></i></a>
                        @else
                        <a href="{{ url('gerant/clients/list') }}" class="ri-stat-link">Gérer <i class="fas fa-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
                @endif

                @if(in_array($userType, [1, 2, 4]))
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-cyan">
                        <div class="ri-stat-icon"><i class="fas fa-file-invoice"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $total_quotes ?? 0 }}</div>
                            <div class="ri-stat-label">Devis</div>
                        </div>
                        @if($userType == 2)
                        <a href="{{ url('secretaire/devis/list') }}" class="ri-stat-link">Accéder <i class="fas fa-arrow-right"></i></a>
                        @elseif($userType == 4)
                        <a href="{{ url('gerant/devis/list') }}" class="ri-stat-link">Valider <i class="fas fa-arrow-right"></i></a>
                        @else
                        <span class="ri-stat-link ri-stat-link-muted">&nbsp;</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($userType == 1)
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-orange">
                        <div class="ri-stat-icon"><i class="fas fa-umbrella-beach"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $pending_leaves ?? 0 }}</div>
                            <div class="ri-stat-label">Congés en attente</div>
                        </div>
                        <a href="{{ url('admin/leaves/list') }}" class="ri-stat-link">
                            Traiter <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endif

                @if($userType == 3)
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-blue">
                        <div class="ri-stat-icon"><i class="fas fa-calendar-times"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $my_absences ?? 0 }}</div>
                            <div class="ri-stat-label">Mes absences</div>
                        </div>
                        <a href="{{ url('employe/absences') }}" class="ri-stat-link">Voir <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 mb-4">
                    <div class="ri-stat-card ri-stat-orange">
                        <div class="ri-stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="ri-stat-body">
                            <div class="ri-stat-value">{{ $pending_leaves ?? 0 }}</div>
                            <div class="ri-stat-label">Congés en attente</div>
                        </div>
                        <a href="{{ url('employe/leaves/create') }}" class="ri-stat-link">Demander <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif

            </div>

            {{-- ============================================================
                 BOTTOM ROW — Vue générale + Actions rapides
            ============================================================ --}}
            <div class="row mt-2">

                {{-- Vue générale --}}
                <div class="col-lg-5 mb-4">
                    <div class="ri-panel">
                        <div class="ri-panel-header">
                            <i class="fas fa-chart-pie ri-panel-icon"></i>
                            <span>Vue générale</span>
                        </div>
                        <div class="ri-panel-body">
                            <div class="ri-info-row">
                                <span class="ri-info-key">Rôle</span>
                                <span class="ri-info-val ri-role-pill">{{ $roleLabel }}</span>
                            </div>
                            @if(in_array($userType, [1, 4]))
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-users ri-info-ico"></i> Employés actifs</span>
                                <span class="ri-info-val ri-info-num">{{ $total_employees ?? 0 }}</span>
                            </div>
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-user-tie ri-info-ico"></i> Clients actifs</span>
                                <span class="ri-info-val ri-info-num">{{ $total_clients ?? 0 }}</span>
                            </div>
                            @elseif($userType == 2)
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-user-tie ri-info-ico"></i> Clients</span>
                                <span class="ri-info-val ri-info-num">{{ $total_clients ?? 0 }}</span>
                            </div>
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-file-invoice-dollar ri-info-ico"></i> Factures</span>
                                <span class="ri-info-val ri-info-num">{{ $total_invoices ?? 0 }}</span>
                            </div>
                            @elseif($userType == 3)
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-calendar-times ri-info-ico"></i> Mes absences</span>
                                <span class="ri-info-val ri-info-num">{{ $my_absences ?? 0 }}</span>
                            </div>
                            <div class="ri-info-row">
                                <span class="ri-info-key"><i class="fas fa-umbrella-beach ri-info-ico"></i> Mes congés</span>
                                <span class="ri-info-val ri-info-num">{{ $my_leaves ?? 0 }}</span>
                            </div>
                            @endif
                            <div class="ri-info-row ri-info-date">
                                <span class="ri-info-key"><i class="fas fa-calendar ri-info-ico"></i> Aujourd'hui</span>
                                <span class="ri-info-val" id="ri-date-display"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions rapides --}}
                <div class="col-lg-7 mb-4">
                    <div class="ri-panel">
                        <div class="ri-panel-header">
                            <i class="fas fa-bolt ri-panel-icon"></i>
                            <span>Actions rapides</span>
                        </div>
                        <div class="ri-panel-body ri-actions-grid">
                            @if($userType == 1)
                                <a href="{{ url('admin/employees/list') }}" class="ri-action-btn">
                                    <i class="fas fa-users"></i><span>Employés</span>
                                </a>
                                <a href="{{ url('admin/interns/list') }}" class="ri-action-btn">
                                    <i class="fas fa-user-graduate"></i><span>Stagiaires</span>
                                </a>
                                <a href="{{ url('admin/leaves/list') }}" class="ri-action-btn">
                                    <i class="fas fa-umbrella-beach"></i><span>Congés</span>
                                </a>
                                <a href="{{ url('admin/clients/list') }}" class="ri-action-btn">
                                    <i class="fas fa-user-tie"></i><span>Clients</span>
                                </a>
                                <a href="{{ url('admin/absences/list') }}" class="ri-action-btn">
                                    <i class="fas fa-calendar-times"></i><span>Absences</span>
                                </a>
                                <a href="{{ url('admin/personnel') }}" class="ri-action-btn">
                                    <i class="fas fa-id-card"></i><span>Personnel</span>
                                </a>
                            @elseif($userType == 2)
                                <a href="{{ url('secretaire/clients/list') }}" class="ri-action-btn">
                                    <i class="fas fa-users"></i><span>Clients</span>
                                </a>
                                <a href="{{ url('secretaire/devis/list') }}" class="ri-action-btn">
                                    <i class="fas fa-file-invoice"></i><span>Devis</span>
                                </a>
                                <a href="{{ url('secretaire/factures/list') }}" class="ri-action-btn">
                                    <i class="fas fa-file-invoice-dollar"></i><span>Factures</span>
                                </a>
                                <a href="{{ url('secretaire/recus/list') }}" class="ri-action-btn">
                                    <i class="fas fa-receipt"></i><span>Reçus</span>
                                </a>
                            @elseif($userType == 3)
                                <a href="{{ url('employe/profile') }}" class="ri-action-btn">
                                    <i class="fas fa-user"></i><span>Mon profil</span>
                                </a>
                                <a href="{{ url('employe/absences') }}" class="ri-action-btn">
                                    <i class="fas fa-calendar-times"></i><span>Absences</span>
                                </a>
                                <a href="{{ url('employe/leaves/create') }}" class="ri-action-btn">
                                    <i class="fas fa-umbrella-beach"></i><span>Demander congé</span>
                                </a>
                                <a href="{{ url('employe/personnel') }}" class="ri-action-btn">
                                    <i class="fas fa-id-card"></i><span>Annuaire</span>
                                </a>
                            @elseif($userType == 4)
                                <a href="{{ url('gerant/clients/list') }}" class="ri-action-btn">
                                    <i class="fas fa-users"></i><span>Clients</span>
                                </a>
                                <a href="{{ url('gerant/devis/list') }}" class="ri-action-btn">
                                    <i class="fas fa-file-invoice"></i><span>Devis</span>
                                </a>
                                <a href="{{ url('gerant/factures/list') }}" class="ri-action-btn">
                                    <i class="fas fa-file-invoice-dollar"></i><span>Factures</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@push('dashboard_styles')
<style>
/* ======================================================
   RI DASHBOARD STYLES
   ====================================================== */

/* --- Hero --- */
.ri-hero {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0090CC 0%, #00ADEF 50%, #33C5F5 100%);
    padding: 2.5rem 0 2rem;
    margin-bottom: 0;
}

/* Polygonal wire overlay — CSS-only, no image needed */
.ri-hero-bg {
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 20% 80%, rgba(255,255,255,0.07) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 45%),
        radial-gradient(circle at 60% 90%, rgba(0,0,0,0.08) 0%, transparent 40%);
    /* SVG polygon mesh as data URI */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='300' opacity='0.15'%3E%3Cpolygon points='0,300 100,180 200,240 300,120 400,200 500,80 600,160 600,300' fill='none' stroke='white' stroke-width='1'/%3E%3Cpolygon points='0,300 80,200 160,260 280,140 380,220 480,100 600,180 600,300' fill='none' stroke='white' stroke-width='0.5'/%3E%3Cline x1='100' y1='180' x2='200' y2='240' stroke='white' stroke-width='0.5'/%3E%3Cline x1='200' y1='240' x2='300' y2='120' stroke='white' stroke-width='0.5'/%3E%3Cline x1='300' y1='120' x2='400' y2='200' stroke='white' stroke-width='0.5'/%3E%3Cline x1='400' y1='200' x2='500' y2='80' stroke='white' stroke-width='0.5'/%3E%3Ccircle cx='100' cy='180' r='3' fill='white'/%3E%3Ccircle cx='300' cy='120' r='3' fill='white'/%3E%3Ccircle cx='500' cy='80' r='3' fill='white'/%3E%3Ccircle cx='200' cy='240' r='2' fill='white'/%3E%3Ccircle cx='400' cy='200' r='2' fill='white'/%3E%3C/svg%3E"),
        radial-gradient(circle at 15% 85%, rgba(255,255,255,0.06) 0%, transparent 55%),
        radial-gradient(circle at 85% 15%, rgba(0,0,0,0.06) 0%, transparent 50%);
    background-size: 600px 300px, 100% 100%, 100% 100%;
    background-repeat: repeat-x, no-repeat, no-repeat;
    background-position: center bottom, center, center;
}

.ri-hero-content {
    position: relative;
    z-index: 2;
    padding: 0 2rem;
}

.ri-hero-eyebrow {
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.75);
    text-transform: uppercase;
    margin-bottom: 0.4rem;
}

.ri-hero-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 2rem;
    color: #fff;
    margin: 0 0 0.5rem;
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.ri-hero-sub {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.85);
    font-weight: 500;
    margin: 0;
}

.ri-role-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 2px 10px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.ri-hero-logo {
    max-height: 70px;
    width: auto;
    filter: brightness(0) invert(1);
    opacity: 0.85;
}

/* Dark mode hero */
[data-theme="dark"] .ri-hero {
    background: linear-gradient(135deg, #00395A 0%, #005580 50%, #0077AA 100%);
}

/* --- Stats section --- */
.ri-stats-section {
    padding-top: 2rem;
}

/* --- Stat cards --- */
.ri-stat-card {
    border-radius: 14px;
    padding: 1.4rem 1.2rem 0;
    position: relative;
    overflow: hidden;
    min-height: 130px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0,0,0,0.10);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: default;
}

.ri-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.16);
}

/* Color variants */
.ri-stat-blue  { background: linear-gradient(135deg, #00ADEF, #0090CC); }
.ri-stat-navy  { background: linear-gradient(135deg, #1A5F8A, #0D3D5C); }
.ri-stat-teal  { background: linear-gradient(135deg, #00C2A8, #009688); }
.ri-stat-cyan  { background: linear-gradient(135deg, #33C5F5, #00ADEF); }
.ri-stat-orange { background: linear-gradient(135deg, #F59E0B, #D97706); }

.ri-stat-icon {
    position: absolute;
    top: 1rem; right: 1rem;
    font-size: 2.8rem;
    color: rgba(255,255,255,0.18);
    line-height: 1;
}

.ri-stat-body {
    flex: 1;
}

.ri-stat-value {
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 2.4rem;
    color: #fff;
    line-height: 1;
    margin-bottom: 0.3rem;
}

.ri-stat-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: rgba(255,255,255,0.80);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.ri-stat-link {
    display: block;
    margin: 0.8rem -1.2rem 0;
    padding: 0.45rem 1.2rem;
    background: rgba(0,0,0,0.12);
    color: rgba(255,255,255,0.90) !important;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none !important;
    border-top: 1px solid rgba(255,255,255,0.12);
    transition: background 0.2s;
    letter-spacing: 0.03em;
}

.ri-stat-link:hover {
    background: rgba(0,0,0,0.22);
    color: #fff !important;
}

.ri-stat-link-muted {
    display: block;
    margin: 0.8rem -1.2rem 0;
    padding: 0.45rem 1.2rem;
    background: rgba(0,0,0,0.08);
    border-top: 1px solid rgba(255,255,255,0.08);
}

/* --- Panels --- */
.ri-panel {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 14px rgba(0,0,0,0.07);
    overflow: hidden;
    height: 100%;
}

[data-theme="dark"] .ri-panel {
    background: #1A1D23;
    box-shadow: 0 2px 14px rgba(0,0,0,0.35);
    border: 1px solid #2A3040;
}

.ri-panel-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 1rem 1.25rem;
    border-bottom: 2px solid #E8F7FD;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 0.88rem;
    color: #111;
}

[data-theme="dark"] .ri-panel-header {
    border-bottom-color: #2A3040;
    color: #E8EAF0;
}

.ri-panel-icon {
    color: #00ADEF;
    font-size: 0.95rem;
}

.ri-panel-body {
    padding: 1.1rem 1.25rem;
}

/* Info rows */
.ri-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid #F0F4F8;
    font-size: 0.84rem;
}

.ri-info-row:last-child {
    border-bottom: none;
}

[data-theme="dark"] .ri-info-row {
    border-bottom-color: #252830;
}

.ri-info-key {
    color: #666;
    font-weight: 500;
}

[data-theme="dark"] .ri-info-key {
    color: #9AA3B2;
}

.ri-info-ico {
    color: #00ADEF;
    width: 16px;
    margin-right: 6px;
}

.ri-info-num {
    font-weight: 800;
    font-size: 1rem;
    color: #00ADEF;
}

.ri-role-pill {
    background: #E8F7FD;
    color: #0090CC;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

[data-theme="dark"] .ri-role-pill {
    background: #0D2030;
    color: #33C5F5;
}

/* --- Actions grid --- */
.ri-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
}

.ri-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 0.5rem;
    border-radius: 10px;
    background: #F5F7FA;
    color: #4A4A4A !important;
    text-decoration: none !important;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.02em;
    border: 1.5px solid transparent;
    transition: all 0.2s ease;
}

.ri-action-btn i {
    font-size: 1.3rem;
    color: #00ADEF;
    transition: transform 0.2s ease;
}

.ri-action-btn:hover {
    background: #E8F7FD;
    border-color: #00ADEF;
    color: #0090CC !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 173, 239, 0.18);
}

.ri-action-btn:hover i {
    transform: scale(1.15);
}

[data-theme="dark"] .ri-action-btn {
    background: #252830;
    color: #9AA3B2 !important;
    border-color: #2A3040;
}

[data-theme="dark"] .ri-action-btn:hover {
    background: #0D2030;
    border-color: #00ADEF;
    color: #E8EAF0 !important;
}

/* --- Content wrapper bg --- */
.ri-dashboard {
    background: #F5F7FA !important;
}

[data-theme="dark"] .ri-dashboard {
    background: #13151A !important;
}
</style>
@endpush

@push('dashboard_scripts')
<script>
(function() {
    // Live clock + greeting
    function pad(n) { return n < 10 ? '0' + n : n; }
    function updateClock() {
        var now = new Date();
        var h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();

        var greeting = h < 12 ? 'Bonjour' : h < 18 ? 'Bon après-midi' : 'Bonsoir';

        var clockEl = document.getElementById('ri-clock');
        var greetEl = document.getElementById('ri-time-greeting');
        if (clockEl) clockEl.textContent = pad(h) + ':' + pad(m) + ':' + pad(s);
        if (greetEl) greetEl.textContent = greeting;

        var dateEl = document.getElementById('ri-date-display');
        if (dateEl) {
            var days   = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
            var months = ['jan.','fév.','mar.','avr.','mai','juin','juil.','août','sep.','oct.','nov.','déc.'];
            dateEl.textContent = days[now.getDay()] + ' ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
        }
    }
    updateClock();
    setInterval(updateClock, 1000);
})();
</script>
@endpush
