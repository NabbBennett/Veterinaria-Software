@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Inventario</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
        <i class="bi bi-plus-circle"></i> Añadir Nuevo Producto
    </button>
</div>

<!-- Alertas de stock bajo -->
@if($productosBajos->count() > 0)
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i>
    <strong>Alerta:</strong> Tienes {{ $productosBajos->count() }} producto(s) con stock bajo.
</div>
@endif

<!-- Buscador -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">BUSCADOR</h5>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Buscar por nombre</label>
                <input type="text" id="buscadorNombre" class="form-control" placeholder="Nombre del producto...">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Categoría</label>
                <select id="buscadorCategoria" class="form-control">
                    <option value="">Todas las categorías</option>
                    <option value="medicina">Medicina</option>
                    <option value="vacuna">Vacunas</option>
                    <option value="alimento">Alimento</option>
                    <option value="juguete">Juguetes</option>
                    <option value="accesorio">Accesorios</option>
                    <option value="higiene">Higiene</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Estado de stock</label>
                <select id="buscadorStock" class="form-control">
                    <option value="">Todos</option>
                    <option value="bajo">Stock bajo</option>
                    <option value="normal">Stock normal</option>
                </select>
            </div>
            <div class="col-md-2 mb-3 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100" onclick="limpiarBusqueda()">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" id="contadorResultados">
                        Mostrando {{ $productos->count() }} productos
                    </small>
                    <button class="btn btn-outline-primary btn-sm" onclick="buscarProductos()">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Inventario -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">INVENTARIO</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ARTÍCULO</th>
                        <th>TIPO ARTÍCULO</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO VENTA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody id="tablaProductos">
                    @foreach($productos as $producto)
                    <tr data-producto-id="{{ $producto->id }}" 
                        data-nombre="{{ strtolower($producto->nombre) }}"
                        data-categoria="{{ $producto->categoria }}"
                        data-stock="{{ $producto->stock }}"
                        data-stock-minimo="{{ $producto->stock_minimo }}"
                        class="{{ $producto->stock <= $producto->stock_minimo ? 'table-warning' : '' }}">
                        <td>{{ $producto->nombre }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $producto->categoria }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-outline-danger" onclick="disminuirStock({{ $producto->id }})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="fw-bold {{ $producto->stock <= $producto->stock_minimo ? 'text-danger' : '' }}">
                                    {{ $producto->stock }}
                                </span>
                                <button class="btn btn-sm btn-outline-success" onclick="aumentarStock({{ $producto->id }})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td>${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning" onclick="editarProducto({{ $producto->id }})">
                                <i class="bi bi-pencil"></i> Modificar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formNuevoProducto">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input name="nombre" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Artículo</label>
                        <select name="categoria" class="form-control" required>
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
                        <label class="form-label">Precio de Venta</label>
                        <input name="precio_venta" type="number" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad Inicial</label>
                        <input name="stock" type="number" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock Mínimo</label>
                        <input name="stock_minimo" type="number" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluir modal de modificar -->
@include('admin.dashboard.inventario.modificar')

<script>
// Función principal de búsqueda
function buscarProductos() {
    const nombre = document.getElementById('buscadorNombre').value.toLowerCase();
    const categoria = document.getElementById('buscadorCategoria').value;
    const estadoStock = document.getElementById('buscadorStock').value;
    
    const filas = document.querySelectorAll('#tablaProductos tr');
    let resultados = 0;
    
    filas.forEach(fila => {
        const nombreProducto = fila.getAttribute('data-nombre');
        const categoriaProducto = fila.getAttribute('data-categoria');
        const stock = parseInt(fila.getAttribute('data-stock'));
        const stockMinimo = parseInt(fila.getAttribute('data-stock-minimo'));
        
        let coincide = true;
        
        // Filtro por nombre
        if (nombre && !nombreProducto.includes(nombre)) {
            coincide = false;
        }
        
        // Filtro por categoría
        if (categoria && categoriaProducto !== categoria) {
            coincide = false;
        }
        
        // Filtro por estado de stock
        if (estadoStock === 'bajo' && stock > stockMinimo) {
            coincide = false;
        } else if (estadoStock === 'normal' && stock <= stockMinimo) {
            coincide = false;
        }
        
        if (coincide) {
            fila.style.display = '';
            resultados++;
        } else {
            fila.style.display = 'none';
        }
    });
    
    // Actualizar contador
    document.getElementById('contadorResultados').textContent = `Mostrando ${resultados} de {{ $productos->count() }} productos`;
}

// Limpiar búsqueda
function limpiarBusqueda() {
    document.getElementById('buscadorNombre').value = '';
    document.getElementById('buscadorCategoria').value = '';
    document.getElementById('buscadorStock').value = '';
    
    const filas = document.querySelectorAll('#tablaProductos tr');
    filas.forEach(fila => {
        fila.style.display = '';
    });
    
    document.getElementById('contadorResultados').textContent = `Mostrando {{ $productos->count() }} productos`;
}

// Búsqueda en tiempo real
document.getElementById('buscadorNombre').addEventListener('input', function() {
    if (this.value.length === 0 || this.value.length >= 2) {
        buscarProductos();
    }
});

document.getElementById('buscadorCategoria').addEventListener('change', buscarProductos);
document.getElementById('buscadorStock').addEventListener('change', buscarProductos);

// Guardar nuevo producto
document.getElementById('formNuevoProducto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Guardando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.dashboard.inventario.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoProductoModal'));
            modal.hide();
            this.reset();
            
            showAlert('Producto guardado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al guardar el producto', 'error');
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

// Aumentar stock
function aumentarStock(productoId) {
    fetch(`/admin/dashboard/inventario/${productoId}/aumentar-stock`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Disminuir stock
function disminuirStock(productoId) {
    fetch(`/admin/dashboard/inventario/${productoId}/disminuir-stock`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Eliminar producto
function eliminarProducto(productoId) {
    if (!confirm('¿Estás seguro de que quieres eliminar este producto?')) {
        return;
    }
    
    fetch(`/admin/dashboard/inventario/${productoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Producto eliminado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('Error al eliminar el producto', 'error');
        }
    });
}

// Función para mostrar alertas
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

// Inicializar búsqueda al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    buscarProductos(); // Aplicar filtros iniciales si los hay
});
</script>
@endsection