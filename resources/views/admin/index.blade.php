<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
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
        .alert-danger {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="admin-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <div class="logo mb-3">LOGO</div>
                                <h4 class="card-title">ACCESO ADMINISTRATIVO</h4>
                                <p class="text-muted">Ingresa la clave de acceso</p>
                            </div>

                            <!-- Mostrar errores -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first('clave') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Formulario de clave -->
                            <!-- CORREGIDO: Cambiado admin.verify por admin.access (POST) -->
                            <form method="POST" action="{{ route('admin.access') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="clave" class="form-label fw-bold">CLAVE DE ACCESO:</label>
                                    <input type="password" class="form-control form-control-lg" id="clave" 
                                           name="clave" placeholder="Ingresa la clave proporcionada" required 
                                           value="{{ old('clave') }}" autofocus>
                                </div>
                                
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        ACCEDER AL SISTEMA
                                    </button>
                                </div>
                            </form>

                            <!-- CORREGIDO: Cambiado home por welcome -->
                            <a href="{{ route('welcome') }}" class="btn btn-link btn-sm">← Volver al acceso principal</a>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>