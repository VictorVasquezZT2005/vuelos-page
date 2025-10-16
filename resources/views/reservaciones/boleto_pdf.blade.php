<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Boleto de Vuelo - {{ $reservacion->vuelo->codigo }}</title>
    <style>
        @page {
            margin: 0; /* Elimina el margen de la página PDF */
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0; /* Asegura que no haya margen en el body */
            padding: 0;
            color: #333;
        }
        .ticket-container {
            width: 800px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .ticket { display: table; width: 100%; }
        .main-section {
            display: table-cell;
            width: 70%;
            padding: 20px;
            background: white;
        }
        .stub-section {
            display: table-cell;
            width: 30%;
            padding: 20px;
            background: #d92c3f; /* Color rojo del ejemplo */
            color: white;
            border-left: 2px dashed #ccc;
            vertical-align: top;
        }
        h1, h2, h3 { margin: 0; padding: 0; }
        .label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .value { font-size: 16px; font-weight: bold; }
        .main-section .value { color: #000; }
        .stub-section .label { color: #ffcdd2; }
        .stub-section .value { font-size: 14px; }
        .flight-path {
            display: table;
            width: 100%;
            margin: 20px 0;
            text-align: center;
        }
        .origin, .destination, .plane-icon { display: table-cell; vertical-align: middle; }
        .origin, .destination { font-size: 40px; font-weight: bold; }
        .plane-icon { font-size: 24px; position: relative; }
        .plane-icon span { display: block; }
        .dashed-line {
            border-bottom: 2px dashed #999;
            width: 100%;
            position: relative;
            top: -16px;
        }
        .details-grid {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .details-grid > div {
            display: table-cell;
        }
        .qr-code { text-align: center; margin-top: 10px; }
        .footer-note {
            font-size: 10px;
            color: #666;
            margin-top: 20px;
            text-align: left;
        }
        .stub-header {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    @php
        $fechaSalida = \Carbon\Carbon::parse($reservacion->vuelo->fecha_salida);
        $horaEmbarque = $fechaSalida->copy()->subMinutes(45)->format('H:i');
        $qrData = "Reserva: {$reservacion->id}, Vuelo: {$reservacion->vuelo->codigo}, Pasajero: {$reservacion->cliente->nombre}";
    @endphp

    <div class="ticket-container">
        <div class="ticket">
            <div class="main-section">
                <div style="display: table; width: 100%;">
                    <div style="display: table-cell; width: 50%;">
                        <div class="label">Nombre del Pasajero</div>
                        <div class="value">{{ $reservacion->cliente->nombre }}</div>
                    </div>
                    <div style="display: table-cell; text-align: right;">
                        <h2 style="color: #d92c3f; font-weight: bold;">SkyWings</h2>
                    </div>
                </div>

                <div class="details-grid" style="margin-top: 20px;">
                    <div>
                        <div class="label">Vuelo</div>
                        <div class="value">{{ $reservacion->vuelo->codigo }}</div>
                    </div>
                    <div>
                        <div class="label">Fecha</div>
                        <div class="value">{{ $fechaSalida->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="label">Asiento(s)</div>
                        <div class="value">{{ implode(', ', $reservacion->numeros_asiento) }}</div>
                    </div>
                </div>

                <div class="flight-path">
                    <div class="origin">{{ strtoupper(substr($reservacion->vuelo->origen, 0, 3)) }}</div>
                    <div class="plane-icon">
                        <span>✈️</span>
                        <div class="dashed-line"></div>
                    </div>
                    <div class="destination">{{ strtoupper(substr($reservacion->vuelo->destino, 0, 3)) }}</div>
                </div>

                <div class="details-grid">
                    <div>
                        <div class="label">Hora de Embarque</div>
                        <div class="value">{{ $horaEmbarque }}</div>
                    </div>
                    <div>
                        <div class="label">Puerta</div>
                        <div class="value">D-10</div> {{-- Dato de ejemplo --}}
                    </div>
                    <div>
                        <div class="label">Terminal</div>
                        <div class="value">2A</div> {{-- Dato de ejemplo --}}
                    </div>
                </div>

                <div style="display: table; width: 100%; margin-top: 10px;">
                    <div style="display: table-cell; width: 70%;">
                         <div class="footer-note">
                            Por favor, llegue a la puerta de embarque 30 minutos antes de la salida.
                        </div>
                    </div>
                    <div style="display: table-cell; width: 30%;" class="qr-code">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($qrData, 'QRCODE') }}" alt="qr code" />
                    </div>
                </div>

            </div>

            <div class="stub-section">
                <div class="stub-header">
                    SKY FLYER <br>
                    {{ $reservacion->vuelo->origen }} A {{ $reservacion->vuelo->destino }}
                </div>

                <div style="margin-bottom: 15px;">
                    <div class="label">Nombre del Pasajero</div>
                    <div class="value">{{ $reservacion->cliente->nombre }}</div>
                </div>
                
                <div style="display: table; width: 100%; margin-bottom: 15px;">
                    <div style="display: table-cell;">
                        <div class="label">Vuelo</div>
                        <div class="value">{{ $reservacion->vuelo->codigo }}</div>
                    </div>
                    <div style="display: table-cell;">
                        <div class="label">Asiento</div>
                        <div class="value">{{ $reservacion->numeros_asiento[0] }}</div>
                    </div>
                </div>

                <div style="display: table; width: 100%; margin-bottom: 15px;">
                     <div style="display: table-cell;">
                        <div class="label">Fecha</div>
                        <div class="value">{{ $fechaSalida->format('d M Y') }}</div>
                    </div>
                    <div style="display: table-cell;">
                        <div class="label">Terminal</div>
                        <div class="value">2A</div>
                    </div>
                </div>
                
                 <div style="display: table; width: 100%; margin-bottom: 15px;">
                    <div style="display: table-cell;">
                        <div class="label">Puerta</div>
                        <div class="value">D-10</div>
                    </div>
                </div>

                <div class="qr-code">
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($qrData, 'QRCODE') }}" alt="qr code" />
                </div>
            </div>
        </div>
    </div>
</body>
</html>