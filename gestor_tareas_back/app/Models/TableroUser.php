<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableroUser extends Model
{
    use HasFactory;

    protected $table = 'user_tablero';
    protected $fillable = [
        'id',
        'id_user',
        'id_tablero',
        'aceptado',
    ];
}
