<li class="nav-item">
    <a href="{{ url('admin/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/admin/list') }}" class="nav-link @if (Request::segment(2) == 'admin') active @endif">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Liste des Admins</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/clients/list') }}" class="nav-link @if (Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Gestion Clients</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/class/list') }}" class="nav-link @if (Request::segment(2) == 'class') active @endif">
        <i class="nav-icon fas fa-building"></i>
        <p>Départements</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/subject/list') }}" class="nav-link @if (Request::segment(2) == 'subject') active @endif">
        <i class="nav-icon fas fa-project-diagram"></i>
        <p>Missions / Projets</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/demandes/list') }}" class="nav-link @if (Request::segment(2) == 'demandes') active @endif">
        <i class="nav-icon fas fa-file-contract"></i>
        <p>Demandes RH</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/absences/list') }}" class="nav-link @if (Request::segment(2) == 'absences') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Congés / Absences</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/notes/list') }}" class="nav-link @if (Request::segment(2) == 'notes') active @endif">
        <i class="nav-icon fas fa-star"></i>
        <p>Évaluations</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/annonces/list') }}" class="nav-link @if (Request::segment(2) == 'annonces') active @endif">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Annonces</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/emploi-du-temps/list') }}" class="nav-link @if (Request::segment(2) == 'emploi-du-temps') active @endif">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Plannings de travail</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/reservations/list') }}" class="nav-link @if (Request::segment(2) == 'reservations') active @endif">
        <i class="nav-icon fas fa-door-open"></i>
        <p>Salles de Réunion</p>
    </a>
</li>
