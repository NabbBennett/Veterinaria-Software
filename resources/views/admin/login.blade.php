<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="logo mb-3">
                                    <i class="fa-solid fa-paw"></i>
                                </div>
                                <h4 class="card-title">INICIAR SESIÓN</h4>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form action="{{ route('admin.login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="usuario" class="form-label fw-bold">USUARIO:</label>
                                    <input type="text" class="form-control form-control-lg" name="usuario" required 
                                           value="{{ old('usuario') }}" autofocus>
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
                                <a href="{{ route('admin.register') }}" class="btn btn-link">Registrarte</a>
                                <br>
                                <a href="{{ route('welcome') }}" class="btn btn-link btn-sm">← Volver al inicio</a>
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