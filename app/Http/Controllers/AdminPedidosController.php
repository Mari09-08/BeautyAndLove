<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Clientes;
use App\Models\DetallesPedidos;
use App\Models\Pedidos;
use App\Models\Productos;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        $cliente = Clientes::all();
        $pedidos = Pedidos::where('estado', '!=', 'Reclamado')
        ->where('estado', '!=', 'Carrito')
        ->get();
        $detallesPedidos = DetallesPedidos::all();
        return view('admin.pedidos.pendientes', compact('productos','categorias','cliente','pedidos','detallesPedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function entregar($idpedido)
    {
        try {
            // Buscar el pedido por su ID
            $pedido = Pedidos::findOrFail($idpedido);  // Utiliza findOrFail para manejar el caso en que el pedido no exista
        
            // Cambiar el estado del pedido
            $pedido->estado = 'Reclamado';
            $pedido->save();
        
            // Mostrar alerta de éxito
            Alert::success('Éxito', 'Se cambió el estado a ENTREGADO, ¡Muchas gracias!')->persistent(true)->autoClose(false);
        } catch (\Exception $e) {
            // Si ocurre algún error, mostrar una alerta con el mensaje del error
            Alert::error('Error', 'Ocurrió un problema al procesar el pedido. Por favor, inténtalo de nuevo.')->persistent(true)->autoClose(false);
        }
        return redirect()->back();        
    }
    
    public function entregados()
    {
        $productos = Productos::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        $cliente = Clientes::all();
        $pedidos = Pedidos::where('estado', 'Reclamado')->get();
        $detallesPedidos = DetallesPedidos::all();
        return view('admin.pedidos.entregados', compact('productos','categorias','cliente','pedidos','detallesPedidos'));
    }

    public function carritos()
    {
        $productos = Productos::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        $cliente = Clientes::all();
        $pedidos = Pedidos::where('estado', 'Carrito')->get();
        $detallesPedidos = DetallesPedidos::all();
        return view('admin.pedidos.carritos', compact('productos','categorias','cliente','pedidos','detallesPedidos'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
