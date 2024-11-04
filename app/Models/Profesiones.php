<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesiones extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    // Una profesión puede ser realizada por muchos profesionales
    public function profesionales()
    {
        return $this->belongsToMany(Profesionales::class, 'profesional_profesiones', 'id_profesion', 'id_profesional');
    }

    // // Una profesión puede ser realizada por muchos profesionales (relación muchos a muchos)
    // public function profesionales()
    // {
    //     return $this->belongsToMany(Profesional::class, 'profesional_profesiones', 'id_profesion', 'id_profesional');
    // }
}
