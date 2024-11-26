<div class="sidebar-wrapper">
    <button class="mobile-toggle">
        <i class="fa fa-bars"></i>
    </button>
    
    <div class="sidebar">
        <!-- Logo -->
        <div class="sidebar-header">
            <span class="logo-text">Jerk Home</span>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ventas.index') }}" class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Ventas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('produccion.index') }}" class="nav-link">
                        <i class="fa fa-flask"></i>
                        <span>Producción</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link">
                        <i class="fa fa-wallet"></i>
                        <span>Finanzas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('rrhh.index') }}" class="nav-link">
                        <i class="fa fa-users"></i>
                        <span>RRHH</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link">
                        <i class="fa fa-truck"></i>
                        <span>Logística</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- User Profile -->
        <div class="sidebar-profile">
            <img src="https://via.placeholder.com/40" alt="User Avatar">
            <div class="profile-info">
                <p class="profile-name">{{ Auth::user()->name }}</p>
                <p class="profile-email">{{ Auth::user()->nombre_usuario }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle sidebar on mobile
document.querySelector('.mobile-toggle').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('active');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.mobile-toggle');
    
    if (!sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});
</script>