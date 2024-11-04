<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesionales extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre1',
        'nombre2',
        'apellido1',
        'apellido2',
        'id_user',
        'telefono',
        'hora_inicio',
        'hora_fin',
    ];

    // Relación con citas
    public function citas()
    {
        return $this->hasMany(Citas::class);
    }

    // Relación con servicios a través de la tabla pivot ProfesionalServicio
    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'profesional_servicios', 'profesional_id', 'servicio_id');
    }

     // Un profesional pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

//  // Un profesional puede tener muchos servicios
//  public function servicios()
//  {
//      return $this->belongsToMany(Servicio::class, 'profesional_servicios');
//  }

    // Un profesional puede tener muchas profesiones (relación muchos a muchos)
    public function profesiones()
    {
        return $this->belongsToMany(Profesiones::class, 'profesional_profesiones', 'id_profesional', 'id_profesion');
    }

    //  // Un profesional puede tener muchas citas
    //  public function citas()
    //  {
    //      return $this->hasMany(Cita::class);
    //  }
    
}
