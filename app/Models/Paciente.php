<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $fillable = [
        'rut',
        'nombres',
        'apellidos',
        'direccion',
        'ciudad',
        'telefono',
        'email',
        'fecha_nacimiento',
        'estado_civil',
        'comentarios',
    ];
}
