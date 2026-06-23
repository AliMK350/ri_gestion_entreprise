<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links (minimal) -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-md-block">
            <span class="nav-link text-muted small">{{ !empty(Auth::user()) ? Auth::user()->name : '' }}</span>
        </li>
    </ul>
</nav>
