@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Citas</h4>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaCitaModal">
        <i class="bi bi-plus-circle"></i> Nueva Cita
    </button>
</div>

<div class="modal fade" id="nuevaCitaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formNuevaCita">
                @csrf
                
        <input type="hidden" name="user_id" value="{{ session('admin_id') }}">

                <div class="modal-header">
                    <h5 class="modal-title">Agendar Nueva Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Paciente *</label>
                                <select name="paciente_id" class="form-select" required>
                                    <option value="">Seleccionar paciente</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">
                                            {{ $paciente->nombre }} ({{ $paciente->propietario }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Servicio</label>
                                <select name="servicio_id" class="form-select">
                                    <option value="">Seleccionar servicio</option>
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}">
                                            {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha *</label>
                                <input type="date" name="fecha" class="form-control" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora *</label>
                                <input type="time" name="hora" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Motivo de la consulta *</label>
                        <textarea name="motivo" class="form-control" rows="3" placeholder="Describa el motivo de la consulta..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Costo *</label>
                                <input type="number" name="costo" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="confirmada">Confirmada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agendar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">CALENDARIO DE CITAS</h5>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 id="mesActual">MES ACTUAL</h6>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-sm btn-outline-primary me-2" id="mesAnterior">‹</button>
                <span class="fw-bold" id="fechaActual">{{ now()->format('F Y') }}</span>
                <button class="btn btn-sm btn-outline-primary ms-2" id="mesSiguiente">›</button>
            </div>
        </div>

        <div class="row text-center fw-bold mb-3">
            <div class="col p-2 border">Lu</div>
            <div class="col p-2 border">Ma</div>
            <div class="col p-2 border">Mi</div>
            <div class="col p-2 border">Ju</div>
            <div class="col p-2 border">Vi</div>
            <div class="col p-2 border">Sa</div>
            <div class="col p-2 border">Do</div>
        </div>

        <div class="row text-center" id="calendario">

        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title" id="tituloCitasDia">CITAS DE HOY - {{ now()->format('d/m/Y') }}</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Dueño</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaCitas">
                    @forelse($citasHoy as $cita)
                    <tr data-cita-id="{{ $cita->id }}">
                        <td>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</td>
                        <td>{{ $cita->paciente->nombre }}</td>
                        <td>{{ $cita->paciente->propietario }}</td>
                        <td>{{ Str::limit($cita->motivo, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $cita->estado_color }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" onclick="verDetallesCita({{ $cita->id }})">
                                <i class="bi bi-eye"></i> Ver
                            </button>
                            <button class="btn btn-sm btn-outline-warning" onclick="editarCita({{ $cita->id }})">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="eliminarCita({{ $cita->id }})">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            <i class="bi bi-calendar-x"></i> SIN CITAS
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleCitaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleCitaContent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editarCitaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarCita">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editarCitaContent">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let fechaActual = new Date();
let fechaSeleccionada = new Date();

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

document.addEventListener('DOMContentLoaded', function() {
    const servicioSelect = document.querySelector('select[name="servicio_id"]');
    if (servicioSelect) {
        servicioSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            const costoInput = document.querySelector('input[name="costo"]');
            if (precio && costoInput) {
                costoInput.value = precio;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const formNuevaCita = document.getElementById('formNuevaCita');
    if (!formNuevaCita) return;

    formNuevaCita.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Agendando...';
        submitBtn.disabled = true;

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("admin.dashboard.citas.store") }}', {
                method: 'POST',
                credentials: 'same-origin', // 🔹 ENVÍA LAS COOKIES (SESIÓN)
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                console.error('Error en respuesta del servidor:', data);
                const mensaje = data?.message || 'Error al procesar la solicitud';
                showAlert(mensaje, 'error');
                return;
            }

            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('nuevaCitaModal'));
                if (modal) modal.hide();

                this.reset();
                showAlert('Cita agendada exitosamente', 'success');
                cargarCitasDelDia(fechaSeleccionada);
            } else {
                showAlert(data.message || 'Error al agendar la cita', 'error');
            }

        } catch (error) {
            console.error('Error en fetch:', error);
            showAlert('Error de conexión con el servidor', 'error');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
});


function buscarCitas() {
    const texto = document.getElementById('buscadorCitas').value.toLowerCase().trim();
    const filas = document.querySelectorAll('#tablaCitas tr');
    let encontradas = 0;
    
    filas.forEach(fila => {
        if (fila.querySelector('td[colspan]')) {
            fila.style.display = 'none';
            return;
        }
        
        const textoFila = fila.textContent.toLowerCase();
        const mostrar = texto === '' || textoFila.includes(texto);
        fila.style.display = mostrar ? '' : 'none';
        
        if (mostrar) {
            encontradas++;
        }
    });
    
    const tabla = document.getElementById('tablaCitas');
    const mensajeExistente = tabla.querySelector('.no-results');
    
    if (mensajeExistente) {
        mensajeExistente.remove();
    }
    
    if (encontradas === 0 && texto !== '') {
        const mensaje = document.createElement('tr');
        mensaje.className = 'no-results';
        mensaje.innerHTML = `
            <td colspan="6" class="text-center text-muted py-3">
                <i class="bi bi-search"></i> No se encontraron citas que coincidan con "${texto}"
            </td>
        `;
        tabla.appendChild(mensaje);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorCitas');
    if (buscador) {
        buscador.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarCitas();
            }
        });
    }
});

