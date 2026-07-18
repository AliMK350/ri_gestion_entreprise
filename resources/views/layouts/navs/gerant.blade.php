<li class="nav-item">
    <a href="{{ url('gerant/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/clients/list') }}" class="nav-link @if (Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/devis/list') }}" class="nav-link @if (Request::segment(2) == 'devis') active @endif">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Devis</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/factures/list') }}" class="nav-link @if (Request::segment(2) == 'factures') active @endif">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Factures</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('gerant/absences') }}" class="nav-link @if (Request::segment(2) == 'absences' || Request::segment(2) == 'leaves') active @endif">
        <i class="nav-icon fas fa-calendar-times"></i>
        <p>Absences & Congés</p>
    </a>
</li>
