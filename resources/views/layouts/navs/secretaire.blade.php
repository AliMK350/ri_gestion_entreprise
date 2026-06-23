<li class="nav-item">
    <a href="{{ url('secretaire/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.notes.index') }}" class="nav-link @if (Request::segment(2) == 'notes') active @endif">
        <i class="nav-icon fas fa-star"></i>
        <p>Saisie évaluations</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.absences.index') }}" class="nav-link @if (Request::segment(2) == 'absences') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Suivi absences</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.cahier-texte.index') }}" class="nav-link @if (Request::segment(2) == 'cahier-texte') active @endif">
        <i class="nav-icon fas fa-book-open"></i>
        <p>Journal de bord</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.supports.index') }}" class="nav-link @if (Request::segment(2) == 'supports-cours') active @endif">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Procédures & Docs</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.annonces.index') }}" class="nav-link @if (Request::segment(2) == 'annonces') active @endif">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Annonces</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.emploi-du-temps.index') }}" class="nav-link @if (Request::segment(2) == 'emploi-du-temps') active @endif">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Planning de travail</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.reservations.index') }}" class="nav-link @if (Request::segment(2) == 'reservations') active @endif">
        <i class="nav-icon fas fa-door-open"></i>
        <p>Réservations Salles</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('secretaire.demandes.index') }}" class="nav-link @if (Request::segment(2) == 'demandes') active @endif">
        <i class="nav-icon fas fa-file-contract"></i>
        <p>Demandes RH</p>
    </a>
</li>
