<?php

namespace App\Http\Controllers;

use App\Models\Profesionales;
use App\Models\ProfesionalProfesiones;
use App\Models\Profesiones;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfesionalProfesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        // Obtener el profesional
        $profesional = Profesionales::findOrFail($id);
    
        // Obtener las relaciones existentes entre el profesional y las profesiones
        $relacion = ProfesionalProfesiones::where('id_profesional', $id)->pluck('id_profesion')->toArray(); 
    
        // Obtener las profesiones que NO están relacionadas con el profesional
        $profesiones = Profesiones::whereNotIn('id', $relacion)
        ->orderBy('nombre', 'asc') // Ordenar por nombre ascendente
        ->get();

        $allProfesiones = Profesiones::whereIn('id', $relacion)->orderBy('nombre', 'asc')->paginate(7);
        return view('admin.profesiones.profesional', compact('profesional', 'relacion', 'profesiones', 'allProfesiones'));
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
        $request->validate([
            'profesion' => 'required', 
        ], [
            'profesion.required' => 'Debe de selecionar una Profesión, es obligatorio.',
        ]);

        try {
            $data = new ProfesionalProfesiones();
            $data->id_profesional = $request->profesional;
            $data->id_profesion = $request->profesion;
            $data->save();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La profesión se ha asociado correctamente.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear. Inténtalo de nuevo más tarde. ' . $e->getMessage());

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            // Si no está asociada a ningún profesional, proceder a eliminar
            $profesion = ProfesionalProfesiones::where('id_profesion',$id)->where('id_profesional', $request->pro)->first();
            $profesion->delete();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'La profesión se elimino del Profesional.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Manejar el error si ocurre alguna excepción
            Alert::error('Error', 'Hubo un problema al eliminar la profesión.'. $e->getMessage());
            \Log::error('Error al eliminar la profesión: ' . $e->getMessage());
            return redirect()->back();

        }
    }
}
