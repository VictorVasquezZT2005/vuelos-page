<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Boleto de Vuelo - SkyWings</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .container { width: 100%; margin: 0 auto; border: 2px solid #0d47a1; border-radius: 10px; }
        .header { background-color: #1a73e8; color: white; padding: 15px; text-align: center; border-bottom: 2px solid #0d47a1; border-radius: 8px 8px 0 0; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px; }
        .flight-info, .passenger-info { margin-bottom: 20px; }
        .flight-info table, .passenger-info table { width: 100%; border-collapse: collapse; }
        .flight-info th, .flight-info td, .passenger-info th, .passenger-info td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .flight-info th { background-color: #f2f2f2; width: 150px; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .barcode { text-align: center; margin-top: 25px; }
        .footer { text-align: center; padding: 10px; font-size: 10px; color: #777; border-top: 1px solid #eee; }
        .seat-badge { display: inline-block; background-color: #0d47a1; color: white; padding: 5px 10px; border-radius: 5px; margin-right: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SkyWings Airlines</h1>
            <p style="margin: 0; font-size: 16px;">Pase de Abordar</p>
        </div>
        <div class="content">
            <div class="passenger-info">
                <h3>Información del Pasajero</h3>
                <table>
                    <tr>
                        <th>Nombre del Pasajero:</th>
                        <td>{{ $reservacion->cliente->nombre }}</td>
                    </tr>
                    <tr>
                        <th>ID de Reservación:</th>
                        <td>#{{ $reservacion->id }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Reserva:</th>
                        <td>{{ $reservacion->fecha_reserva->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="flight-info">
                <h3>Detalles del Vuelo</h3>
                <table>
                    <tr>
                        <th>Vuelo:</th>
                        <td>{{ $reservacion->vuelo->codigo }}</td>
                    </tr>
                    <tr>
                        <th>Origen:</th>
                        <td>{{ $reservacion->vuelo->origen }}</td>
                    </tr>
                    <tr>
                        <th>Destino:</th>
                        <td>{{ $reservacion->vuelo->destino }}</td>
                    </tr>
                    <tr>
                        <th>Despegue:</th>
                        <td><strong>{{ \Carbon\Carbon::parse($reservacion->vuelo->fecha_salida)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($reservacion->vuelo->fecha_salida)->format('H:i') }} hrs</strong></td>
                    </tr>
                    <tr>
                        <th>Llegada Estimada:</th>
                        <td>{{ \Carbon\Carbon::parse($reservacion->vuelo->fecha_llegada)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($reservacion->vuelo->fecha_llegada)->format('H:i') }} hrs</td>
                    </tr>
                     <tr>
                        <th>Asientos Asignados:</th>
                        <td>
                            @foreach($reservacion->numeros_asiento as $asiento)
                                <span class="seat-badge">{{ $asiento }}</span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>

            <div class="total">
                @php
                    $precioTotal = $reservacion->asientos * $reservacion->vuelo->precio;
                @endphp
                Total Pagado: ${{ number_format($precioTotal, 2) }}
            </div>

            <div class="barcode">
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('SW'.$reservacion->id.'-'.$reservacion->vuelo->codigo, 'C128', 2, 60) }}" alt="barcode" />
                <p>SW{{ $reservacion->id }}-{{ $reservacion->vuelo->codigo }}</p>
            </div>
        </div>
        <div class="footer">
            <p>Gracias por volar con SkyWings. Por favor, preséntese en el aeropuerto al menos 2 horas antes de la salida de su vuelo.</p>
        </div>
    </div>
</body>
</html>
