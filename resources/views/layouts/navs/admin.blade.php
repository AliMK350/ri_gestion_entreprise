<li class="nav-item">
    <a href="{{ url('admin/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/admin/list') }}" class="nav-link @if (Request::segment(2) == 'admin') active @endif">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Utilisateurs Admin</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/employees/list') }}" class="nav-link @if (Request::segment(2) == 'employees') active @endif">
        <i class="nav-icon fas fa-users"></i>
        <p>Employés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/interns/list') }}" class="nav-link @if (Request::segment(2) == 'interns') active @endif">
        <i class="nav-icon fas fa-user-graduate"></i>
        <p>Stagiaires</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/absences/list') }}" class="nav-link @if (Request::segment(2) == 'absences') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Absences</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/leaves/list') }}" class="nav-link @if (Request::segment(2) == 'leaves') active @endif">
        <i class="nav-icon fas fa-umbrella-beach"></i>
        <p>Congés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/personnel') }}" class="nav-link @if (Request::segment(2) == 'personnel') active @endif">
        <i class="nav-icon fas fa-id-card"></i>
        <p>Consultation Personnel</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/clients/list') }}" class="nav-link @if (Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
