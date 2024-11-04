<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory; 
    protected $fillable = [
        'nombre_servicio',
        'descripcion',
        'duracion',
        'precio',
    ];

    // // Relación con la tabla pivot CitaServicios (muchos a muchos con Citas)
    // public function citas()
    // {
    //     return $this->belongsToMany(CitaServicios::class, 'cita_servicios', 'id_servicio', 'id_cita');
    // }

    // // Relación con profesionales a través de la tabla pivot ProfesionalServicio
    // public function profesionales()
    // {
    //     return $this->belongsToMany(Profesionales::class, 'profesional_servicios', 'servicio_id', 'profesional_id');
    // }

    // Un servicio puede ser ofrecido por muchos profesionales
    public function profesionales()
    {
        return $this->belongsToMany(Profesionales::class, 'profesional_servicios');
    }

    // Un servicio puede estar en muchas citas
    public function citas()
    {
        return $this->belongsToMany(Citas::class, 'cita_servicios', 'id_servicio', 'id_cita');
    }
}
