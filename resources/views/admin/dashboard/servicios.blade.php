@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Servicios</h4>
    <div>
        <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#realizarServicioModal">
            <i class="bi bi-plus-circle"></i> Realizar Servicio
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoServicioModal">
            <i class="bi bi-plus-circle"></i> Nuevo Servicio
        </button>
    </div>
</div>

<div class="modal fade" id="realizarServicioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formRealizarServicio">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Realizar Servicio a Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Seleccionar Paciente *</label>
                            <select name="paciente_id" class="form-control" required>
                                <option value="">Seleccionar paciente</option>
                                @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nombre }} - {{ $paciente->propietario }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha del Servicio *</label>
                            <input name="fecha_servicio" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Selección de Servicios *</label>
                        <select name="servicio_id" class="form-control" required onchange="actualizarCamposServicio()">
                            <option value="">Seleccionar servicio</option>
                            @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" data-tipo="{{ $servicio->tipo }}" data-precio="{{ $servicio->precio }}">
                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="camposConsultaCirugia" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Padecimiento *</label>
                            <textarea name="padecimiento" class="form-control" rows="3" placeholder="Describa el padecimiento del paciente..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Receta Médica e Indicaciones</label>
                            <textarea name="receta_medica" class="form-control" rows="3" placeholder="Indique la receta médica y tratamiento..."></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones generales del servicio..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Servicio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="nuevoServicioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formNuevoServicio">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del servicio *</label>
                        <input name="nombre" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Servicio *</label>
                        <select name="tipo" class="form-control" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="estetica">Estética</option>
                            <option value="consulta">Consulta General</option>
                            <option value="cirugia">Cirugía</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio *</label>
                        <input name="precio" type="number" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.dashboard.servicios.modificar')

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Servicios Disponibles</h5>
                <div class="row">
                    @php
                    $serviciosPorTipo = $servicios->groupBy('tipo');
                    @endphp
                    
                    <div class="col-md-4">
                        <h6>Consulta General</h6>
                        <div class="list-group">
                            @foreach($serviciosPorTipo->get('consulta', []) as $servicio)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $servicio->nombre }}
                                    <br><small class="text-muted">{{ $servicio->descripcion }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">${{ number_format($servicio->precio, 2) }}</span>
                                    <button class="btn btn-sm btn-outline-warning mt-1" onclick="editarServicio({{ $servicio->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h6>Estética</h6>
                        <div class="list-group">
                            @foreach($serviciosPorTipo->get('estetica', []) as $servicio)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $servicio->nombre }}
                                    <br><small class="text-muted">{{ $servicio->descripcion }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">${{ number_format($servicio->precio, 2) }}</span>
                                    <button class="btn btn-sm btn-outline-warning mt-1" onclick="editarServicio({{ $servicio->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h6>Cirugía</h6>
                        <div class="list-group">
                            @foreach($serviciosPorTipo->get('cirugia', []) as $servicio)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $servicio->nombre }}
                                    <br><small class="text-muted">{{ $servicio->descripcion }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">${{ number_format($servicio->precio, 2) }}</span>
                                    <button class="btn btn-sm btn-outline-warning mt-1" onclick="editarServicio({{ $servicio->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-clock-history text-primary me-2"></i>Historial de Servicios Realizados
        </h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><i class="bi bi-calendar me-1"></i>Fecha</th>
                        <th><i class="bi bi-heart me-1"></i>Paciente</th>
                        <th><i class="bi bi-gear me-1"></i>Servicio</th>
                        <th><i class="bi bi-tag me-1"></i>Tipo</th>
                        <th><i class="bi bi-currency-dollar me-1"></i>Costo</th>
                        <th><i class="bi bi-person me-1"></i>Veterinario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviciosRealizados as $servicioRealizado)
                    <tr>
                        <td>{{ $servicioRealizado->fecha_servicio->format('d/m/Y') }}</td>
                        <td>{{ $servicioRealizado->paciente->nombre }}</td>
                        <td>{{ $servicioRealizado->servicio->nombre }}</td>
                        <td>
                            @if($servicioRealizado->servicio->tipo == 'consulta')
                                <span class="badge bg-primary">
                                    <i class="bi bi-heart-pulse me-1"></i>Consulta
                                </span>
                            @elseif($servicioRealizado->servicio->tipo == 'estetica')
                                <span class="badge bg-success">
                                    <i class="bi bi-scissors me-1"></i>Estética
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-prescription2 me-1"></i>Cirugía
                                </span>
                            @endif
                        </td>
                        <td>${{ number_format($servicioRealizado->costo_final, 2) }}</td>
                        <td>{{ $servicioRealizado->user->nombre }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function actualizarCamposServicio() {
    const servicioSelect = document.querySelector('select[name="servicio_id"]');
    const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
    const tipoServicio = selectedOption.getAttribute('data-tipo');
    const camposConsultaCirugia = document.getElementById('camposConsultaCirugia');
    
    if (tipoServicio === 'consulta' || tipoServicio === 'cirugia') {
        camposConsultaCirugia.style.display = 'block';
        document.querySelector('textarea[name="padecimiento"]').required = true;
    } else {
        camposConsultaCirugia.style.display = 'none';
        document.querySelector('textarea[name="padecimiento"]').required = false;
    }
}

document.getElementById('formRealizarServicio').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Registrando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.servicios.realizar") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('realizarServicioModal'));
            modal.hide();
            this.reset();
            
            showAlert('Servicio registrado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(data.error || 'Error al registrar el servicio', 'error');
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

document.getElementById('formNuevoServicio').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Guardando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.servicios.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoServicioModal'));
            modal.hide();
            this.reset();
            
            showAlert('Servicio creado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al crear el servicio', 'error');
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
</script>
@endsection