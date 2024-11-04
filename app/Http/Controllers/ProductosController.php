<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\DetallesPedidos;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $porductos = Productos::orderBy('nombre', 'ASC')->paginate(10);
        $categorias = CategoriasProductos::all();

        return view('admin.productos.index', compact('porductos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'asc')->get();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:productos,nombre|max:255',
            'descrip' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria' => 'required|exists:categorias_productos,id',
            'ima' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'Este nombre ya está en uso, por favor elige otro.',
            'descrip.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.exists' => 'La categoría seleccionada no es válida.',
            'ima.required' => 'La imagen es obligatoria.',
            'ima.image' => 'El archivo debe ser una imagen válida.',
            'ima.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'ima.max' => 'La imagen no puede superar los 2MB.',
        ]);

        try {
            // Procesar la imagen
            if ($request->hasFile('ima')) {
                // Obtener el archivo de la imagen
                $imagen = $request->file('ima');
                // Asignar un nombre único a la imagen
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                // Mover la imagen a la carpeta 'public/productos/imagenes'
                $rutaImagen = $imagen->move(public_path('productos/imagenes'), $nombreImagen);
                // Guardar la URL relativa
                $urlImagen = 'productos/imagenes/' . $nombreImagen;
            }

            // Crear un nuevo producto
            $producto = new Productos();
            $producto->nombre = $request->input('nombre');
            $producto->descripcion = $request->input('descrip');
            $producto->precio = $request->input('precio');
            $producto->stock = $request->input('stock');
            $producto->categoria_id = $request->input('categoria');
            $producto->status = true; // Por defecto el estatus es true
            $producto->url = $urlImagen; // Guardar la URL de la imagen
            $producto->save();

            // Mostrar mensaje de éxito
            Alert::success('Éxito', 'El producto se ha creado correctamente.');
            return redirect()->route('dashboard.admin.productos');
        
        } catch (\Exception $e) {
            // Capturar cualquier error y mostrar una alerta de error
            Alert::error('Error', 'Ocurrió un problema al crear el producto. Inténtalo de nuevo más tarde. ' . $e->getMessage());

            // Registrar el error en el log para depuración
            \Log::error('Error al crear el producto: ' . $e->getMessage());

            // Redirigir de vuelta con los datos del formulario
            return redirect()->back()->withInput();
        }
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
        $producto = Productos::findOrFail($id);
        $categorias = CategoriasProductos::all(); // Asegúrate de obtener las categorías
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|unique:productos,nombre,' . $id, // Excluir el producto actual
            'descrip' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'categoria' => 'required|exists:categorias_productos,id',
            'ima' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validación de la imagen
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'descrip.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'categoria.required' => 'La categoría es obligatoria.',
            'ima.image' => 'El archivo debe ser una imagen.',
            'ima.mimes' => 'Solo se permiten imágenes de tipo jpeg, png, jpg, gif o svg.',
            'ima.max' => 'El tamaño de la imagen no debe exceder los 2MB.',
        ]);

        try {
            $producto = Productos::findOrFail($id);

            // Actualizar los campos del producto
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descrip;
            $producto->precio = $request->precio;
            $producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria;

            // Procesar la imagen
            if ($request->hasFile('ima')) {
                // Eliminar la imagen anterior si existe
                if ($producto->url && file_exists(public_path($producto->url))) {
                    unlink(public_path($producto->url)); // Eliminar la imagen anterior
                }

                // Obtener el archivo de la imagen
                $imagen = $request->file('ima');
                // Asignar un nombre único a la imagen
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                // Mover la imagen a la carpeta 'public/productos/imagenes'
                $imagen->move(public_path('productos/imagenes'), $nombreImagen);
                // Guardar la URL relativa
                $producto->url = 'productos/imagenes/' . $nombreImagen;
            }

            $producto->save();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El producto se ha actualizado correctamente.');
            return redirect()->route('dashboard.admin.productos');

        } catch (\Exception $e) {
            // Manejar errores
            Alert::error('Error', 'Ocurrió un problema al actualizar el producto. Inténtalo de nuevo más tarde.');
            \Log::error('Error al actualizar el producto: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }
    public function status(string $id)
    {
        // Encuentra el producto por su id
        $producto = Productos::find($id);
    
        // Verifica si el producto existe
        if ($producto) {
            // Cambia el estado del producto
            $producto->status = !$producto->status;
            $producto->save();
    
            return response()->json(['success' => true, 'status' => $producto->status]);
        } else {
            Alert::error('Error', 'Producto no encontrado.');
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $dataOtra = DetallesPedidos::where('producto_id', $id)->get();

            if ($dataOtra->isNotEmpty()) {
                Alert::error('Error', 'No se puede eliminar el producto porque está asociada a uno o más pedidos. No se puede realizar acción.');
                return redirect()->back();
            }

            $producto = Productos::findOrFail($id);

            // Eliminar la imagen asociada si existe
            if ($producto->url && file_exists(public_path($producto->url))) {
                unlink(public_path($producto->url)); // Eliminar la imagen del sistema de archivos
            }

            // Eliminar el producto de la base de datos
            $producto->delete();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El producto se ha eliminado correctamente.');
            return redirect()->route('dashboard.admin.productos');

        } catch (\Exception $e) {
            // Manejar errores
            Alert::error('Error', 'Ocurrió un problema al eliminar el producto. Inténtalo de nuevo más tarde.');
            \Log::error('Error al eliminar el producto: ' . $e->getMessage());

            return redirect()->back();
        }
    }
}
