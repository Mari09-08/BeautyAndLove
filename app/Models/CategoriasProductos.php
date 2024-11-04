<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasProductos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
    ];

    // Una categoría puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Productos::class, 'categoria_id');
    }
}
