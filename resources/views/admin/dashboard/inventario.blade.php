@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Inventario</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
        <i class="bi bi-plus-circle"></i> Añadir Nuevo Producto
    </button>
</div>

<!-- Tabla de Inventario -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">INVENTARIO</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ARTÍCULO</th>
                        <th>CANTIDAD</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vacuna Triple Felina</td>
                        <td>15</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">-</button>
                            <button class="btn btn-sm btn-outline-success">+</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Antipulgas para Perros</td>
                        <td>8</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">-</button>
                            <button class="btn btn-sm btn-outline-success">+</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Alimento Premium Gatos</td>
                        <td>22</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">-</button>
                            <button class="btn btn-sm btn-outline-success">+</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad Inicial</label>
                        <input type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar Producto</button>
            </div>
        </div>
    </div>
</div>
@endsection