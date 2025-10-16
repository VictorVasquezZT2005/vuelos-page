<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje de Contacto</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h1 { color: #333; }
        p { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nuevo Mensaje de Contacto</h1>
        <p><span class="label">Nombre:</span> {{ $data['nombre'] }}</p>
        <p><span class="label">Correo:</span> {{ $data['correo'] }}</p>
        <hr>
        <p><span class="label">Mensaje:</span></p>
        <p>{{ $data['mensaje'] }}</p>
    </div>
</body>
</html>