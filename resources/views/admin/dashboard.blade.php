<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">   
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
</head>
<body>
    <div class="mobile-header d-md-none">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="mobile-page-title">
            <h5 class="mb-0">Dashboard</h5>
            <p class="mb-0">Sistema de gestión veterinaria</p>
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
            <a href="{{ url('/admin/dashboard') }}" class="menu-item active" onclick="closeSidebarOnMobile()">
                <i class="bi bi-speedometer2"></i>
                <span class="menu-text">DASHBOARD</span>
                <div class="menu-item-tooltip">Dashboard</div>
            </a>
            <a href="{{ url('/admin/dashboard/pacientes') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-heart-pulse"></i>
                <span class="menu-text">PACIENTES</span>
                <div class="menu-item-tooltip">Pacientes</div>
            </a>
            <a href="{{ url('/admin/dashboard/citas') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-calendar-check"></i>
                <span class="menu-text">CITAS</span>
                <div class="menu-item-tooltip">Citas</div>
            </a>
            <a href="{{ url('/admin/dashboard/inventario') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-box-seam"></i>
                <span class="menu-text">INVENTARIO</span>
                <div class="menu-item-tooltip">Inventario</div>
            </a>
            <a href="{{ url('/admin/dashboard/servicios') }}" class="menu-item" onclick="closeSidebarOnMobile()">
                <i class="bi bi-gear"></i>
                <span class="menu-text">SERVICIOS</span>
                <div class="menu-item-tooltip">Servicios</div>
            </a>
            <a href="{{ url('/admin/dashboard/caja') }}" class="menu-item" onclick="closeSidebarOnMobile()">
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
                <h4 class="mb-0">Dashboard</h4>
                <p class="mb-0 text-muted">Sistema de gestión veterinaria</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">En línea</span>
                <button class="toggle-sidebar-btn" onclick="toggleSidebarDesktop()" title="Contraer/Expandir menú">
                    <i class="bi bi-layout-sidebar-inset-reverse" id="sidebarToggleIcon"></i>
                </button>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stats-card text-center">
                        <i class="bi bi-heart-pulse display-4 text-primary"></i>
                        <h4 class="mt-3">150</h4>
                        <p class="text-muted">PACIENTES</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stats-card text-center">
                        <i class="bi bi-calendar-check display-4 text-success"></i>
                        <h4 class="mt-3">8</h4>
                        <p class="text-muted">CITAS HOY</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stats-card text-center">
                        <i class="bi bi-box-seam display-4 text-warning"></i>
                        <h4 class="mt-3">12</h4>
                        <p class="text-muted">PRODUCTOS BAJOS</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stats-card text-center">
                        <i class="bi bi-cash-coin display-4 text-info"></i>
                        <h4 class="mt-3">$1,250.75</h4>
                        <p class="text-muted">INGRESOS HOY</p>
                    </div>
                </div>
            </div>
        </div>

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
        
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>