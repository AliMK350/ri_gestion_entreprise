<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="display: flex; justify-content: center; align-items: center; padding: 1.5rem 0; border-bottom: 1px solid #eee;">
        <span style="font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1.4rem; color: #134685;">Gestion Entreprise</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @if (Auth::user()->user_type == 1)
                    @include('layouts.navs.admin')
                @elseif(Auth::user()->user_type == 2)
                    @include('layouts.navs.secretaire')
                @elseif(Auth::user()->user_type == 3)
                    @include('layouts.navs.employe')
                @elseif(Auth::user()->user_type == 4)
                    @include('layouts.navs.gerant')
                @endif

                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Déconnexion</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
