@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Caja</h4>
    <button class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Venta
    </button>
</div>

<!-- Tabla de ventas -->
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Consulta General</td>
                        <td>1</td>
                        <td>$500.00</td>
                        <td>$500.00</td>
                    </tr>
                    <tr>
                        <td>Vacuna Triple</td>
                        <td>1</td>
                        <td>$350.00</td>
                        <td>$350.00</td>
                    </tr>
                    <tr>
                        <td>Antipulgas</td>
                        <td>1</td>
                        <td>$280.00</td>
                        <td>$280.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Total e impresión -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>TOTAL: <span class="text-primary">$1,130.00</span></h4>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-success btn-lg">
                    <i class="bi bi-printer"></i> IMPRIMIR TICKET
                </button>
            </div>
        </div>
    </div>
</div>
@endsection