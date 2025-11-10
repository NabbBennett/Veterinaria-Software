<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Veterinaria')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-width-collapsed: 70px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .main-content.sidebar-collapsed {
            margin-left: var(--sidebar-width-collapsed);
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed .sidebar-brand {
            padding: 20px 10px;
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed .logo {
            font-size: 1.5rem;
        }
        
        .logo-full {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .logo-full {
            opacity: 0;
        }
        
        .logo-icon {
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.8rem;
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .logo-icon {
            opacity: 1;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            transition: all 0.3s ease;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .sidebar.collapsed .menu-item {
            padding: 12px 15px;
            justify-content: center;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            transition: margin 0.3s ease;
            flex-shrink: 0;
        }
        
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .menu-text {
            transition: all 0.3s ease;
            opacity: 1;
        }
        
        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }
        
        .user-menu {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed .user-menu {
            padding: 0 5px;
        }
        
        .header {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .toggle-sidebar-btn:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }
        
        /* Mobile Styles - Mejorado */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.sidebar-collapsed {
                margin-left: 0;
            }
            
            /* Nuevo diseño para el header móvil */
            .mobile-header {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
                background: white;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .mobile-menu-btn {
                background: var(--primary-color);
                border: none;
                color: white;
                border-radius: 8px;
                padding: 10px 15px;
                font-size: 1.2rem;
                margin-right: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .mobile-page-title {
                flex-grow: 1;
            }
            
            .mobile-page-title h5 {
                margin-bottom: 2px !important;
                font-weight: 600;
            }
            
            .mobile-page-title p {
                margin-bottom: 0 !important;
                font-size: 0.85rem;
                color: #6c757d;
            }
            
            .toggle-sidebar-btn {
                display: none !important;
            }
            
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .overlay.active {
                display: block;
            }
            
            .sidebar.mobile-open ~ .overlay {
                display: block;
            }
            
            /* Ocultar el header de escritorio en móvil */
            .header.d-none.d-md-flex {
                display: none !important;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 769px) {
            .mobile-header, .mobile-menu-btn, .overlay {
                display: none;
            }
        }
        
        /* Tooltip for collapsed sidebar */
        .menu-item-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
            margin-left: 10px;
        }
        
        .menu-item-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #333;
        }
        
        .sidebar.collapsed .menu-item:hover .menu-item-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        /* Compact menu for mobile */
        @media (max-width: 480px) {
            .sidebar {
                width: 280px;
            }
            
            .menu-item {
                padding: 15px 20px;
                font-size: 1.1rem;
            }
            
            .main-content {
                padding: 10px;
            }
            
            .header {
                padding: 12px 15px;
            }
            
            .mobile-header {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header - Mejorado -->
    <div class="mobile-header d-md-none">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="mobile-page-title">
            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            <p class="mb-0">@yield('page-subtitle', 'Sistema de gestión veterinaria')</p>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <span class="logo-full">LOGO</span>
                <span class="logo-icon">V</span>
            </div>
            <button class="btn btn-sm btn-outline-light d-md-none mt-2" onclick="toggleSidebar()">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <i class="bi bi-speedometer2"></i>
                <span class="menu-text">Dashboard</span>
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

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Contenido Principal -->
    <div class="main-content" id="mainContent">
        <!-- Desktop Header -->
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

        <!-- Contenido de la página -->
        @yield('content')

        <footer class="text-center mt-5 pt-4 border-top">
            <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Check if sidebar state is saved in localStorage
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
            
            // Save state to localStorage
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
            
            // Prevent body scroll when sidebar is open
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
        
        // Close sidebar when clicking outside on mobile
        document.getElementById('overlay').addEventListener('click', function() {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });
        
        // Close sidebar on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('mobile-open')) {
                    toggleSidebar();
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('mobile-open');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Auto-close sidebar when navigating on mobile
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