<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesPedidos extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio',
    ];

        // Un detalle de pedido pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedidos::class, 'pedido_id');
    }

    // Un detalle de pedido pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
