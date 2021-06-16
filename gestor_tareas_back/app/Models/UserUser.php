<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUser extends Model {
    use HasFactory;

    protected $table = 'user_user';
    protected $fillable = [
        'id_user_a',
        'id_user_b',
        'aceptado',
    ];
}