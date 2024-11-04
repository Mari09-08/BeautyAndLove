<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'fecha',
        'precio',
        'estado',
    ];

    // Un pedido pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Un pedido tiene muchos detalles de pedidos
    public function detalles()
    {
        return $this->hasMany(DetallesPedidos::class, 'pedido_id');
    }
}
