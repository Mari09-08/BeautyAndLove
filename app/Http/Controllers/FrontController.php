<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Clientes;
use App\Models\DetallesPedidos;
use App\Models\Pedidos;
use App\Models\Productos;
use App\Models\Profesionales;
use App\Models\Servicios;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::where('status', true)->get();
        $profesionales = Profesionales::all();
        $servicios = Servicios::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        return view('clientes.index', compact('productos', 'profesionales', 'servicios', 'categorias'));
    }

    public function historialPedidos(string $idUser)
    {
        $productos = Productos::where('status', 1)->get();
        $profesionales = Profesionales::all();
        $servicios = Servicios::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        $cliente = Clientes::where('id_user', auth()->user()->id)->first();
        $pedidos = Pedidos::where('cliente_id', $cliente->id)->where('estado', '!=', 'Carrito')
        ->get();
        $detallesPedidos = DetallesPedidos::all();

        return view('clientes.pedidos.historial', compact('productos', 'profesionales', 'servicios', 'categorias', 'pedidos', 'detallesPedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
