<?php
namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Clientes;
use App\Models\Profesionales;
use App\Models\Servicios;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Pedidos;
use App\Models\DetallesPedidos;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CarritoController extends Controller
{
    // Mostrar productos disponibles
    public function index()
    {
        $productos = Productos::where('status', 1)->orderBy('nombre', 'ASC')->paginate(6);
        $profesionales = Profesionales::all();
        $servicios = Servicios::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        return view('clientes.carrito.index', compact('productos', 'profesionales', 'servicios', 'categorias'));
    }

    // Agregar producto al carrito
    public function agregarProducto(Request $request, $productoId)
    {
        DB::beginTransaction();

        try {
            $cliente = Clientes::where('id_user', auth()->user()->id)->first();
            // Obtén el producto
            $producto = Productos::find($productoId);
            // Verifica si el pedido del cliente ya existe en estado "Carrito"
            $infoPedido = Pedidos::where('cliente_id',  $cliente->id)->where('estado', 'Carrito')->first();

            
    
            if (!$infoPedido) {
                // Si no existe, crea un nuevo pedido
                $infoPedido = new Pedidos();
                $infoPedido->cliente_id =  $cliente->id;
                $infoPedido->fecha = now();
                $infoPedido->precio = 0; // Inicialmente en 0, luego lo actualizamos
                $infoPedido->estado = 'Carrito';
                $infoPedido->save();
            }
            // Busca el detalle del pedido
            $detalle = DetallesPedidos::where('pedido_id', $infoPedido->id)->where('producto_id', $productoId)->first();
    
            if ($detalle) {
                // Si el producto ya está en el pedido, incrementa la cantidad y el precio
                $detalle->cantidad += 1;
                $detalle->precio += $producto->precio;
            } else {
                // Si no, crea un nuevo detalle de pedido
                $detalle = new DetallesPedidos();
                $detalle->pedido_id = $infoPedido->id;
                $detalle->producto_id = $productoId;
                $detalle->cantidad = 1;
                $detalle->precio = $producto->precio;
            }
    
            // Guarda el detalle actualizado
            $detalle->save();
    
            // Actualiza el precio total del pedido
            $infoPedido->precio += $producto->precio;
            $infoPedido->save();
    
            // Confirma la transacción
            DB::commit();
            Alert::success('Éxito', 'Producto agregado al carrito correctamente.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Si hay algún error, revierte la transacción
            DB::rollBack();
            Alert::error('Error', 'Error al agregar el producto.');
            return redirect()->back();
        }
    }

    // Eliminar producto del carrito
    public function eliminarProducto($productoId)
    {
        $producto = DetallesPedidos::find($productoId);
        $detalleProducto = Productos::find($producto->producto_id);
        $pedido =  Pedidos::find($producto->pedido_id);
        if ($producto->cantidad == 1) {
            if(count(DetallesPedidos::where('pedido_id',  $producto->pedido_id)->get()) == 1){
                $producto->delete();
                $pedido->delete();
                Alert::success('Éxito', 'Se Elimino completamente el Carrito');
                return redirect()->route('carrito.index');
            }else{
                $pedido->precio = $pedido->precio - $detalleProducto->precio;
                $pedido->save();

                $producto->delete();
                Alert::success('Éxito', 'Se Elimino el producto del Carrito');
                return redirect()->back();
            }
        }else{
            $pedido->precio = $pedido->precio - $detalleProducto->precio;
            $pedido->save();

            $producto->cantidad = $producto->cantidad - 1;
            $producto->precio = $producto->precio - $detalleProducto->precio;
            $producto->save();

            Alert::success('Éxito', 'Se actualizo la cantidad del producto: '. $detalleProducto->nombre);
            return redirect()->back();
        }
        
    }

    // Ver carrito
    public function verCarrito()
    {
        $productos = Productos::where('status', 1)->get();
        $profesionales = Profesionales::all();
        $servicios = Servicios::all();
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
        $cliente = Clientes::where('id_user', auth()->user()->id)->first();
        $infoPedido = Pedidos::where('cliente_id', $cliente->id)->where('estado', 'Carrito')->first();
        if ($infoPedido ==  null) {
            $detallePedido = [];
        }else{
            $detallePedido = DetallesPedidos::where('pedido_id', $infoPedido->id)->get();
        }
        return view('clientes.carrito.ver', compact('productos', 'profesionales', 'servicios', 'categorias', 'infoPedido', 'detallePedido'));
    }

    // Confirmar el pedido
    public function confirmarPedido($idPedido)
    {
        DB::beginTransaction(); // Inicia la transacción
    
        try {
            $pedi = Pedidos::find($idPedido);
            $detallePedido = DetallesPedidos::where('pedido_id', $idPedido)->get();
            $productos = Productos::where('status', 1)->get();
    
            foreach ($detallePedido as $pedido) {
                foreach ($productos as $producto) {
                    if ($producto->id === $pedido->producto_id) {
                        $total = $producto->stock - $pedido->cantidad;
                        
                        if ($total >= 0) {
                            // Si el stock es suficiente, actualiza el stock del producto
                            $producto->stock = $total;
                            $producto->save();
                            if($total == 0){
                                $producto->status = false;
                                $producto->save();
                            }
                        } else {
                            // Si no hay suficiente stock, lanza una excepción
                            throw new \Exception('No se puede eliminar, no contamos con inventario suficiente del producto: '.$producto->nombre.'. Cantidad disponible: '.$producto->stock);
                        }
                    }
                }
            }
    
            // Si todo sale bien, confirma la transacción
            DB::commit();
    
            $pedi->fecha = now();
            $pedi->estado = 'Sin Reclamar';
            $pedi->save();
            Alert::success('Éxito', 'Se ha enviado el pedido a nuestra tienda, Recuerda Pasar por el, gracias por confiar en nosotros')
            ->persistent(true)
            ->autoClose(false);
            return redirect()->route('home');

        } catch (\Exception $e) {
            // Si ocurre algún error, deshace todas las operaciones
            DB::rollBack();
    
            Alert::error('Error', $e->getMessage())
                ->persistent(true)
                ->autoClose(false);
    
            return redirect()->back();
        }
    }
}
