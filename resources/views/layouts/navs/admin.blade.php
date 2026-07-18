{{-- ===================== ADMIN NAV ===================== --}}

{{-- === Section : Administration === --}}
<li class="nav-header" style="color:#00ADEF; font-size:0.62rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; padding: 6px 1rem 2px;">
    <i class="fas fa-shield-alt mr-1"></i> Administration
</li>

<li class="nav-item">
    <a href="{{ url('admin/dashboard') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/admin/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'admin') active @endif">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Utilisateurs Admin</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/employees/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'employees') active @endif">
        <i class="nav-icon fas fa-users"></i>
        <p>Employés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/interns/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'interns') active @endif">
        <i class="nav-icon fas fa-user-graduate"></i>
        <p>Stagiaires</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/absences/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'absences') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Absences</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/leaves/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'leaves') active @endif">
        <i class="nav-icon fas fa-umbrella-beach"></i>
        <p>Congés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/jours-feries/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'jours-feries') active @endif">
        <i class="nav-icon fas fa-calendar-day"></i>
        <p>Jours Fériés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/personnel') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'personnel') active @endif">
        <i class="nav-icon fas fa-id-card"></i>
        <p>Consultation Personnel</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/clients/list') }}" class="nav-link @if (Request::segment(1) == 'admin' && Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>

{{-- === Section : Secrétaire === --}}
<li class="nav-header" style="color:#9b59b6; font-size:0.62rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; padding: 10px 1rem 2px; border-top: 1px solid rgba(0,0,0,0.07); margin-top:6px;">
    <i class="fas fa-user-edit mr-1"></i> Secrétaire
</li>

<li class="nav-item">
    <a href="{{ url('secretaire/dashboard') }}" class="nav-link @if (Request::segment(1) == 'secretaire' && Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard Secrétaire</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/clients/list') }}" class="nav-link @if (Request::segment(1) == 'secretaire' && Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/devis/list') }}" class="nav-link @if (Request::segment(1) == 'secretaire' && Request::segment(2) == 'devis') active @endif">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Devis</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/factures/list') }}" class="nav-link @if (Request::segment(1) == 'secretaire' && Request::segment(2) == 'factures') active @endif">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Factures</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/recus/list') }}" class="nav-link @if (Request::segment(1) == 'secretaire' && Request::segment(2) == 'recus') active @endif">
        <i class="nav-icon fas fa-receipt"></i>
        <p>Reçus</p>
    </a>
</li>

{{-- === Section : Gérant === --}}
<li class="nav-header" style="color:#e67e22; font-size:0.62rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; padding: 10px 1rem 2px; border-top: 1px solid rgba(0,0,0,0.07); margin-top:6px;">
    <i class="fas fa-briefcase mr-1"></i> Gérant
</li>

<li class="nav-item">
    <a href="{{ url('gerant/dashboard') }}" class="nav-link @if (Request::segment(1) == 'gerant' && Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard Gérant</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/clients/list') }}" class="nav-link @if (Request::segment(1) == 'gerant' && Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/devis/list') }}" class="nav-link @if (Request::segment(1) == 'gerant' && Request::segment(2) == 'devis') active @endif">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Devis</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/factures/list') }}" class="nav-link @if (Request::segment(1) == 'gerant' && Request::segment(2) == 'factures') active @endif">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Factures</p>
    </a>
</li>

{{-- === Section : Employé === --}}
<li class="nav-header" style="color:#27ae60; font-size:0.62rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; padding: 10px 1rem 2px; border-top: 1px solid rgba(0,0,0,0.07); margin-top:6px;">
    <i class="fas fa-hard-hat mr-1"></i> Employé
</li>

<li class="nav-item">
    <a href="{{ url('employe/dashboard') }}" class="nav-link @if (Request::segment(1) == 'employe' && Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard Employé</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('employe/profile') }}" class="nav-link @if (Request::segment(1) == 'employe' && Request::segment(2) == 'profile') active @endif">
        <i class="nav-icon fas fa-user"></i>
        <p>Mon Profil</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('employe/personnel') }}" class="nav-link @if (Request::segment(1) == 'employe' && Request::segment(2) == 'personnel') active @endif">
        <i class="nav-icon fas fa-id-card"></i>
        <p>Annuaire Personnel</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('employe/absences') }}" class="nav-link @if (Request::segment(1) == 'employe' && (Request::segment(2) == 'absences' || Request::segment(2) == 'leaves')) active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Absences &amp; Congés</p>
    </a>
</li>
