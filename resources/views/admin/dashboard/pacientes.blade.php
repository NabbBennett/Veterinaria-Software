@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Pacientes</h4>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoPacienteModal">
        <i class="bi bi-plus-circle"></i> Nuevo Paciente
    </button>
</div>

<!-- Modal para nuevo paciente -->
<div class="modal fade" id="nuevoPacienteModal" tabindex="-1" role="dialog" aria-labelledby="nuevoPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form><!-- Muevo el formulario para envolver body + footer -->
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoPacienteModalLabel">Añadir Nuevo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del dueño</label>
                        <input name="owner_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de la mascota</label>
                        <input name="pet_name" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especie</label>
                        <input name="species" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Raza</label>
                        <input name="breed" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Edad de la mascota</label>
                        <input name="age" type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Peso</label>
                        <input name="weight" type="number" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Buscador -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">BUSCADOR</h5>
        <div class="row">
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="Buscar por nombre de mascota o dueño...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-primary w-100">Buscar</button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Pacientes -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre de mascota</th>
                        <th>Dueño</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Max</td>
                        <td>Juan Pérez</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">VER HISTORIAL</button>
                            <button class="btn btn-sm btn-outline-warning">MODIFICAR</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Luna</td>
                        <td>María García</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">VER HISTORIAL</button>
                            <button class="btn btn-sm btn-outline-warning">MODIFICAR</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Rocky</td>
                        <td>Carlos López</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">VER HISTORIAL</button>
                            <button class="btn btn-sm btn-outline-warning">MODIFICAR</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection