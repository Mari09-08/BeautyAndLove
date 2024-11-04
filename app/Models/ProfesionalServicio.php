<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesionalServicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'profesional_id',
        'servicio_id',
    ];

    // Relación con el modelo Profesional
    public function profesional()
    {
        return $this->belongsTo(Profesionales::class, 'profesional_id');
    }

    // Relación con el modelo Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
}
