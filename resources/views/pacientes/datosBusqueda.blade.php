<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Paciente Encontrado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <h1>Paciente Encontrado</h1>

    <table>
        <tr><th>RUT</th><td>{{ $paciente->rut }}</td></tr>
        <tr><th>Nombres</th><td>{{ $paciente->nombres }}</td></tr>
        <tr><th>Apellidos</th><td>{{ $paciente->apellidos }}</td></tr>
        <tr><th>Dirección</th><td>{{ $paciente->direccion }}</td></tr>
        <tr><th>Ciudad</th><td>{{ $paciente->ciudad }}</td></tr>
        <tr><th>Teléfono</th><td>{{ $paciente->telefono }}</td></tr>
        <tr><th>Email</th><td>{{ $paciente->email }}</td></tr>
        <tr><th>Fecha de Nacimiento</th><td>{{ $paciente->fecha_nacimiento }}</td></tr>
        <tr><th>Estado Civil</th><td>{{ $paciente->estado_civil }}</td></tr>
        <tr><th>Comentarios</th><td>{{ $paciente->comentarios }}</td></tr>
    </table>

    <div class="buttons" style="margin-top: 20px;">
        <a href="{{ url('/') }}">
            <button type="button">Volver</button>
        </a>
    </div>
</div>

</body>
</html>

