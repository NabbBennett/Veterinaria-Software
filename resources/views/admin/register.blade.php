<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
        }
    </style>
</head>
<body>
    <div class="register-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card register-card">
                        <div class="card-body p-5">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <div class="logo mb-3">LOGO</div>
                                <h4 class="card-title">REGISTRO DE USUARIO</h4>
                            </div>

                            <!-- Formulario de registro -->
                            <form id="registerForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label fw-bold">NOMBRE:</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label fw-bold">APELLIDOS:</label>
                                        <input type="text" class="form-control" id="apellidos" placeholder="Ingresa tus apellidos" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label fw-bold">TELÉFONO:</label>
                                        <input type="tel" class="form-control" id="telefono" placeholder="Número telefónico" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="puesto" class="form-label fw-bold">PUESTO:</label>
                                        <select class="form-select" id="puesto" required>
                                            <option value="">Selecciona un puesto</option>
                                            <option value="administrativo">Administrativo</option>
                                            <option value="veterinario">Veterinario</option>
                                            <option value="peluquero">Peluquero</option>
                                            <option value="recepcionista">Recepcionista</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="usuario" class="form-label fw-bold">USUARIO:</label>
                                        <input type="text" class="form-control" id="usuario" placeholder="Crea tu usuario" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label fw-bold">CONTRASEÑA:</label>
                                        <input type="password" class="form-control" id="password" placeholder="Crea tu contraseña" required>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        REGISTRARSE
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('admin.login') }}" class="btn btn-link">¿Ya tienes cuenta? Inicia Sesión</a>
                                    <br>
                                    <a href="{{ route('home') }}" class="btn btn-link btn-sm">← Volver al acceso principal</a>
                                </div>
                            </form>

                            <!-- Footer -->
                            <div class="text-center mt-4 pt-3 border-top">
                                <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validación básica
            const nombre = document.getElementById('nombre').value;
            const apellidos = document.getElementById('apellidos').value;
            const telefono = document.getElementById('telefono').value;
            const puesto = document.getElementById('puesto').value;
            const usuario = document.getElementById('usuario').value;
            const password = document.getElementById('password').value;
            
            if (nombre && apellidos && telefono && puesto && usuario && password) {
                alert('Registro exitoso! Serás redirigido al login.');
                window.location.href = 'login.html';
            } else {
                alert('Por favor completa todos los campos');
            }
        });
    </script>
</body>
</html>