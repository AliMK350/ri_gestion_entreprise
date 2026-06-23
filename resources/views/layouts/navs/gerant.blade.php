<li class="nav-item">
    <a href="{{ url('gerant/dashboard') }}" class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/clients/list') }}" class="nav-link @if (Request::segment(2) == 'clients') active @endif">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Clients</p>
    </a>
</li>
