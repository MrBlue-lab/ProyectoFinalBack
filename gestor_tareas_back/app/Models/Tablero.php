<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    use HasFactory;
    protected $table = 'tableros';
    
    protected $fillable = [
        'id',
        'id_Creador',
        'nombre',
        'tipo',
        'descripcion'
    ];
}
