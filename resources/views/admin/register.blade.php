<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">   
    <link rel="stylesheet" href="{{ asset('css/admin/register.css') }}">
</head>
<body>
    <div class="register-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card register-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="logo mb-3"><i class="fa-solid fa-paw"></i></div>
                                <h4 class="card-title">REGISTRO DE USUARIO</h4>
                                <p class="text-muted">Complete todos los campos para registrarse en el sistema</p>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.register.submit') }}" method="POST" id="registerForm">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label fw-bold">NOMBRE:</label>
                                        <input type="text" class="form-control form-control-lg" id="nombre" 
                                               name="nombre" placeholder="Ingresa tu nombre" 
                                               value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label fw-bold">APELLIDOS:</label>
                                        <input type="text" class="form-control form-control-lg" id="apellidos" 
                                               name="apellidos" placeholder="Ingresa tus apellidos" 
                                               value="{{ old('apellidos') }}" required>
                                        @error('apellidos')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label fw-bold">TELÉFONO:</label>
                                        <input type="tel" class="form-control form-control-lg" id="telefono" 
                                               name="telefono" placeholder="Número telefónico" 
                                               value="{{ old('telefono') }}" required>
                                        @error('telefono')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="puesto" class="form-label fw-bold">PUESTO:</label>
                                        <select class="form-select form-select-lg" id="puesto" name="puesto" required>
                                            <option value="">Selecciona un puesto</option>
                                            <option value="administrativo" {{ old('puesto') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                            <option value="veterinario" {{ old('puesto') == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                                            <option value="peluquero" {{ old('puesto') == 'peluquero' ? 'selected' : '' }}>Peluquero</option>
                                            <option value="recepcionista" {{ old('puesto') == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                        </select>
                                        @error('puesto')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">CORREO ELECTRÓNICO:</label>
                                        <input type="email" class="form-control form-control-lg" id="email" 
                                               name="email" placeholder="correo@ejemplo.com" 
                                               value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="usuario" class="form-label fw-bold">USUARIO:</label>
                                        <input type="text" class="form-control form-control-lg" id="usuario" 
                                               name="usuario" placeholder="Crea tu usuario" 
                                               value="{{ old('usuario') }}" required>
                                        @error('usuario')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">CONTRASEÑA:</label>
                                        <input type="password" class="form-control form-control-lg" id="password" 
                                               name="password" placeholder="Crea tu contraseña" required>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="password_confirmation" class="form-label fw-bold">CONFIRMAR CONTRASEÑA:</label>
                                        <input type="password" class="form-control form-control-lg" id="password_confirmation" 
                                               name="password_confirmation" placeholder="Repite tu contraseña" required>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span id="submitText">REGISTRARSE</span>
                                        <div id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('admin.login') }}" class="btn btn-link">¿Ya tienes cuenta? Inicia Sesión</a>
                                    <br>
                                    <a href="{{ route('admin.access') }}" class="btn btn-link btn-sm">← Volver al acceso</a>
                                </div>
                            </form>

                            <div class="text-center mt-4 pt-3 border-top">
                                <small class="text-muted">©2025 CONSULTORIO VETERINARIO - Sistema Administrativo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            submitText.textContent = 'REGISTRANDO...';
            loadingSpinner.classList.remove('d-none');
            submitBtn.disabled = true;
            
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor verifica.');
                submitText.textContent = 'REGISTRARSE';
                loadingSpinner.classList.add('d-none');
                submitBtn.disabled = false;
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres.');
                submitText.textContent = 'REGISTRARSE';
                loadingSpinner.classList.add('d-none');
                submitBtn.disabled = false;
                return;
            }
            
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (confirmation && password !== confirmation) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (confirmation && password === confirmation) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        document.getElementById('telefono').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9+-\s]/g, '');
        });

        document.getElementById('nombre').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });

        document.getElementById('apellidos').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    </script>
</body>
</html>