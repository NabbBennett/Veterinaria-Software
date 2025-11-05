@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Servicios</h4>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoServicioModal">
        <i class="bi bi-plus-circle"></i> Nuevo Servicio
    </button>
</div>

<!-- Modal para nuevo servicio -->
<div class="modal fade" id="nuevoServicioModal" tabindex="-1" role="dialog" aria-labelledby="nuevoServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form><!-- Muevo el formulario para envolver body + footer -->
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoServicioModalLabel">Añadir Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del servicio</label>
                        <input name="service_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input name="price" type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <input name="description" type="text" class="form-control" required>
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

<!-- Lista de Servicios -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Servicios Médicos</h5>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Consulta General
                        <span class="badge bg-primary">$500.00</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Vacunación
                        <span class="badge bg-primary">$350.00</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Desparasitación
                        <span class="badge bg-primary">$280.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Servicios de Estética</h5>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Baño y Corte
                        <span class="badge bg-primary">$400.00</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Corte de Uñas
                        <span class="badge bg-primary">$150.00</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Limpieza Dental
                        <span class="badge bg-primary">$600.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection