<div class="modal fade" id="historialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial Médico - <span id="nombreMascotaHistorial"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Información del Paciente</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Propietario:</strong> <span id="propietarioHistorial"></span><br>
                                <strong>Teléfono:</strong> <span id="telefonoHistorial"></span><br>
                                <strong>Especie:</strong> <span id="especieHistorial"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Raza:</strong> <span id="razaHistorial"></span><br>
                                <strong>Edad:</strong> <span id="edadHistorial"></span> años<br>
                                <strong>Peso:</strong> <span id="pesoHistorial"></span> kg
                            </div>
                        </div>
                    </div>
                </div>
                
                <h6>Historial de Servicios</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Servicio</th>
                                <th>Motivo</th>
                                <th>Costo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaHistorial">
                        </tbody>
                    </table>
                </div>
                
                <div id="sinHistorial" class="text-center py-4" style="display: none;">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <h5 class="text-muted mt-3">Sin historial</h5>
                    <p class="text-muted">No hay servicios registrados para este paciente.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function verHistorial(pacienteId) {
    const modalBody = document.querySelector('#historialModal .modal-body');
    const originalContent = modalBody.innerHTML;
    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando historial...</p>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('historialModal'));
    modal.show();
    
    fetch(`/admin/dashboard/pacientes/${pacienteId}`)
    .then(response => response.json())
    .then(data => {
        modalBody.innerHTML = originalContent;
        
        document.getElementById('nombreMascotaHistorial').textContent = data.paciente.nombre;
        document.getElementById('propietarioHistorial').textContent = data.paciente.propietario;
        document.getElementById('telefonoHistorial').textContent = data.paciente.telefono;
        document.getElementById('especieHistorial').textContent = data.paciente.especie;
        document.getElementById('razaHistorial').textContent = data.paciente.raza;
        document.getElementById('edadHistorial').textContent = data.paciente.edad;
        document.getElementById('pesoHistorial').textContent = data.paciente.peso;
        
        const tablaHistorial = document.getElementById('tablaHistorial');
        const sinHistorial = document.getElementById('sinHistorial');
        
        tablaHistorial.innerHTML = '';
        
        if (data.historial && data.historial.length > 0) {
            sinHistorial.style.display = 'none';
            data.historial.forEach(cita => {
                const fila = document.createElement('tr');
                const fecha = new Date(cita.fecha).toLocaleDateString('es-ES');
                const estadoClass = {
                    'pendiente': 'warning',
                    'confirmada': 'info',
                    'completada': 'success',
                    'cancelada': 'danger'
                }[cita.estado] || 'secondary';
                
                fila.innerHTML = `
                    <td>${fecha}</td>
                    <td>${cita.motivo}</td>
                    <td>${cita.motivo}</td>
                    <td>$${parseFloat(cita.costo).toFixed(2)}</td>
                    <td><span class="badge bg-${estadoClass}">${cita.estado}</span></td>
                `;
                tablaHistorial.appendChild(fila);
            });
        } else {
            sinHistorial.style.display = 'block';
            tablaHistorial.innerHTML = '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = originalContent;
        showAlert('Error al cargar el historial', 'error');
    });
}
</script>