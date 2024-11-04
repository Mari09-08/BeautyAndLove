<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesionalProfesiones extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_profesional',
        'id_profesion',
    ];

    // Relación con Profesionales
    public function profesional()
    {
        return $this->belongsTo(Profesionales::class, 'id_profesional');
    }

    // Relación con Profesiones
    public function profesion()
    {
        return $this->belongsTo(Profesiones::class, 'id_profesion');
    }
}
