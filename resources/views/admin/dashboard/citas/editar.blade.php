<div class="modal-body">
    <form id="formEditarCita">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Paciente *</label>
                    <select name="paciente_id" class="form-select" required>
                        <option value="">Seleccionar paciente</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombre }} ({{ $paciente->propietario }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Servicio</label>
                    <select name="servicio_id" class="form-select">
                        <option value="">Seleccionar servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" 
                                    data-precio="{{ $servicio->precio }}"
                                    {{ $cita->servicio_id == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Fecha *</label>
                    <input type="date" name="fecha" class="form-control" 
                           value="{{ \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Hora *</label>
                    <input type="time" name="hora" class="form-control" 
                           value="{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}" required>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Motivo de la consulta *</label>
            <textarea name="motivo" class="form-control" rows="3" required>{{ $cita->motivo }}</textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Costo *</label>
                    <input type="number" name="costo" class="form-control" 
                           value="{{ $cita->costo }}" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    </select>
                </div>
            </div>
        </div>        
        <input type="hidden" name="user_id" value="{{ $cita->user_id }}">
    </form>
</div>