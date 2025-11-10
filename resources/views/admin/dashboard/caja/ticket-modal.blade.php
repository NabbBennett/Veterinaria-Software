<div class="ticket-preview">
    <div class="ticket-header text-center border-bottom pb-2 mb-3">
        <h4 class="mb-1">VETERINARIA MASCOTAS FELICES</h4>
        <p class="mb-1 small"><strong>RFC:</strong> VMF123456789</p>
        <p class="mb-1 small"><strong>Tel:</strong> (555) 123-4567</p>
        <p class="mb-0 small"><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="ticket-info mb-3">
        <p class="mb-1"><strong>Ticket #:</strong> {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p class="mb-1"><strong>Atendió:</strong> {{ $venta->user->name ?? 'Sistema' }}</p>
        @if($venta->paciente)
        <p class="mb-1"><strong>Paciente:</strong> {{ $venta->paciente->nombre }}</p>
        <p class="mb-1"><strong>Propietario:</strong> {{ $venta->paciente->propietario }}</p>
        @endif
        <p class="mb-0"><strong>Método de pago:</strong> {{ ucfirst($venta->tipo_pago) }}</p>
    </div>
    
    <table class="table table-sm table-bordered">
        <thead class="table-light">
            <tr>
                <th>Descripción</th>
                <th class="text-end">Cant</th>
                <th class="text-end">Precio</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalleVentas as $detalle)
            <tr>
                <td>
                    @if($detalle->producto)
                        {{ $detalle->producto->nombre }}
                    @elseif($detalle->servicio)
                        {{ $detalle->servicio->nombre ?? 'Servicio' }}
                    @else
                        Artículo
                    @endif
                </td>
                <td class="text-end">{{ $detalle->cantidad }}</td>
                <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-end">${{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <td colspan="3" class="text-end"><strong>SUBTOTAL:</strong></td>
                <td class="text-end"><strong>${{ number_format($venta->subtotal, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                <td class="text-end"><strong>${{ number_format($venta->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="text-center mt-3">
        <div class="barcode mb-2" style="font-family: 'Courier New'; font-size: 18px; letter-spacing: 3px;">
            *{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}*
        </div>
        <p class="text-muted small mb-0">¡Gracias por su preferencia!</p>
        <p class="text-muted small mb-0">Veterinaria Mascotas Felices</p>
    </div>
</div>