@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Pacientes</h4>
    <button class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Paciente
    </button>
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