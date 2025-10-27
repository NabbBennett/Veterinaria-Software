@extends('admin.dashboard.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Gestión de Citas</h4>
    <button class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Cita
    </button>
</div>

<!-- Calendario de Citas -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">CALENDARIO DE CITAS</h5>
        
        <!-- Header del Calendario -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>MES ACTUAL</h6>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-sm btn-outline-primary me-2">‹</button>
                <span class="fw-bold">Enero 2025</span>
                <button class="btn btn-sm btn-outline-primary ms-2">›</button>
            </div>
        </div>

        <!-- Días de la semana -->
        <div class="row text-center fw-bold mb-3">
            <div class="col p-2 border">Lu</div>
            <div class="col p-2 border">Ma</div>
            <div class="col p-2 border">Mi</div>
            <div class="col p-2 border">Ju</div>
            <div class="col p-2 border">Vi</div>
            <div class="col p-2 border">Sa</div>
            <div class="col p-2 border">Do</div>
        </div>

        <!-- Semanas del mes -->
        <div class="row text-center">
            @for($i = 1; $i <= 35; $i++)
                <div class="col p-3 border" style="min-height: 100px;">
                    @if($i >= 1 && $i <= 31)
                        {{ $i }}
                        @if($i == 15)
                            <div class="small text-danger mt-1">3 Citas</div>
                        @endif
                    @endif
                </div>
                @if($i % 7 == 0)
                    </div><div class="row text-center">
                @endif
            @endfor
        </div>

        <!-- Lista de citas del día -->
        <div class="mt-4">
            <h6>CITAS DE HOY</h6>
            <div class="list-group">
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span>10:00 AM - Max (Vacunación)</span>
                        <button class="btn btn-sm btn-outline-primary">Ver</button>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span>2:00 PM - Luna (Consulta)</span>
                        <button class="btn btn-sm btn-outline-primary">Ver</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection