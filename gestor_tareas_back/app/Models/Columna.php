<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
    use HasFactory;
    protected $table = 'columna';
    protected $fillable = [
        'id',
        'idTablero',
        'posicion',
        'nombre',
        'tarjetas'
    ];
}
