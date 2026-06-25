<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="display: flex; justify-content: center; align-items: center; padding: 1rem 0.75rem; border-bottom: 1px solid #D9EEF8; text-decoration: none;">
        <img src="{{ url('/dist/img/ri-logo-transparent.png') }}" alt="Ri Communication" class="ri-logo-light" style="max-height:52px;width:auto;max-width:170px;object-fit:contain;">
        <img src="{{ url('/dist/img/ri-logo-dark.png') }}" alt="Ri Communication" class="ri-logo-dark" style="max-height:52px;width:auto;max-width:170px;object-fit:contain;display:none;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center" style="border-bottom: 1px solid #D9EEF8; padding: 0.5rem 1rem;">
            <div class="image mr-2">
                <div style="width:36px; height:36px; background:#E8F7FD; border-radius:50%; display:flex; align-items:center; justify-content:center; border: 2px solid #00ADEF;">
                    <i class="fas fa-user" style="color:#00ADEF; font-size:0.9rem;"></i>
                </div>
            </div>
            <div class="info">
                <span style="font-family: Montserrat, sans-serif; font-weight: 600; font-size: 0.82rem; color: #111111; display:block;">{{ Auth::user()->name }}</span>
                @if(Auth::user()->user_type == 1)
                    <span style="font-size:0.68rem; color:#00ADEF; font-weight:700; letter-spacing:0.06em; text-transform:uppercase;">Administrateur</span>
                @elseif(Auth::user()->user_type == 2)
                    <span style="font-size:0.68rem; color:#00ADEF; font-weight:700; letter-spacing:0.06em; text-transform:uppercase;">Secrétaire</span>
                @elseif(Auth::user()->user_type == 3)
                    <span style="font-size:0.68rem; color:#00ADEF; font-weight:700; letter-spacing:0.06em; text-transform:uppercase;">Employé</span>
                @elseif(Auth::user()->user_type == 4)
                    <span style="font-size:0.68rem; color:#00ADEF; font-weight:700; letter-spacing:0.06em; text-transform:uppercase;">Gérant</span>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @if (Auth::user()->user_type == 1)
                    @include('layouts.navs.admin')
                @elseif(Auth::user()->user_type == 2)
                    @include('layouts.navs.secretaire')
                @elseif(Auth::user()->user_type == 3)
                    @include('layouts.navs.employe')
                @elseif(Auth::user()->user_type == 4)
                    @include('layouts.navs.gerant')
                @endif

                <li class="nav-item mt-2" style="border-top: 1px solid #D9EEF8; padding-top: 8px;">
                    <a href="{{ url('/logout') }}" class="nav-link" style="color: #ef4444 !important;">
                        <i class="nav-icon fas fa-sign-out-alt" style="color: #ef4444 !important;"></i>
                        <p>Déconnexion</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
