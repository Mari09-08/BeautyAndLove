<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Productos;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriasProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = CategoriasProductos::orderBy('nombre_categoria', 'asc')->paginate(5);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias_productos,nombre_categoria',
            'descrip' => 'required|string|max:500',
        ], [
            'nombre.required' => 'El campo Nombre de la Categoria es obligatorio.',
            'nombre.max' => 'El campo Nombre de la Categoria  no debe exceder los 255 caracteres.',
            'nombre.unique' => 'El Nombre de la Categoria  ya existe. Por favor, elige otro.',
            'descrip.required' => 'La descripción es obligatoria.',
            'descrip.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        try {
            // Crear el registro usando asignación masiva
            CategoriasProductos::create([
                'nombre_categoria' => $validatedData['nombre'],
                'descripcion' => $validatedData['descrip'],
            ]);

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La Categoria se creo correctamente.');
            return redirect()->route('dashboard.admin.categorias');

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear la categoria. Inténtalo de nuevo más tarde.');

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error al crear la categoria: ' . $e->getMessage());

            // Redirigir con la entrada actual del formulario
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
        try {

            $categoria = CategoriasProductos::findOrFail($id);
            return view('admin.categorias.edit', compact('categoria'));

        } catch (\Exception $e) {

            \Log::error('Error al intentar editar la categoria: ' . $e->getMessage());

            Alert::error('Error', 'La Categoria no se pudo encontrar.');
            return redirect()->route('dashboard.admin.categorias');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:categorias_productos,nombre_categoria,' . $id,
            'descrip' => 'required|string|max:500',
        ], [
            'nombre.required' => 'El campo Nombre de la Categoria es obligatorio.',
            'nombre.max' => 'El campo Nombre de la Categoria  no debe exceder los 255 caracteres.',
            'nombre.unique' => 'El Nombre de la Categoria  ya existe. Por favor, elige otro.',
            'descrip.required' => 'La descripción es obligatoria.',
            'descrip.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'No se pudo actualizar la información. Verifica los errores.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $categoria = CategoriasProductos::findOrFail($id);

            // Actualizamos solo los campos específicos
            $categoria->update([
                'nombre_categoria' => $request->input('nombre'),
                'descripcion' => $request->input('descrip')
            ]);

            Alert::success('Éxito', 'Categoría actualizada correctamente.');
            return redirect()->route('dashboard.admin.categorias');
        } catch (\Exception $e) {
            Alert::error('Error', 'No se pudo actualizar la información.' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Verificar si la profesión está asociada a un profesional
            $dataOtra = Productos::where('categoria_id', $id)->get();

            if ($dataOtra->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar la categoría porque está asociada a uno o más productos. No se puede realizar esta acción.');
                return redirect()->back();
            }

            // Si no está asociada a ningún profesional, proceder a eliminar
            $categoria = CategoriasProductos::findOrFail($id);
            if ($categoria) {
                $categoria->delete();
            }

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La Categoría ha sido eliminada correctamente.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Manejar el error si ocurre alguna excepción
            Alert::error('Error', 'Hubo un problema al eliminar la Categoria.' . $e->getMessage());
            \Log::error('Error al eliminar la Categoria: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
