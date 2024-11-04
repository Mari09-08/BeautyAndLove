<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'profesional_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'status',
    ];

    // // Relación con Cliente
    // public function cliente()
    // {
    //     return $this->belongsTo(Clientes::class);
    // }

    // // Relación con Profesional
    // public function profesional()
    // {
    //     return $this->belongsTo(Profesionales::class);
    // }

    // // Relación con CitaServicios (muchos a muchos con Servicios)
    // public function servicios()
    // {
    //     return $this->hasMany(CitaServicios::class, 'id_cita');
    // }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Una cita pertenece a un profesional
    public function profesional()
    {
        return $this->belongsTo(Profesionales::class, 'profesional_id');
    }

    // Una cita puede tener muchos servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'cita_servicios', 'id_cita', 'id_servicio');
    }
}
