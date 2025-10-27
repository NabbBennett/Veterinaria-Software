<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Veterinaria')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
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
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: block;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
        }
        
        .user-menu {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .header {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">LOGO</div>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ url('/admin/dashboard') }}" class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>
            <a href="{{ url('/admin/dashboard/pacientes') }}" class="menu-item {{ request()->is('admin/dashboard/pacientes') ? 'active' : '' }}">
                <i class="bi bi-heart-pulse"></i>PACIENTES
            </a>
            <a href="{{ url('/admin/dashboard/citas') }}" class="menu-item {{ request()->is('admin/dashboard/citas') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>CITAS
            </a>
            <a href="{{ url('/admin/dashboard/inventario') }}" class="menu-item {{ request()->is('admin/dashboard/inventario') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>INVENTARIO
            </a>
            <a href="{{ url('/admin/dashboard/servicios') }}" class="menu-item {{ request()->is('admin/dashboard/servicios') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>SERVICIOS
            </a>
            <a href="{{ url('/admin/dashboard/caja') }}" class="menu-item {{ request()->is('admin/dashboard/caja') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>CAJA
            </a>
        </div>
        
        <div class="user-menu">
            <a href="#" class="menu-item">
                <i class="bi bi-person"></i>PERFIL
            </a>
            <a href="{{ route('admin.login') }}" class="menu-item">
                <i class="bi bi-box-arrow-right"></i>CERRAR SESIÓN
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                    <p class="mb-0 text-muted">@yield('page-subtitle', 'Sistema de gestión veterinaria')</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-primary">En línea</span>
                </div>
            </div>
        </div>

        @yield('content')

        <footer class="text-center mt-5 pt-4 border-top">
            <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>