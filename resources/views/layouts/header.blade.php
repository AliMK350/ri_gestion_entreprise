<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars" style="color: #00ADEF;"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center" style="gap: 0.5rem; padding-right: 0.5rem;">

        <!-- Dark mode toggle -->
        <li class="nav-item">
            <button class="dark-mode-toggle" id="darkModeToggle" title="Basculer le mode sombre">
                <span class="toggle-icon" id="toggleIcon">🌙</span>
                <span id="toggleLabel">Mode sombre</span>
            </button>
        </li>

        <!-- User info -->
        <li class="nav-item d-none d-md-flex align-items-center" style="gap: 0.5rem; padding-left: 0.5rem; border-left: 1px solid #D9EEF8;">
            <div style="width:30px; height:30px; background:#E8F7FD; border-radius:50%; display:flex; align-items:center; justify-content:center; border: 1.5px solid #00ADEF;">
                <i class="fas fa-user" style="color:#00ADEF; font-size:0.75rem;"></i>
            </div>
            <span style="font-family: Montserrat, sans-serif; font-weight: 600; font-size: 0.82rem; color: #4A4A4A;" id="headerUserName">
                {{ !empty(Auth::user()) ? Auth::user()->name : '' }}
            </span>
        </li>
    </ul>
</nav>

<script>
(function() {
    // Apply theme immediately (before page renders) to avoid flash
    var saved = localStorage.getItem('ri_theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
})();
</script>
