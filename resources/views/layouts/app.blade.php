<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Psiconet Sistema')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

</head>

<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()" aria-label="Abrir menú">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <!-- Overlay for Mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar" aria-label="Barra lateral">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo-psiconet.png') }}" alt="Psiconet - Especialidades Psicológicas"
                    class="logo-img" />
            </div>
        </div>

        <nav class="sidebar-nav" aria-label="Navegación principal">
            <!-- SECCIÓN: PRINCIPAL -->
            <div class="nav-section">
                <div class="nav-section-title">Principal</div>

                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- SECCIÓN: CONSULTANTES -->
            <div class="nav-section">
                <div class="nav-section-title">Consultantes</div>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('consultantes.index') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span>
                    <span>Todos los Consultantes</span>
                </a>

                <a href="{{ route('consultantes.create') }}"
                    class="nav-item {{ request()->routeIs('consultantes.create') ? 'active' : '' }}">
                    <span class="nav-icon">➕</span>
                    <span>Nuevo Consultante</span>
                </a>
            </div>

            <!-- SECCIÓN: HISTORIAS CLÍNICAS -->
            <div class="nav-section">
                <div class="nav-section-title">Historias Clínicas</div>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('historias.index') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span>
                    <span>Todas las Historias</span>
                </a>

                <a href="{{ route('historias.nueva') }}"
                    class="nav-item {{ request()->routeIs('historias.nueva') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span>
                    <span>Nueva Historia</span>
                </a>

                {{-- <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('historias.create') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    <span>Nueva Historia</span>
                </a> --}}
            </div>

            <!-- SECCIÓN: INFORMACIÓN RELACIONADA AL CONSUMO -->
            <div class="nav-section">
                <div class="nav-section-title">🧠Evaluaciones Psicológicas</div>

                <div class="nav-item nav-parent {{ request()->routeIs('consumo.*') ? 'active' : '' }}"
                    onclick="toggleSubmenu('consumo-submenu')" role="button"
                    aria-expanded="{{ request()->routeIs('consumo.*') ? 'true' : 'false' }}">
                    <span class="nav-icon">🧠</span>
                    <span>Información Relacionada al Consumo</span>
                    <span style="margin-left:auto;opacity:0.7">▾</span>
                </div>

                <div class="submenu {{ request()->routeIs('consumo.*') ? 'active' : '' }}" id="consumo-submenu"
                    style="{{ request()->routeIs('consumo.*') ? 'display:block;' : '' }}">
                    <a href="{{ route('consumo.index') }}"
                        class="nav-item {{ request()->routeIs('consumo.*') ? 'active' : '' }}">
                        <span class="nav-icon">🔁</span>
                        <span>Fase del consumo</span>
                    </a>
                    <a href="{{ route('tratamientos.index') }}"
                        class="nav-item {{ request()->routeIs('tratamientos.*') ? 'active' : '' }}">
                        <span class="nav-icon">💊</span>
                        <span>Tratamientos recibidos</span>
                    </a>
                </div>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Diagrama Familiar</span>
                </a>
                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Lazos Familiares</span>
                </a>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Motivo de Consulta</span>
                </a>
                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Problema Actual</span>
                </a>
                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Línea base y de Tratamiento</span>
                </a>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Procedimiento Terapéutico</span>
                </a>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Evaluación Psicológica </span>
                </a>

                <a href="{{ route('consultantes.index') }}"
                    class="nav-item {{ request()->routeIs('interconsultas.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚕️</span>
                    <span>Interconsulta Psiquiátrica</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content" role="main">
        <div class="top-bar" role="banner">
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="top-bar-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </div>
        </div>

        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <span>❌</span>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="alert alert-info">
                <span>ℹ️</span>
                <span>{{ session('info') }}</span>
            </div>
            @endif

            @if(session('warning'))
            <div class="alert alert-warning">
                <span>⚠️</span>
                <span>{{ session('warning') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <div>
                    <strong>Se encontraron los siguientes errores:</strong>
                    <ul style="margin-left: 1.25rem; margin-top: 0.5rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Sidebar toggle and mobile overlay handling
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close sidebar when clicking a nav link on mobile (only for anchor links)
        document.querySelectorAll('a.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Toggle a submenu by id
        function toggleSubmenu(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const isActive = el.classList.toggle('active');
            el.style.display = isActive ? 'block' : 'none';
        }

        // Ensure sidebar closes when resizing back to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>

</html>
