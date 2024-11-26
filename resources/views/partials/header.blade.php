<header class="admin-header">
    <div class="header-container">
        <div class="header-left">
            <h1 class="header-title">Panel Administrativo</h1>
        </div>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" placeholder="Buscar..." class="search-input" />
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <div class="header-actions">
                <div class="notification-wrapper">
                    <a href="#" class="header-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                </div>
                
                <a href="{{ route('configuracion.index') }}" class="header-icon">
                    <i class="fas fa-cog"></i>
                </a>

                <!-- Icono para cerrar sesión -->
                <a href="{{ route('logout') }}" class="header-icon" title="Cerrar sesión" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>

                <!-- Formulario para cerrar sesión -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>

