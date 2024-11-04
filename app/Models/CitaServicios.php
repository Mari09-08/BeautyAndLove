<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaServicios extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_cita',
        'id_servicio',
    ];
    
    // Relación con la tabla Citas
    public function cita()
    {
        return $this->belongsTo(Citas::class, 'id_cita');
    }

    // Relación con la tabla Servicios
    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'id_servicio');
    }
}
