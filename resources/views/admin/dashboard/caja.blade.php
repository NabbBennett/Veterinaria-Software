@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Caja</h4>
    <div>
        <button type="button" class="btn btn-warning me-2" onclick="limpiarVentaManual()">
            <i class="bi bi-arrow-clockwise"></i> Limpiar Venta
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaVentaModal">
            <i class="bi bi-plus-circle"></i> Nueva Venta
        </button>
    </div>
</div>

<div class="modal fade" id="nuevaVentaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formNuevaVenta">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de Venta</label>
                                <select name="tipo_venta" class="form-select" id="tipoVentaSelect" required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="producto">Producto del Inventario</option>
                                    <option value="servicio">Servicio Disponible</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Paciente (Opcional)</label>
                                <select name="paciente_id" class="form-select" id="pacienteSelect">
                                    <option value="">Seleccionar paciente</option>
                                    @isset($pacientes)
                                        @foreach($pacientes as $paciente)
                                            <option value="{{ $paciente->id }}">
                                                {{ $paciente->nombre }} ({{ $paciente->propietario }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No hay pacientes disponibles</option>
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="productosSection" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <select name="producto_id" class="form-select" id="productoSelect">
                                <option value="">Seleccionar producto</option>
                                @isset($productos)
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-precio="{{ $producto->precio_venta }}"
                                                data-stock="{{ $producto->stock }}">
                                            {{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 2) }} (Stock: {{ $producto->stock }})
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No hay productos disponibles</option>
                                @endisset
                            </select>
                        </div>
                    </div>

                    <div id="serviciosSection" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Servicio Disponible</label>
                            <select name="servicio_id" class="form-select" id="servicioSelect">
                                <option value="">Seleccionar servicio</option>
                                @if(isset($servicios) && $servicios->count() > 0)
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}">
                                            {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                            @if($servicio->tipo)
                                                <small class="text-muted">({{ ucfirst($servicio->tipo) }})</small>
                                            @endif
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No hay servicios disponibles</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" value="1" min="1" id="cantidadInput">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Precio Unitario</label>
                                <input type="number" name="precio_unitario" class="form-control" step="0.01" min="0" id="precioUnitarioInput" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" class="form-control" step="0.01" min="0" id="subtotalInput" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Pago</label>
                        <select name="tipo_pago" class="form-select" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar a Venta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle"></i> Venta Registrada Exitosamente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="ticketContent">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" onclick="imprimirTicket()">
                    <i class="bi bi-printer"></i> Imprimir Ticket
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">REGISTRO DE VENTAS</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ARTÍCULO</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO</th>
                        <th>SUBTOTAL</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody id="tablaVentas">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>TOTAL: <span class="text-primary" id="totalVenta">$0.00</span></h4>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-success btn-lg" id="btnFinalizarVenta">
                    <i class="bi bi-cart-check"></i> FINALIZAR VENTA
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let ventaActual = [];
let ventaIdActual = null;


function cargarVentaDesdeStorage() {
    const ventaGuardada = localStorage.getItem('ventaActualCaja');
    if (ventaGuardada) {
        try {
            ventaActual = JSON.parse(ventaGuardada);
            actualizarTablaVentas();
            console.log('Venta anterior recuperada:', ventaActual.length, 'artículos');
        } catch (e) {
            console.error('Error al cargar venta desde storage:', e);
            ventaActual = [];
        }
    }
}

function guardarVentaEnStorage() {
    try {
        localStorage.setItem('ventaActualCaja', JSON.stringify(ventaActual));
        console.log('Venta guardada en storage:', ventaActual.length, 'artículos');
    } catch (e) {
        console.error('Error al guardar venta en storage:', e);
    }
}

function limpiarVentaStorage() {
    localStorage.removeItem('ventaActualCaja');
    console.log('Venta limpiada del storage');
}

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

document.getElementById('tipoVentaSelect').addEventListener('change', function() {
    const tipo = this.value;
    document.getElementById('productosSection').style.display = tipo === 'producto' ? 'block' : 'none';
    document.getElementById('serviciosSection').style.display = tipo === 'servicio' ? 'block' : 'none';
    document.getElementById('precioUnitarioInput').value = '';
    document.getElementById('subtotalInput').value = '';
    document.getElementById('cantidadInput').disabled = false;
});

document.getElementById('productoSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const precio = selectedOption.getAttribute('data-precio');
    const stock = parseInt(selectedOption.getAttribute('data-stock'));
    
    if (precio) {
        document.getElementById('precioUnitarioInput').value = precio;
        document.getElementById('cantidadInput').max = stock;
        calcularSubtotal();
    }
});

document.getElementById('servicioSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const precio = selectedOption.getAttribute('data-precio');
    
    if (precio) {
        document.getElementById('precioUnitarioInput').value = precio;
        document.getElementById('cantidadInput').value = 1;
        document.getElementById('cantidadInput').disabled = true; 
        calcularSubtotal();
    }
});

document.getElementById('cantidadInput').addEventListener('input', calcularSubtotal);

function calcularSubtotal() {
    const cantidad = parseInt(document.getElementById('cantidadInput').value) || 0;
    const precio = parseFloat(document.getElementById('precioUnitarioInput').value) || 0;
    const subtotal = cantidad * precio;
    
    document.getElementById('subtotalInput').value = subtotal.toFixed(2);
}


