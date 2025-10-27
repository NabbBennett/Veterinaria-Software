<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria Amigos Fieles</title>
    <link href="{{ asset('css/welcome/welcome.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">VETERINARIA AMIGOS FIELES</h1>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">Acceso Administrativo</a>
            <p class="lead mb-4">Veterinaria las 24 horas</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="bg-white bg-opacity-25 rounded p-3">
                        <p class="mb-0">Servicio veterinario de calidad para tus mascotas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestros Servicios -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">NUESTROS SERVICIOS</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-heart-pulse display-4 text-primary mb-3"></i>
                            <h4 class="card-title fw-bold">CONSULTA GENERAL</h4>
                            <p class="card-text">Atención médica completa para el bienestar de tu mascota con profesionales especializados.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-calendar-check display-4 text-primary mb-3"></i>
                            <h4 class="card-title fw-bold">URGENCIAS 24H</h4>
                            <p class="card-text">Servicio de emergencias disponible las 24 horas del día, los 7 días de la semana.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-shield-plus display-4 text-primary mb-3"></i>
                            <h4 class="card-title fw-bold">VACUNACIÓN</h4>
                            <p class="card-text">Programa completo de vacunación y prevención para mantener saludable a tu compañero.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ubicación -->
    <section class="location-section py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">UBICACIÓN</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <h4 class="card-title fw-bold mb-3">Encuéntranos Fácilmente</h4>
                            <p class="card-text mb-3">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                <strong>Dirección:</strong> 
                            </p>
                            <p class="card-text mb-3">
                                <i class="bi bi-clock-fill text-primary me-2"></i>
                                <strong>Horario:</strong> 24 horas / 7 días a la semana
                            </p>
                            <p class="card-text mb-3">
                                <i class="bi bi-telephone-fill text-primary me-2"></i>
                                <strong>Teléfono:</strong> (222) 123-4567
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Mapa -->
                    <div class="bg-light rounded p-5 text-center h-100 d-flex align-items-center justify-content-center">
                        <div>
                            <i class="bi bi-map display-1 text-muted mb-3"></i>
                            <p class="text-muted">Mapa de ubicación interactivo</p>
                            <small class="text-muted">mapa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Agenda una Cita -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="fw-bold mb-4">AGENDA UNA CITA!</h2>
                    <p class="lead mb-4">Programa una consulta para tu mascota de forma rápida y sencilla</p>
                    <button class="btn btn-primary btn-lg mb-4">
                        <i class="bi bi-calendar-plus me-2"></i>AGENDAR CITA AHORA
                    </button>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Rápido</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Seguro</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Confiable</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <p class="mb-0">© 2025 CONSULTORIO VETERINARIO AMIGOS FIELES</p>
            <p class="mb-0 small mt-2">Todos los derechos reservados</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>