<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #{{ $venta->id }}</title>
    <style>
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none !important; }
            @page { margin: 0; size: 80mm auto; }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            line-height: 1.2;
        }
        
        .ticket-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .ticket-header h1 {
            font-size: 14px;
            margin: 3px 0;
            font-weight: bold;
        }
        
        .ticket-info {
            margin-bottom: 8px;
        }
        
        .ticket-info p {
            margin: 2px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .items-table th {
            border-bottom: 1px solid #000;
            padding: 3px 0;
            text-align: left;
        }
        
        .items-table td {
            padding: 2px 0;
            border-bottom: 1px dashed #ccc;
        }
        
        .total-section {
            border-top: 2px solid #000;
            margin-top: 8px;
            padding-top: 8px;
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #666;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 2px;
        }
    </style>
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
            <!-- CORREGIDO: usar detalleVentas en lugar de detalles -->
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
        // Auto-imprimir cuando se abra la ventana
        window.onload = function() {
            window.print();
        };
        
        // Cerrar ventana después de imprimir
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 500);
        };
    </script>
</body>
</html>