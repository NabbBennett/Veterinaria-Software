<div class="modal fade" id="modificarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formModificarPaciente">
                @csrf
                @method('PUT')
                <input type="hidden" name="paciente_id" id="paciente_id">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del dueño *</label>
                        <input name="owner_name" id="edit_owner_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono del dueño *</label>
                        <input name="telefono" id="edit_telefono" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de la mascota *</label>
                        <input name="pet_name" id="edit_pet_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especie *</label>
                        <select name="species" id="edit_species" class="form-control" required>
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
                        <input name="breed" id="edit_breed" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Edad (años) *</label>
                        <input name="age" id="edit_age" type="number" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Peso (kg) *</label>
                        <input name="weight" id="edit_weight" type="number" step="0.1" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" onclick="eliminarPaciente()">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editarPaciente(pacienteId) {
    fetch(`/admin/dashboard/pacientes/${pacienteId}/edit`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('paciente_id').value = data.id;
        document.getElementById('edit_owner_name').value = data.propietario;
        document.getElementById('edit_telefono').value = data.telefono;
        document.getElementById('edit_pet_name').value = data.nombre;
        document.getElementById('edit_species').value = data.especie;
        document.getElementById('edit_breed').value = data.raza;
        document.getElementById('edit_age').value = data.edad;
        document.getElementById('edit_weight').value = data.peso;
        
        const modal = new bootstrap.Modal(document.getElementById('modificarModal'));
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar datos del paciente', 'error');
    });
}

document.getElementById('formModificarPaciente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
    submitBtn.disabled = true;
    
    const pacienteId = document.getElementById('paciente_id').value;
    const formData = new FormData(this);
    
    fetch(`/admin/dashboard/pacientes/${pacienteId}`, {
        method: 'POST', 
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-HTTP-Method-Override': 'PUT' // Esto indica que es una actualización
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modificarModal'));
            modal.hide();
            
            showAlert('Paciente actualizado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(data.error || 'Error al actualizar el paciente', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión: ' + error.message, 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function eliminarPaciente() {
    if (!confirm('¿Estás seguro de que quieres eliminar este paciente? Esta acción no se puede deshacer.')) {
        return;
    }
    
    const pacienteId = document.getElementById('paciente_id').value;
    
    fetch(`/admin/dashboard/pacientes/${pacienteId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modificarModal'));
            modal.hide();
            
            showAlert('Paciente eliminado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al eliminar el paciente', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
    });
}
</script>