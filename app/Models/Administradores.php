<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administradores extends Model
{
    use HasFactory;

        // Un administrador pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
