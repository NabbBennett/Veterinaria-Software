<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Veterinaria')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">

</head>
<body>
    <div class="mobile-header d-md-none">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="mobile-page-title">
            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            <p class="mb-0">@yield('page-subtitle', 'Sistema de gestión veterinaria')</p>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <span class="logo-full"><i class="fa-solid fa-paw"></i><br>Veterinaria</span>
                <span class="logo-icon"><i class="fa-solid fa-paw"></i></span>
            </div>
            <button class="btn btn-sm btn-outline-light d-md-none mt-2" onclick="toggleSidebar()">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-speedometer2"></i>
                <span class="menu-text">DASHBOARD</span>
                <div class="menu-item-tooltip">Dashboard</div>
            </a>
            <a href="{{ route('admin.dashboard.pacientes') }}" class="menu-item {{ request()->routeIs('admin.dashboard.pacientes') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-heart-pulse"></i>
                <span class="menu-text">PACIENTES</span>
                <div class="menu-item-tooltip">Pacientes</div>
            </a>
            <a href="{{ route('admin.dashboard.citas') }}" class="menu-item {{ request()->routeIs('admin.dashboard.citas') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-calendar-check"></i>
                <span class="menu-text">CITAS</span>
                <div class="menu-item-tooltip">Citas</div>
            </a>
            <a href="{{ route('admin.dashboard.inventario') }}" class="menu-item {{ request()->routeIs('admin.dashboard.inventario') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-box-seam"></i>
                <span class="menu-text">INVENTARIO</span>
                <div class="menu-item-tooltip">Inventario</div>
            </a>
            <a href="{{ route('admin.dashboard.servicios') }}" class="menu-item {{ request()->routeIs('admin.dashboard.servicios') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-gear"></i>
                <span class="menu-text">SERVICIOS</span>
                <div class="menu-item-tooltip">Servicios</div>
            </a>
            <a href="{{ route('admin.dashboard.caja') }}" class="menu-item {{ request()->routeIs('admin.dashboard.caja') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-cash-coin"></i>
                <span class="menu-text">CAJA</span>
                <div class="menu-item-tooltip">Caja</div>
            </a>
        </div>
        
        <div class="user-menu">
            <a href="{{ route('admin.dashboard.profile') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-person"></i>
                <span class="menu-text">PERFIL</span>
                <div class="menu-item-tooltip">Perfil</div>
            </a>
            <a href="{{ route('admin.login') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-box-arrow-right"></i>
                <span class="menu-text">CERRAR SESIÓN</span>
                <div class="menu-item-tooltip">Cerrar Sesión</div>
            </a>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="main-content" id="mainContent">
        <div class="header d-none d-md-flex">
            <div>
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                <p class="mb-0 text-muted">@yield('page-subtitle', 'Sistema de gestión veterinaria')</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">En línea</span>
                <button class="toggle-sidebar-btn" onclick="toggleSidebarDesktop()" title="Contraer/Expandir menú">
                    <i class="bi bi-layout-sidebar-inset-reverse" id="sidebarToggleIcon"></i>
                </button>
            </div>
        </div>

        @yield('content')

        <footer class="text-center mt-5 pt-4 border-top">
            <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const savedSidebarState = localStorage.getItem('sidebarCollapsed');
        if (savedSidebarState === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
            document.getElementById('mainContent').classList.add('sidebar-collapsed');
            updateToggleIcon(true);
        }

        function toggleSidebarDesktop() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const isCollapsed = sidebar.classList.toggle('collapsed');
            
            mainContent.classList.toggle('sidebar-collapsed');
            
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            updateToggleIcon(isCollapsed);
        }
        
        function updateToggleIcon(isCollapsed) {
            const icon = document.getElementById('sidebarToggleIcon');
            if (isCollapsed) {
                icon.className = 'bi bi-layout-sidebar-inset';
            } else {
                icon.className = 'bi bi-layout-sidebar-inset-reverse';
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
        
        function closeSidebarOnMobile() {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        }
        
        document.getElementById('overlay').addEventListener('click', function() {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('mobile-open')) {
                    toggleSidebar();
                }
            }
        });
        
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('mobile-open');
                document.body.style.overflow = 'auto';
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        setTimeout(() => {
                            toggleSidebar();
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>
</html>