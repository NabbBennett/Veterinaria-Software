@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Pacientes</h4>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoPacienteModal">
        <i class="bi bi-plus-circle"></i> Nuevo Paciente
    </button>
</div>

@include('admin.dashboard.paciente.modificar')
@include('admin.dashboard.paciente.historial')

<div class="modal fade" id="nuevoPacienteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formNuevoPaciente">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Nuevo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del dueño *</label>
                        <input name="owner_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono del dueño *</label>
                        <input name="telefono" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de la mascota *</label>
                        <input name="pet_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especie *</label>
                        <select name="species" class="form-control" required>
                            <option value="">Seleccionar especie</option>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Ave">Ave</option>
                            <option value="Roedor">Roedor</option>
                            <option value="Reptil">Reptil</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Raza *</label>
                        <input name="breed" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Edad (años) *</label>
                        <input name="age" type="number" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Peso (kg) *</label>
                        <input name="weight" type="number" step="0.1" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">BUSCADOR</h5>
        <div class="row">
            <div class="col-md-8">
                <input type="text" id="buscadorPacientes" class="form-control" placeholder="Buscar por nombre de mascota o dueño...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-primary w-100" onclick="buscarPacientes()">Buscar</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre de mascota</th>
                        <th>Dueño</th>
                        <th>Especie</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaPacientes">
                    @foreach($pacientes as $paciente)
                    <tr data-paciente-id="{{ $paciente->id }}">
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->propietario }}</td>
                        <td>{{ $paciente->especie }}</td>
                        <td>{{ $paciente->edad }} años</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" onclick="verHistorial({{ $paciente->id }})">
                                <i class="bi bi-clock-history"></i> HISTORIAL
                            </button>
                            <button class="btn btn-sm btn-outline-warning" onclick="editarPaciente({{ $paciente->id }})">
                                <i class="bi bi-pencil"></i> MODIFICAR
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
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
    }, 3000);
}

document.getElementById('formNuevoPaciente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Guardando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.pacientes.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoPacienteModal'));
            modal.hide();
            this.reset();
            
            showAlert('Paciente guardado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al guardar el paciente', 'error');
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

function buscarPacientes() {
    const texto = document.getElementById('buscadorPacientes').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaPacientes tr');
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(texto) ? '' : 'none';
    });
}
</script>
@endsection