function verDetallesCita(citaId) {
    fetch(`/admin/dashboard/citas/${citaId}/ver`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar los detalles');
            }
            return response.text();
        })
        .then(html => {
            const modalContent = document.getElementById('detalleCitaContent');
            modalContent.innerHTML = html;
            
            new bootstrap.Modal(document.getElementById('detalleCitaModal')).show();
        })
        .catch(error => {
            console.error('Error al cargar detalles de la cita:', error);
            showAlert('Error al cargar los detalles de la cita', 'error');
        });
}

function editarCita(citaId) {
    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('detalleCitaModal'));
    if (modalDetalles) modalDetalles.hide();

    fetch(`/admin/dashboard/citas/${citaId}/editar`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar formulario de edición');
            }
            return response.text();
        })
        .then(html => {
            const modalContent = document.getElementById('editarCitaContent');
            modalContent.innerHTML = html;
            
            const form = document.getElementById('formEditarCita');
            if (form) {
                form.action = `/admin/dashboard/citas/${citaId}`;
                
                const servicioSelect = modalContent.querySelector('select[name="servicio_id"]');
                if (servicioSelect) {
                    servicioSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const precio = selectedOption.getAttribute('data-precio');
                        const costoInput = modalContent.querySelector('input[name="costo"]');
                        if (precio && costoInput) {
                            costoInput.value = precio;
                        }
                    });
                }
            }
            
            new bootstrap.Modal(document.getElementById('editarCitaModal')).show();
        })
        .catch(error => {
            console.error('Error al cargar formulario de edición:', error);
            showAlert('Error al cargar el formulario de edición', 'error');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const formEditarCita = document.getElementById('formEditarCita');
    if (formEditarCita) {
        formEditarCita.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editarCitaModal'));
                    if (modal) modal.hide();
                    
                    showAlert('Cita actualizada exitosamente', 'success');
                    cargarCitasDelDia(fechaSeleccionada);
                } else {
                    showAlert(data.message || 'Error al actualizar la cita', 'error');
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
    }
});

function eliminarCita(citaId) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
        return;
    }

    fetch(`/admin/dashboard/citas/${citaId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Cita eliminada exitosamente', 'success');
            document.querySelector(`tr[data-cita-id="${citaId}"]`)?.remove();
            const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('detalleCitaModal'));
            if (modalDetalles) modalDetalles.hide();
            const modalEditar = bootstrap.Modal.getInstance(document.getElementById('editarCitaModal'));
            if (modalEditar) modalEditar.hide();
            
            const filasRestantes = document.querySelectorAll('#tablaCitas tr:not(.no-results)');
            if (filasRestantes.length === 0) {
                const tabla = document.getElementById('tablaCitas');
                tabla.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            <i class="bi bi-calendar-x"></i> SIN CITAS
                        </td>
                    </tr>
                `;
            }
        } else {
            showAlert(data.message || 'Error al eliminar la cita', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
    });
}

