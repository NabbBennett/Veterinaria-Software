<div class="modal fade" id="modificarProductoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formModificarProducto">
                @csrf
                @method('PUT')
                <input type="hidden" name="producto_id" id="producto_id">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto *</label>
                        <input name="nombre" id="edit_nombre" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Artículo *</label>
                        <select name="categoria" id="edit_categoria" class="form-control" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="medicina">Medicina</option>
                            <option value="vacuna">Vacunas</option>
                            <option value="alimento">Alimento</option>
                            <option value="juguete">Juguetes</option>
                            <option value="accesorio">Accesorios</option>
                            <option value="higiene">Higiene</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio de Venta *</label>
                        <input name="precio_venta" id="edit_precio_venta" type="number" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" onclick="eliminarProductoDesdeModal()">
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
// Editar producto
function editarProducto(productoId) {
    fetch(`/admin/dashboard/inventario/${productoId}/edit`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('producto_id').value = data.id;
        document.getElementById('edit_nombre').value = data.nombre;
        document.getElementById('edit_categoria').value = data.categoria;
        document.getElementById('edit_precio_venta').value = data.precio_venta;
        document.getElementById('edit_descripcion').value = data.descripcion || '';
        
        const modal = new bootstrap.Modal(document.getElementById('modificarProductoModal'));
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar datos del producto', 'error');
    });
}

// Actualizar producto
document.getElementById('formModificarProducto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
    submitBtn.disabled = true;
    
    const productoId = document.getElementById('producto_id').value;
    const formData = new FormData(this);
    
    fetch(`/admin/dashboard/inventario/${productoId}`, {
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('modificarProductoModal'));
            modal.hide();
            
            showAlert('Producto actualizado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al actualizar el producto', 'error');
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

// Eliminar desde modal
function eliminarProductoDesdeModal() {
    const productoId = document.getElementById('producto_id').value;
    eliminarProducto(productoId);
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('modificarProductoModal'));
    modal.hide();
}
</script>