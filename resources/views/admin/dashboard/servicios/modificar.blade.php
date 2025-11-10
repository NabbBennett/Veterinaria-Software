<div class="modal fade" id="modificarServicioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formModificarServicio">
                @csrf
                @method('PUT')
                <input type="hidden" name="servicio_id" id="servicio_id">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del servicio *</label>
                        <input name="nombre" id="edit_nombre" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Servicio *</label>
                        <select name="tipo" id="edit_tipo" class="form-control" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="estetica">Estética</option>
                            <option value="consulta">Consulta General</option>
                            <option value="cirugia">Cirugía</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio *</label>
                        <input name="precio" id="edit_precio" type="number" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" onclick="eliminarServicio()">
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
// Editar servicio
function editarServicio(servicioId) {
    fetch(`/admin/dashboard/servicios/${servicioId}/edit`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('servicio_id').value = data.id;
        document.getElementById('edit_nombre').value = data.nombre;
        document.getElementById('edit_tipo').value = data.tipo;
        document.getElementById('edit_precio').value = data.precio;
        document.getElementById('edit_descripcion').value = data.descripcion;
        
        const modal = new bootstrap.Modal(document.getElementById('modificarServicioModal'));
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar datos del servicio', 'error');
    });
}

// Actualizar servicio
document.getElementById('formModificarServicio').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
    submitBtn.disabled = true;
    
    const servicioId = document.getElementById('servicio_id').value;
    const formData = new FormData(this);
    
    fetch(`/admin/dashboard/servicios/${servicioId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-HTTP-Method-Override': 'PUT'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modificarServicioModal'));
            modal.hide();
            
            showAlert('Servicio actualizado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al actualizar el servicio', 'error');
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

// Eliminar servicio
function eliminarServicio() {
    const servicioId = document.getElementById('servicio_id').value;
    
    if (!confirm('¿Estás seguro de que quieres eliminar este servicio?')) {
        return;
    }
    
    fetch(`/admin/dashboard/servicios/${servicioId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modificarServicioModal'));
            modal.hide();
            
            showAlert('Servicio eliminado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al eliminar el servicio', 'error');
        }
    });
}
</script>