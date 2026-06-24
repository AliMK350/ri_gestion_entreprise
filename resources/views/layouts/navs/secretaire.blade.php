<li class="nav-item">
    <a href="{{ url('secretaire/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/clients/list') }}" class="nav-link @if (Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/devis/list') }}" class="nav-link @if (Request::segment(2) == 'devis') active @endif">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Devis</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/factures/list') }}" class="nav-link @if (Request::segment(2) == 'factures') active @endif">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Factures</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('secretaire/recus/list') }}" class="nav-link @if (Request::segment(2) == 'recus') active @endif">
        <i class="nav-icon fas fa-receipt"></i>
        <p>Reçus</p>
    </a>
</li>
