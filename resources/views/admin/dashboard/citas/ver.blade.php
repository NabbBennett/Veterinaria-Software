
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <strong>Paciente:</strong>
            <p>{{ $cita->paciente->nombre ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <strong>Dueño:</strong>
            <p>{{ $cita->paciente->propietario ?? 'N/A' }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <strong>Fecha:</strong>
            <p>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
        </div>
        <div class="col-md-6">
            <strong>Hora:</strong>
            <p>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <strong>Estado:</strong>
            <p>
                <span class="badge bg-{{ $cita->estado === 'pendiente' ? 'warning' : ($cita->estado === 'confirmada' ? 'success' : ($cita->estado === 'completada' ? 'primary' : 'danger')) }}">
                    {{ ucfirst($cita->estado) }}
                </span>
            </p>
        </div>
        <div class="col-md-6">
            <strong>Costo:</strong>
            <p>${{ number_format($cita->costo, 2) }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <strong>Motivo:</strong>
            <p>{{ $cita->motivo }}</p>
        </div>
    </div>
    
    @if($cita->servicio)
    <div class="row">
        <div class="col-12">
            <strong>Servicio:</strong>
            <p>{{ $cita->servicio->nombre }}</p>
        </div>
    </div>
    @endif
    
    @if($cita->diagnostico)
    <div class="row">
        <div class="col-12">
            <strong>Diagnóstico:</strong>
            <p>{{ $cita->diagnostico }}</p>
        </div>
    </div>
    @endif
    
    @if($cita->tratamiento)
    <div class="row">
        <div class="col-12">
            <strong>Tratamiento:</strong>
            <p>{{ $cita->tratamiento }}</p>
        </div>
    </div>
    @endif
</div>