<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso de Pacientes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Ingreso de Pacientes</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                html: `@foreach ($errors->all() as $error)<p style="text-align: left;">{{ $error }}</p>@endforeach`,
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error')  }}',
            });
        });
    </script>
@endif

    @if ($errors->any())
    <div style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container">
        
        <form id="fichaForm" action="{{ route('pacientes.store') }}" method="POST">
            @csrf
            
            <label>RUT:</label><br>
            <div class="container-rut">
                <input type="text" name="rut_numero" value="{{ old('rut_numero') }}" maxlength="8" placeholder="12345678" required>
                <label style="align-self: center;">-</label>
                <input type="text" name="rut_dv" value="{{ old('rut_dv') }}" maxlength="1" placeholder="K" required style="width: 40px;">
            </div>
            <label>Nombres:</label><br>
            <input type="text" name="nombres" value="{{ old('nombres') }}"><br><br>
            
            <label>Apellidos:</label><br>
            <input type="text" name="apellidos" value="{{ old('apellidos') }}"><br><br>
            
            <label>Dirección:</label><br>
            <input type="text" name="direccion" value="{{ old('direccion') }}"><br><br>
            
            <label>Ciudad:</label><br>
            <input type="text" name="ciudad" value="{{ old('ciudad') }}"><br><br>
            
            <label>Teléfono:</label><br>
            <input type="text" name="telefono" value="{{ old('telefono') }}"><br><br>
            
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}"><br><br>
            
            <label>Fecha de Nacimiento:</label><br>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"><br><br>
            
            <label>Estado Civil:</label><br>
            <input type="text" name="estado_civil" value="{{ old('estado_civil') }}"><br><br>
            
            <label>Comentarios:</label><br>
            <textarea name="comentarios">{{ old('comentarios') }}</textarea><br><br>
            
            <button type="submit">Guardar Paciente</button>
            <button type="button" onclick="limpiarFormulario()">Limpiar</button>
            
        </form>
        <form action="{{ route('pacientes.buscar') }}" method="GET" class="search">
            <label for="buscarApellido">Buscar paciente por apellido:</label>
            <input type="text" name="apellido" id="buscarApellido" required>
            <button type="submit">Buscar</button>
        </form>
    </div>
        
    <script>
        function calcularDV(rut) {
        let suma = 0;
        let multiplo = 2;

        for (let i = rut.length - 1; i >= 0; i--) {
            suma += parseInt(rut.charAt(i)) * multiplo;
            multiplo = multiplo === 7 ? 2 : multiplo + 1;
        }

        const resto = 11 - (suma % 11);
        if (resto === 11) return "0";
        if (resto === 10) return "K";
        return resto.toString();
        }

        function validarRut(rutNumero, rutDV) {
        if (!/^\d{7,8}$/.test(rutNumero)) return false;
        const dvCalculado = calcularDV(rutNumero);
        return dvCalculado === rutDV.toUpperCase();
        }

        // ⚡ Nueva función: validar antes de enviar el formulario
        document.getElementById('fichaForm').addEventListener('submit', function(event) {
        const rutNumero = document.getElementById("rutNumero").value.trim();
        const rutDV = document.getElementById("rutDV").value.trim().toUpperCase();
        const nombres = document.getElementById("nombres").value.trim();
        const apellidoPaterno = document.getElementById("apellidoPaterno").value.trim();
        const apellidoMaterno = document.getElementById("apellidoMaterno").value.trim();
        const direccion = document.getElementById("direccion").value.trim();
        const ciudad = document.getElementById("ciudad").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const email = document.getElementById("email").value.trim();
        const nacimiento = document.getElementById("nacimiento").value;
        const estadoCivil = document.getElementById("estadoCivil").value;
        const comentarios = document.getElementById("comentarios").value.trim();
        const hoy = new Date().toISOString().split("T")[0];
        const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/;
        const emailRegex = /^[a-zA-Z0-9._-]+@(gmail\.com|hotmail\.com|outlook\.com)$/;

        // Validaciones
        if (!nombres || !nombreRegex.test(nombres)) {
            alert("Ingrese un nombre válido (solo letras y espacios).");
            event.preventDefault();
            return;
        }

        if (!apellidoPaterno || !nombreRegex.test(apellidoPaterno)) {
            alert("Ingrese un apellido paterno válido.");
            event.preventDefault();
            return;
        }

        if (!apellidoMaterno || !nombreRegex.test(apellidoMaterno)) {
            alert("Ingrese un apellido materno válido.");
            event.preventDefault();
            return;
        }

        if (!/^\d{7,15}$/.test(telefono)) {
            alert("Teléfono inválido. Solo números y entre 7 a 15 dígitos.");
            event.preventDefault();
            return;
        }

        if (!emailRegex.test(email)) {
            alert("Email inválido. Solo Gmail, Hotmail u Outlook.");
            event.preventDefault();
            return;
        }

        if (!nacimiento || nacimiento > hoy) {
            alert("Fecha de nacimiento inválida.");
            event.preventDefault();
            return;
        }

        if (!validarRut(rutNumero, rutDV)) {
            alert("RUT inválido. Ingrese un RUT válido.");
            event.preventDefault();
            return;
        }

        // Si todo es válido, se envía normalmente al backend (Laravel)
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function limpiarFormulario() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se borrarán todos los campos del formulario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("fichaForm").reset();
                Swal.fire('¡Formulario limpio!', '', 'success');
            }
        });
    }
    </script>



</body>
</html>
