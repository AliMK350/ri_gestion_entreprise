<li class="nav-item">
    <a href="{{ url('employe/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.notes.index') }}" class="nav-link @if (Request::segment(2) == 'notes') active @endif">
        <i class="nav-icon fas fa-star"></i>
        <p>Mes évaluations</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.supports.index') }}" class="nav-link @if (Request::segment(2) == 'supports-cours') active @endif">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Procédures & Docs</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.classroom.index') }}" class="nav-link @if (Request::segment(2) == 'classroom') active @endif">
        <i class="nav-icon fas fa-comments"></i>
        <p>Espace d'échange</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.emploi-du-temps.index') }}" class="nav-link @if (Request::segment(2) == 'emploi-du-temps') active @endif">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Planning de travail</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.absences.index') }}" class="nav-link @if (Request::segment(2) == 'absences') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Mes absences / Congés</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.justificatifs.index') }}" class="nav-link @if (Request::segment(2) == 'justificatifs') active @endif">
        <i class="nav-icon fas fa-file-upload"></i>
        <p>Justificatifs</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('employe.demandes.index') }}" class="nav-link @if (Request::segment(2) == 'demandes') active @endif">
        <i class="nav-icon fas fa-file-contract"></i>
        <p>Demandes RH</p>
    </a>
</li>
