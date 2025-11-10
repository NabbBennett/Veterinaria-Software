@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Mi Perfil</h4>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-circle"></i> Información Personal
                </h5>
            </div>
            <div class="card-body">
                <form id="profileForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $user->nombre }}" required>
                            <div class="invalid-feedback" id="nombreError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" class="form-control" value="{{ $user->apellidos }}" required>
                            <div class="invalid-feedback" id="apellidosError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono" class="form-control" value="{{ $user->telefono }}" required>
                            <div class="invalid-feedback" id="telefonoError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Puesto *</label>
                            <select name="puesto" class="form-select" required>
                                <option value="">Selecciona un puesto</option>
                                <option value="administrativo" {{ $user->puesto == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="veterinario" {{ $user->puesto == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                                <option value="peluquero" {{ $user->puesto == 'peluquero' ? 'selected' : '' }}>Peluquero</option>
                                <option value="recepcionista" {{ $user->puesto == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="asistente" {{ $user->puesto == 'asistente' ? 'selected' : '' }}>Asistente Veterinario</option>
                            </select>
                            <div class="invalid-feedback" id="puestoError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo Electrónico *</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usuario *</label>
                            <input type="text" name="usuario" class="form-control" value="{{ $user->usuario }}" required>
                            <div class="invalid-feedback" id="usuarioError"></div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                            <i class="bi bi-check-circle"></i> Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                </h5>
            </div>
            <div class="card-body">
                <form id="passwordForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Contraseña Actual *</label>
                        <input type="password" name="current_password" class="form-control" required>
                        <div class="invalid-feedback" id="current_passwordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña *</label>
                        <input type="password" name="new_password" class="form-control" required minlength="6">
                        <div class="invalid-feedback" id="new_passwordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nueva Contraseña *</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                        <div class="invalid-feedback" id="new_password_confirmationError"></div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning" id="updatePasswordBtn">
                            <i class="bi bi-key"></i> Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Información de la Cuenta
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Estado:</strong>
                    @if($user->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </div>
                <div class="mb-2">
                    <strong>Registrado:</strong>
                    <br>{{ $user->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="mb-2">
                    <strong>Última actualización:</strong>
                    <br>{{ $user->updated_at->format('d/m/Y H:i') }}
                </div>
                <div class="mb-0">
                    <strong>ID de usuario:</strong>
                    <br><code>{{ $user->id }}</code>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Éxito</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

function clearErrors() {
    const errorElements = document.querySelectorAll('.is-invalid, .invalid-feedback');
    errorElements.forEach(element => {
        element.classList.remove('is-invalid');
        if (element.classList.contains('invalid-feedback')) {
            element.textContent = '';
        }
    });
}

document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('updateProfileBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
    submitBtn.disabled = true;
    
    clearErrors();
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.profile.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('successMessage').textContent = data.message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    const errorElement = document.getElementById(`${field}Error`);
                    if (input && errorElement) {
                        input.classList.add('is-invalid');
                        errorElement.textContent = data.errors[field][0];
                    }
                });
                showAlert('Por favor corrige los errores en el formulario', 'error');
            } else {
                showAlert(data.message, 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function validatePasswordForm() {
    const currentPassword = document.querySelector('input[name="current_password"]').value.trim();
    const newPassword = document.querySelector('input[name="new_password"]').value.trim();
    const confirmPassword = document.querySelector('input[name="new_password_confirmation"]').value.trim();
    
    let isValid = true;
    
    clearErrors();
    
    if (!currentPassword) {
        document.querySelector('input[name="current_password"]').classList.add('is-invalid');
        document.getElementById('current_passwordError').textContent = 'La contraseña actual es obligatoria.';
        isValid = false;
    }
    
    if (!newPassword) {
        document.querySelector('input[name="new_password"]').classList.add('is-invalid');
        document.getElementById('new_passwordError').textContent = 'La nueva contraseña es obligatoria.';
        isValid = false;
    } else if (newPassword.length < 6) {
        document.querySelector('input[name="new_password"]').classList.add('is-invalid');
        document.getElementById('new_passwordError').textContent = 'La contraseña debe tener al menos 6 caracteres.';
        isValid = false;
    }
    
    if (!confirmPassword) {
        document.querySelector('input[name="new_password_confirmation"]').classList.add('is-invalid');
        document.getElementById('new_password_confirmationError').textContent = 'Debes confirmar la nueva contraseña.';
        isValid = false;
    } else if (newPassword !== confirmPassword) {
        document.querySelector('input[name="new_password_confirmation"]').classList.add('is-invalid');
        document.getElementById('new_password_confirmationError').textContent = 'Las contraseñas no coinciden.';
        isValid = false;
    }
    
    return isValid;
}


document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validatePasswordForm()) {
        showAlert('Por favor corrige los errores en el formulario', 'error');
        return;
    }
    
    const submitBtn = document.getElementById('updatePasswordBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Cambiando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.profile.password") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('successMessage').textContent = data.message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            this.reset();
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    const errorElement = document.getElementById(`${field}Error`);
                    if (input && errorElement) {
                        input.classList.add('is-invalid');
                        errorElement.textContent = data.errors[field][0];
                    }
                });
                showAlert('Por favor corrige los errores en el formulario', 'error');
            } else {
                showAlert(data.message, 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

document.querySelector('input[name="new_password_confirmation"]').addEventListener('input', function() {
    const newPassword = document.querySelector('input[name="new_password"]').value;
    const confirmation = this.value;
    
    if (confirmation && newPassword !== confirmation) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
        document.getElementById('new_password_confirmationError').textContent = 'Las contraseñas no coinciden';
    } else if (confirmation && newPassword === confirmation) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
        document.getElementById('new_password_confirmationError').textContent = '';
    } else {
        this.classList.remove('is-valid', 'is-invalid');
        document.getElementById('new_password_confirmationError').textContent = '';
    }
});

document.querySelector('input[name="telefono"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9+-\s]/g, '');
});

document.querySelector('input[name="nombre"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
});

document.querySelector('input[name="apellidos"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
});
</script>
@endsection