function inicializarCalendario() {
    actualizarHeader();
    generarCalendario();
    cargarCitasDelDia(fechaSeleccionada);
}

function cambiarMes(direccion) {
    fechaActual.setMonth(fechaActual.getMonth() + direccion);
    actualizarHeader();
    generarCalendario();
}

function actualizarHeader() {
    const opciones = { year: 'numeric', month: 'long' };
    const fechaActualElement = document.getElementById('fechaActual');
    if (fechaActualElement) {
        fechaActualElement.textContent = 
            fechaActual.toLocaleDateString('es-ES', opciones).toUpperCase();
    }
}

function generarCalendario() {
    const calendario = document.getElementById('calendario');
    if (!calendario) return;

    calendario.innerHTML = '';

    const año = fechaActual.getFullYear();
    const mes = fechaActual.getMonth();
    const primerDia = new Date(año, mes, 1);
    const ultimoDia = new Date(año, mes + 1, 0);
    let diaInicio = primerDia.getDay();
    diaInicio = diaInicio === 0 ? 6 : diaInicio - 1;

    let fecha = new Date(primerDia);
    fecha.setDate(fecha.getDate() - diaInicio);

    for (let semana = 0; semana < 6; semana++) {
        const fila = document.createElement('div');
        fila.className = 'row text-center';

        for (let dia = 0; dia < 7; dia++) {
            const celda = document.createElement('div');
            celda.className = 'col p-2 border position-relative calendar-day';
            celda.style.minHeight = '100px';
            celda.style.cursor = 'pointer';

            const diaNumero = fecha.getDate();
            const esMesActual = fecha.getMonth() === mes;
            const esHoy = esHoyFecha(fecha);
            const esSeleccionado = esMismaFecha(fecha, fechaSeleccionada);

            if (!esMesActual) {
                celda.classList.add('text-muted', 'bg-light');
            }
            if (esHoy) {
                celda.classList.add('bg-info', 'bg-opacity-10', 'fw-bold');
            }
            if (esSeleccionado) {
                celda.classList.add('bg-primary', 'text-white', 'selected-day');
            }

            const numeroDia = document.createElement('div');
            numeroDia.textContent = diaNumero;
            celda.appendChild(numeroDia);

            cargarContadorCitas(fecha, celda);

            const fechaCopia = new Date(fecha); 

            celda.addEventListener('click', function() {
                console.log('Día clickeado:', fechaCopia);
                fechaSeleccionada = fechaCopia;
                generarCalendario();
                cargarCitasDelDia(fechaSeleccionada);
            });

            fila.appendChild(celda);
            fecha.setDate(fecha.getDate() + 1);
        }

        calendario.appendChild(fila);
    }
}

