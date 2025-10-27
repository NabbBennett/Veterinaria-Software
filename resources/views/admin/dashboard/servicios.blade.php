@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Servicios</h4>
    <button class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Servicio
    </button>
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

<!-- Formulario para nuevo servicio -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Agregar Nuevo Servicio</h5>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Servicio</label>
                        <input type="text" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        </form>
    </div>
</div>
@endsection