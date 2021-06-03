<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;
    protected $table = 'tarjetas';
    protected $fillable = [
        'id',
        'id_Columna',
        'posicion',
        'nombre',
        'tipo',
        'descripcion',
        'check_fin',
        'not_fecha_inicio',
        'Fecha_inicio',
        'Time_inicio',
        'not_fecha_fin',
        'Fecha_fin',
        'check_fin',
        'Time_fin',
    ];
}
