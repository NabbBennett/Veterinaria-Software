<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .logo { font-size: 2.5rem; font-weight: bold; color: #667eea; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 30px; }
    </style>
</head>
<body>
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="logo mb-3">LOGO</div>
                                <h4 class="card-title">INICIAR SESIÓN</h4>
                            </div>

                            <form action="{{ route('admin.dashboard.index') }}" method="GET">
                                @csrf
                                <div class="mb-3">
                                    <label for="usuario" class="form-label fw-bold">USUARIO:</label>
                                    <input type="text" class="form-control form-control-lg" name="usuario" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">CONTRASEÑA:</label>
                                    <input type="password" class="form-control form-control-lg" name="password" required>
                                </div>
                                
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">ACCEDER</button>
                                </div>
                            </form>

                            <div class="text-center">
                                <a href="{{ route('admin.register') }}" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
                                <br>
                                <a href="{{ route('admin.index') }}" class="btn btn-link btn-sm">← Volver</a>
                            </div>

                            <div class="text-center mt-4 pt-3 border-top">
                                <small class="text-muted">©2025 CONSULTORIO VETERINARIO</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>