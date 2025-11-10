<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #{{ $venta->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin/ticket.css') }}">
</head>
<body>
    <div class="ticket-header">
        <h1>VETERINARIA MASCOTAS FELICES</h1>
        <p><strong>RFC:</strong> VMF123456789</p>
        <p><strong>Tel:</strong> (555) 123-4567</p>
        <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="ticket-info">
        <p><strong>Ticket #:</strong> {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Atendió:</strong> {{ $venta->user->name ?? 'Sistema' }}</p>
        @if($venta->paciente)
        <p><strong>Paciente:</strong> {{ $venta->paciente->nombre }}</p>
        <p><strong>Propietario:</strong> {{ $venta->paciente->propietario }}</p>
        @endif
        <p><strong>Método de pago:</strong> {{ ucfirst($venta->tipo_pago) }}</p>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="text-right">Cant</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Subtotal</th>
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
                <td class="text-right">{{ $detalle->cantidad }}</td>
                <td class="text-right">${{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total-section">
        <p><strong>SUBTOTAL: ${{ number_format($venta->subtotal, 2) }}</strong></p>
        <p><strong>TOTAL: ${{ number_format($venta->total, 2) }}</strong></p>
    </div>
    
    <div class="barcode">
        *{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}*
    </div>
    
    <div class="footer">
        <p>¡Gracias por su preferencia!</p>
        <p>Veterinaria Mascotas Felices</p>
        <p>www.mascotasfelices.com</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
        
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 500);
        };
    </script>
</body>
</html>