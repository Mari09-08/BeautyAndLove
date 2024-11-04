<?php

namespace App\Http\Controllers;

use App\Models\ProfesionalProfesiones;
use App\Models\Profesiones;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ProfesionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesiones = Profesiones::paginate(4);
        return view('admin.profesiones.index', ['profesiones' => $profesiones]);
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
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:profesiones,nombre', // Regla unique para el campo 'nombre'
            'descrip' => 'required|string|max:500',
        ], [
            'nombre.required' => 'El campo Nombre Profesión es obligatorio.',
            'nombre.max' => 'El campo Nombre Profesión no debe exceder los 255 caracteres.',
            'nombre.unique' => 'El nombre de la profesión ya existe. Por favor, elige otro.', // Mensaje personalizado para el error de unicidad
            'descrip.required' => 'La descripción es obligatoria.',
            'descrip.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        try {
            // Crear el registro usando asignación masiva
            Profesiones::create([
                'nombre' => $validatedData['nombre'],
                'descripcion' => $validatedData['descrip'],
            ]);

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La profesión se ha creado correctamente.');
            return redirect()->route('dashboard.admin.profesiones');

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear la profesión. Inténtalo de nuevo más tarde.');

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error al crear la profesión: ' . $e->getMessage());

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'nombreUp' => 'required|string|max:255|unique:profesiones,nombre,' . $id,
            'descripUP' => 'required|string|max:500',
        ], [
            'nombreUp.required' => 'El campo Nombre Profesión es obligatorio.',
            'nombreUp.max' => 'El campo Nombre Profesión no debe exceder los 255 caracteres.',
            'nombreUp.unique' => 'El nombre de la profesión ya existe. Por favor, elige otro.',
            'descripUP.required' => 'La descripción es obligatoria.',
            'descripUP.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'No se pudo actualizar la información. Verifica los errores.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $profesion = Profesiones::findOrFail($id);

            // Actualizamos solo los campos específicos
            $profesion->update([
                'nombre' => $request->input('nombreUp'),
                'descripcion' => $request->input('descripUP')
            ]);

            Alert::success('Éxito', 'Profesión actualizada correctamente.');
            return redirect()->route('dashboard.admin.profesiones');
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
            $dataOtra = ProfesionalProfesiones::where('id_profesion', $id)->get();

            if ($dataOtra->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar la profesión porque está asociada a uno o más profesionales. Desasocie la profesión antes de eliminarla.');
                return redirect()->back();
            }

            // Si no está asociada a ningún profesional, proceder a eliminar
            $profesion = Profesiones::findOrFail($id);
            $profesion->delete();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La profesión ha sido eliminada correctamente.');
            return redirect()->route('dashboard.admin.profesiones');

        } catch (\Exception $e) {
            // Manejar el error si ocurre alguna excepción
            Alert::error('Error', 'Hubo un problema al eliminar la profesión.');
            \Log::error('Error al eliminar la profesión: ' . $e->getMessage());
            return redirect()->back();

        }

    }
}