function cargarContadorCitas(fecha, celda) {
    const fechaFormateada = formatearFechaParaAPI(fecha);
    
    fetch(`/admin/dashboard/citas/count?fecha=${fechaFormateada}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.count > 0) {
                const contador = document.createElement('div');
                contador.className = 'small mt-1';
                contador.textContent = data.count + ' Cita' + (data.count > 1 ? 's' : '');
                contador.style.color = celda.classList.contains('bg-primary') ? 'white' : '#dc3545';
                contador.style.fontWeight = 'bold';
                celda.appendChild(contador);
            }
        })
        .catch(error => {
            console.error('Error al cargar contador:', error);
        });
}

function cargarCitasDelDia(fecha) {
    const tituloCitas = document.getElementById('tituloCitasDia');
    const tablaCitas = document.getElementById('tablaCitas');

    if (!tituloCitas || !tablaCitas) return;

    // Formatear fecha para mostrar
    const fechaFormateada = fecha.toLocaleDateString('es-ES', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    tituloCitas.textContent = 'CITAS DEL ' + fechaFormateada.toUpperCase();

    tablaCitas.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-3">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <span class="ms-2">Cargando citas...</span>
            </td>
        </tr>
    `;

    const fechaFormateadaAPI = formatearFechaParaAPI(fecha);
    
    console.log('Cargando citas para fecha:', fechaFormateadaAPI);
    
    fetch(`/admin/dashboard/citas/por-fecha?fecha=${fechaFormateadaAPI}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar las citas');
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);
            
            if (!data.success) {
                throw new Error(data.message || 'Error en los datos');
            }

            const citas = data.citas;
            tablaCitas.innerHTML = '';

            if (citas.length === 0) {
                tablaCitas.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            <i class="bi bi-calendar-x"></i> SIN CITAS
                        </td>
                    </tr>
                `;
                return;
            }

            citas.forEach(cita => {
                const fechaHora = new Date(cita.fecha + 'T' + cita.hora);
                const estadoClass = {
                    'pendiente': 'warning',
                    'confirmada': 'success', 
                    'completada': 'primary',
                    'cancelada': 'danger'
                }[cita.estado] || 'secondary';

                const fila = document.createElement('tr');
                fila.setAttribute('data-cita-id', cita.id);
                fila.innerHTML = `
                    <td>${fechaHora.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })}</td>
                    <td>${cita.paciente?.nombre || 'N/A'}</td>
                    <td>${cita.paciente?.propietario || 'N/A'}</td>
                    <td>${cita.motivo.length > 50 ? cita.motivo.substring(0, 50) + '...' : cita.motivo}</td>
                    <td>
                        <span class="badge bg-${estadoClass}">${cita.estado}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" onclick="verDetallesCita(${cita.id})">
                            <i class="bi bi-eye"></i> Ver
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="editarCita(${cita.id})">
                            <i class="bi bi-pencil"></i> Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarCita(${cita.id})">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tablaCitas.appendChild(fila);
            });
        })
        .catch(error => {
            console.error('Error al cargar citas:', error);
            console.log('URL intentada:', `/admin/dashboard/citas/por-fecha?fecha=${fechaFormateadaAPI}`);
            tablaCitas.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger py-3">
                        <i class="bi bi-exclamation-triangle"></i> Error al cargar las citas
                        <br><small>${error.message}</small>
                    </td>
                </tr>
            `;
        });
}

function formatearFechaParaAPI(fecha) {
    const year = fecha.getFullYear();
    const month = String(fecha.getMonth() + 1).padStart(2, '0');
    const day = String(fecha.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function esHoyFecha(fecha) {
    const hoy = new Date();
    return fecha.getDate() === hoy.getDate() &&
           fecha.getMonth() === hoy.getMonth() &&
           fecha.getFullYear() === hoy.getFullYear();
}

function esMismaFecha(fecha1, fecha2) {
    return fecha1.getDate() === fecha2.getDate() &&
           fecha1.getMonth() === fecha2.getMonth() &&
           fecha1.getFullYear() === fecha2.getFullYear();
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Inicializando calendario');
    
    inicializarCalendario();

    const mesAnterior = document.getElementById('mesAnterior');
    const mesSiguiente = document.getElementById('mesSiguiente');
    
    if (mesAnterior) {
        mesAnterior.addEventListener('click', () => cambiarMes(-1));
    }
    if (mesSiguiente) {
        mesSiguiente.addEventListener('click', () => cambiarMes(1));
    }

    console.log('Fecha actual:', fechaActual);
    console.log('Fecha seleccionada:', fechaSeleccionada);
});

window.verDetallesCita = verDetallesCita;
window.editarCita = editarCita;
window.eliminarCita = eliminarCita;
window.buscarCitas = buscarCitas;
window.cambiarMes = cambiarMes;
window.inicializarCalendario = inicializarCalendario;
</script>

<style>
.calendar-day:hover {
    background-color: #e9ecef !important;
    transition: background-color 0.2s ease;
}

.calendar-day.selected-day {
    background-color: #0d6efd !important;
    color: white !important;
    font-weight: bold;
}

.border {
    border: 1px solid #dee2e6 !important;
}

.position-relative {
    position: relative;
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

.bg-primary {
    background-color: #0d6efd !important;
}

.bg-info.bg-opacity-10 {
    background-color: rgba(13, 110, 253, 0.1) !important;
    border: 2px solid #0d6efd;
}
</style>
@endsection