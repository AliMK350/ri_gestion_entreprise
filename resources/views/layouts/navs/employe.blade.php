<li class="nav-item">
    <a href="{{ url('employe/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('employe/profile') }}" class="nav-link @if (Request::segment(2) == 'profile') active @endif">
        <i class="nav-icon fas fa-user"></i>
        <p>Mon Profil</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('employe/personnel') }}" class="nav-link @if (Request::segment(2) == 'personnel') active @endif">
        <i class="nav-icon fas fa-id-card"></i>
        <p>Annuaire Personnel</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url($personnelUrlPrefix.'/absences') }}" class="nav-link @if (Request::segment(2) == 'absences' || Request::segment(2) == 'leaves') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Absences & Congés</p>
    </a>
</li>
