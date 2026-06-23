<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="display: flex; justify-content: center; align-items: center; padding: 1.5rem 0; border-bottom: 1px solid #eee;">
        <svg width="150" height="60" viewBox="0 0 150 60" xmlns="http://www.w3.org/2000/svg">
            <g fill="#134685">
                <rect x="5" y="5" width="28" height="28" />
                <rect x="35" y="5" width="28" height="28" />
                <rect x="65" y="5" width="28" height="28" />
            </g>
            <rect x="95" y="21" width="12" height="12" fill="#aa1375" />
            <text x="19" y="27" fill="#ffffff" font-family="Georgia, serif" font-size="22" font-weight="bold" text-anchor="middle">U</text>
            <text x="49" y="27" fill="#ffffff" font-family="Georgia, serif" font-size="22" font-weight="bold" text-anchor="middle">P</text>
            <text x="79" y="27" fill="#ffffff" font-family="Georgia, serif" font-size="22" font-weight="bold" text-anchor="middle">F</text>
            <text x="5" y="50" fill="#7b848c" font-family="'Montserrat', sans-serif" font-size="16">Enterprise</text>
        </svg>
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
