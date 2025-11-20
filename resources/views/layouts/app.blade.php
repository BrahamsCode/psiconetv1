<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Psiconet Sistema')</title>

    <!-- Estilos principales -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos adicionales de cada página -->
    @stack('styles')
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

            <!-- SECCIÓN: AFILIACIONES (antes Consultantes) -->
            <div class="nav-section">
                <div class="nav-section-title">Datos de Filiación</div>

                <a href="{{ route('afiliaciones.index') }}"
                    class="nav-item {{ request()->routeIs('afiliaciones.index') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span>
                    <span>Todas las Afiliaciones</span>
                </a>

                <a href="{{ route('afiliaciones.create') }}"
                    class="nav-item {{ request()->routeIs('afiliaciones.create') ? 'active' : '' }}">
                    <span class="nav-icon">➕</span>
                    <span>Nueva Afiliación</span>
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
                    <span class="nav-icon">📝</span>
                    <span>Nueva Historia</span>
                </a>
            </div>

            <!-- SECCIÓN: EVALUACIONES PSICOLÓGICAS -->
            <div class="nav-section">
                <div class="nav-section-title">Evaluaciones Psicológicas</div>

                <div class="nav-item nav-parent {{ request()->routeIs('consumo.*') ? 'active' : '' }}"
                    onclick="toggleSubmenu('consumo-submenu')" role="button"
                    aria-expanded="{{ request()->routeIs('consumo.*') ? 'true' : 'false' }}">
                    <span class="nav-icon">🧠</span>
                    <span>Información Relacionada al Consumo</span>
                    <span style="margin-left:auto;opacity:0.7">▾</span>
                </div>

                <div class="submenu {{ request()->routeIs('consumo.*') || request()->routeIs('tratamientos.*') ? 'active' : '' }}"
                    id="consumo-submenu"
                    style="{{ request()->routeIs('consumo.*') || request()->routeIs('tratamientos.*') ? 'display:block;' : '' }}">
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

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('genograma.*') ? 'active' : '' }}">
                    <span class="nav-icon">👨‍👩‍👧‍👦</span>
                    <span>Genograma</span>
                </a>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('lazos.*') ? 'active' : '' }}">
                    <span class="nav-icon">🔗</span>
                    <span>Lazos Familiares</span>
                </a>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('motivo.*') ? 'active' : '' }}">
                    <span class="nav-icon">❓</span>
                    <span>Motivo de Consulta</span>
                </a>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('problema.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚠️</span>
                    <span>Problema Actual</span>
                </a>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('linea-base.*') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span>Línea base y de Tratamiento</span>
                </a>

                <a href="{{ route('conductas.index') }}"
                    class="nav-item {{ request()->routeIs('conductas.*') ? 'active' : '' }}">
                    <span class="nav-icon">🎯</span>
                    <span>Procedimiento Terapéutico</span>
                </a>

                <a href="{{ route('historias.index') }}"
                    class="nav-item {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    <span>Evaluación Psicológica</span>
                </a>

                <a href="{{ route('historias.index') }}"
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
            <div class="top-bar-date" id="reloj-tiempo-real">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY - HH:mm:ss') }}
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

       <script>
        // Sidebar toggle and mobile overlay handling
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close sidebar when clicking a nav link on mobile
        document.querySelectorAll('a.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Toggle submenu
        function toggleSubmenu(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const isActive = el.classList.toggle('active');
            el.style.display = isActive ? 'block' : 'none';
        }

        // Ensure sidebar closes when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });

        // Real-time clock
        function actualizarReloj() {
            const ahora = new Date();
            const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

            const diaSemana = dias[ahora.getDay()];
            const dia = ahora.getDate();
            const mes = meses[ahora.getMonth()];
            const año = ahora.getFullYear();

            const horas = String(ahora.getHours()).padStart(2, '0');
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');

            const fechaHora = `${diaSemana}, ${dia} de ${mes} de ${año} - ${horas}:${minutos}:${segundos}`;
            const elemento = document.getElementById('reloj-tiempo-real');
            if (elemento) {
                elemento.textContent = fechaHora;
            }
        }
        setInterval(actualizarReloj, 1000);
        actualizarReloj();

        if (window.pdfjsLib) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }
    </script>
    @stack('scripts')
</body>

</html>

