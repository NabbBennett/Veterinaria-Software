<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
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
            color: white;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
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
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
        @extends('admin.dashboard.layout')

        <!-- Menú Usuario -->
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
        <!-- Header -->
        <div class="header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">Dashboard Veterinaria</h4>
                    <p class="mb-0 text-muted">Bienvenido al sistema administrativo</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-primary">En línea</span>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-heart-pulse display-4 text-primary"></i>
                    <h4 class="mt-3">45</h4>
                    <p class="text-muted">PACIENTES</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-calendar-check display-4 text-success"></i>
                    <h4 class="mt-3">12</h4>
                    <p class="text-muted">CITAS HOY</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-box-seam display-4 text-warning"></i>
                    <h4 class="mt-3">23</h4>
                    <p class="text-muted">PRODUCTOS BAJOS</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-cash-coin display-4 text-info"></i>
                    <h4 class="mt-3">$2,540</h4>
                    <p class="text-muted">INGRESOS HOY</p>
                </div>
            </div>
        </div>

        <!-- Contenido adicional -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="stats-card">
                    <h5>Actividad Reciente</h5>
                    <p>Aquí iría el contenido de la actividad reciente del sistema...</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5>Próximas Citas</h5>
                    <p>Aquí irían las próximas citas programadas...</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center mt-5 pt-4 border-top">
            <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activar elemento del menú al hacer clic
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>