document.getElementById('formNuevaVenta').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const tipoVenta = document.getElementById('tipoVentaSelect').value;
    const productoId = document.getElementById('productoSelect').value;
    const servicioId = document.getElementById('servicioSelect').value;
    const cantidad = parseInt(document.getElementById('cantidadInput').value);
    const precioUnitario = parseFloat(document.getElementById('precioUnitarioInput').value);
    const subtotal = parseFloat(document.getElementById('subtotalInput').value);
    
    if (!tipoVenta) {
        showAlert('Selecciona el tipo de venta', 'error');
        return;
    }
    
    if (tipoVenta === 'producto' && !productoId) {
        showAlert('Selecciona un producto', 'error');
        return;
    }
    
    if (tipoVenta === 'servicio' && !servicioId) {
        showAlert('Selecciona un servicio', 'error');
        return;
    }
    
    if (cantidad <= 0) {
        showAlert('La cantidad debe ser mayor a 0', 'error');
        return;
    }
    
    if (tipoVenta === 'producto') {
        const selectedOption = document.getElementById('productoSelect').options[document.getElementById('productoSelect').selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock'));
        
        if (cantidad > stock) {
            showAlert(`Stock insuficiente. Solo hay ${stock} unidades disponibles`, 'error');
            return;
        }
    }
    
    const item = {
        tipo: tipoVenta,
        producto_id: tipoVenta === 'producto' ? productoId : null,
        servicio_id: tipoVenta === 'servicio' ? servicioId : null,
        cantidad: cantidad,
        precio_unitario: precioUnitario,
        subtotal: subtotal,
        nombre: tipoVenta === 'producto' 
            ? document.getElementById('productoSelect').options[document.getElementById('productoSelect').selectedIndex].text.split(' - ')[0]
            : document.getElementById('servicioSelect').options[document.getElementById('servicioSelect').selectedIndex].text.split(' - ')[0],
        timestamp: Date.now()
    };
    
    ventaActual.push(item);
    actualizarTablaVentas();
    guardarVentaEnStorage();
    
    this.reset();
    document.getElementById('productosSection').style.display = 'none';
    document.getElementById('serviciosSection').style.display = 'none';
    document.getElementById('cantidadInput').disabled = false;
    document.getElementById('tipoVentaSelect').value = '';
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('nuevaVentaModal'));
    modal.hide();
    
    showAlert('Artículo agregado a la venta', 'success');
});

function actualizarTablaVentas() {
    const tabla = document.getElementById('tablaVentas');
    const totalElement = document.getElementById('totalVenta');
    
    tabla.innerHTML = '';
    
    if (ventaActual.length === 0) {
        tabla.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay artículos en la venta</td></tr>';
        totalElement.textContent = '$0.00';
        return;
    }
    
    let total = 0;
    
    ventaActual.forEach((item, index) => {
        total += item.subtotal;
        
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${item.nombre}</td>
            <td>${item.cantidad}</td>
            <td>$${item.precio_unitario.toFixed(2)}</td>
            <td>$${item.subtotal.toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarItemVenta(${index})">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </td>
        `;
        tabla.appendChild(fila);
    });
    
    totalElement.textContent = `$${total.toFixed(2)}`;
}

function eliminarItemVenta(index) {
    if (confirm('¿Estás seguro de que quieres eliminar este artículo de la venta?')) {
        ventaActual.splice(index, 1);
        actualizarTablaVentas();
        guardarVentaEnStorage();
        showAlert('Artículo eliminado de la venta', 'success');
    }
}

document.getElementById('btnFinalizarVenta').addEventListener('click', function() {
    if (ventaActual.length === 0) {
        showAlert('No hay artículos en la venta', 'error');
        return;
    }
    
    if (!confirm('¿Estás seguro de que quieres finalizar esta venta?')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('items', JSON.stringify(ventaActual));
    formData.append('paciente_id', document.getElementById('pacienteSelect').value);
    formData.append('tipo_pago', document.querySelector('select[name="tipo_pago"]').value);
    
    fetch('{{ route("admin.dashboard.caja.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Venta registrada exitosamente', 'success');
            ventaIdActual = data.venta_id;
            
            ventaActual = [];
            actualizarTablaVentas();
            limpiarVentaStorage();
            
            mostrarTicketEnModal();
            
        } else {
            showAlert(data.message || 'Error al registrar la venta', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
    });
});

function mostrarTicketEnModal() {
    if (!ventaIdActual) {
        showAlert('No hay venta para mostrar', 'error');
        return;
    }
    
    fetch(`{{ url('admin/dashboard/caja/ticket') }}/${ventaIdActual}/ver`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('ticketContent').innerHTML = data.html;
                
                const ticketModal = new bootstrap.Modal(document.getElementById('ticketModal'));
                ticketModal.show();
                
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al cargar el ticket', 'error');
        });
}

function imprimirTicket() {
    if (!ventaIdActual) {
        showAlert('No hay venta para imprimir', 'error');
        return;
    }
    
    const url = `{{ url('admin/dashboard/caja/ticket') }}/${ventaIdActual}`;
    const printWindow = window.open(url, '_blank');
    
    printWindow.onload = function() {
        printWindow.print();
    };
}

function limpiarVentaManual() {
    if (ventaActual.length === 0) {
        showAlert('No hay venta que limpiar', 'info');
        return;
    }
    
    if (confirm('¿Estás seguro de que quieres limpiar toda la venta actual?')) {
        ventaActual = [];
        actualizarTablaVentas();
        limpiarVentaStorage();
        showAlert('Venta limpiada exitosamente', 'success');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const limpiarBtn = document.querySelector('.btn-warning');
    if (limpiarBtn) {
        limpiarBtn.onclick = limpiarVentaManual;
    }
    
    cargarVentaDesdeStorage();
    
    actualizarTablaVentas();
    
    window.addEventListener('beforeunload', function() {
        if (ventaActual.length > 0) {
            guardarVentaEnStorage();
        }
    });
    
    console.log('Sistema de caja inicializado con modal de tickets');
});
</script>
@endsection