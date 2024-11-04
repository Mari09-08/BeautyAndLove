<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'status',
        'url',
    ];

    // Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(CategoriasProductos::class, 'categoria_id');
    }

    // Un producto puede estar en muchos detalles de pedidos
    public function detallesPedidos()
    {
        return $this->hasMany(DetallesPedidos::class);
    }
}
