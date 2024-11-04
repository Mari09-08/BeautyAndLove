<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre1',
        'nombre2',
        'apellido1',
        'apellido2',
        'telefono',
        'fecha_nacimiento',
        'id_user',
    ];

    // Un cliente pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Un cliente puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'cliente_id');
    }

    // Un cliente puede tener muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedidos::class, 'cliente_id');
    }

}
