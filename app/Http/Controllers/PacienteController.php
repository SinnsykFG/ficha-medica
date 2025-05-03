<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function create()
    {
        return view('pacientes.create');
    }

    // Guardar paciente
    public function store(Request $request)
    {
        $request->validate([
            'rut_numero' => 'required|digits_between:7,8',
            'rut_dv' => 'required|max:1',
            'nombres' => 'required|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'apellidos' => 'required|max:150|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'direccion' => 'required|max:255',
            'ciudad' => 'required|max:100',
            'telefono' => 'required|max:20',
            'email' => 'required|email|max:150|unique:pacientes',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'estado_civil' => 'required|max:50',
            'comentarios' => 'nullable',
        ],[
            'rut_numero.required' => 'El campo RUT es obligatorio.',
            'rut_numero.digits_between' => 'El RUT debe tener entre 7 y 8 dígitos.',
            'rut_dv.required' => 'El campo DV es obligatorio.',
            'rut_dv.max' => 'El DV no puede tener más de 1 carácter.',
            'nombres.required' => 'El campo Nombres es obligatorio.',
            'nombres.max' => 'El campo Nombres no puede tener más de 100 caracteres.',
            'nombres.regex' => 'El campo Nombres solo puede contener letras y espacios.',
            'apellidos.required' => 'El campo Apellidos es obligatorio.',
            'apellidos.max' => 'El campo Apellidos no puede tener más de 150 caracteres.',
            'apellidos.regex' => 'El campo Apellidos solo puede contener letras y espacios.',
            'direccion.required' => 'El campo Dirección es obligatorio.',
            'direccion.max' => 'El campo Dirección no puede tener más de 255 caracteres.',
            'ciudad.required' => 'El campo Ciudad es obligatorio.',
            'ciudad.max' => 'El campo Ciudad no puede tener más de 100 caracteres.',
            'telefono.required' => 'El campo Teléfono es obligatorio.',
            'telefono.max' => 'El campo Teléfono no puede tener más de 20 caracteres.',
            'email.required' => 'El campo Email es obligatorio.',
            'email.email' => 'El formato del Email no es válido.',
            'email.max' => 'El campo Email no puede tener más de 150 caracteres.',
            'email.unique' => 'Ya existe un paciente registrado con este email.',
            // Agregar validación para el estado civil
        ]);

        
        $rut_completo = $request->rut_numero . '-' . strtoupper($request->rut_dv);
        
        //Validar el RUT
        if (!$this->validarRut($request->rut_numero, strtoupper($request->rut_dv))) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['rut_numero' => 'El RUT ingresado no es válido.']);
        }
        
        Paciente::create([
            'rut' => $rut_completo,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'comentarios' => $request->comentarios,
        ]);

        
        
        return redirect()->back()->with('success', 'Paciente registrado exitosamente.');
    }
    private function validarRut($numero, $dv){
    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += $numero[$i] * $multiplo;
        $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
    }

    $dvr = 11 - ($suma % 11);

    if ($dvr == 11) $dvr = '0';
    if ($dvr == 10) $dvr = 'K';

    return (string)$dvr === strtoupper($dv);
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'apellido' => 'required|string|max:150',
        ]);

        $apellido = $request->input('apellido');

        // Buscar coincidencias en la base de datos
        $paciente = Paciente::where('apellidos', 'ILIKE', '%' . $apellido . '%')->first();

        if ($paciente) {
            // Redireccionar a la vista de datos encontrados
            return view('pacientes.datosBusqueda', compact('paciente'));
        } else {
            // No se encontró paciente
            return redirect()->back()->with('error', 'No se encontró ningún paciente con ese apellido.');
        }
    }
}


