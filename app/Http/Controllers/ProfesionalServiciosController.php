<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\CitaServicios;
use App\Models\Profesionales;
use App\Models\ProfesionalServicio;
use App\Models\Servicios;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfesionalServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        // Obtener el profesional
        $profesional = Profesionales::findOrFail($id);

        // Obtener las relaciones existentes entre el profesional y las profesiones
        $relacion = ProfesionalServicio::where('profesional_id', $id)->pluck('servicio_id')->toArray();

        // Obtener los servicios que NO están relacionadas con el profesional
        $servicios = Servicios::whereNotIn('id', $relacion)
            ->orderBy('nombre_servicio', 'asc') // Ordenar por nombre_servicio ascendente
            ->get();

        $allServicios = Servicios::whereIn('id', $relacion)->orderBy('nombre_servicio', 'asc')->paginate(10);

        return view('admin.servicios.profesional', compact('profesional', 'relacion', 'servicios', 'allServicios'));
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
            'servicio' => 'required',
        ], [
            'servicio.required' => 'Debe de selecionar un servicio, es obligatorio.',
        ]);

        try {
            $data = new ProfesionalServicio();
            $data->profesional_id = $request->profesional;
            $data->servicio_id = $request->servicio;
            $data->save();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El servicio se ha asociado correctamente.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear. Inténtalo de nuevo más tarde. ' . $e->getMessage());

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error: ' . $e->getMessage());

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
            // Verificar si la profesión está asociada a un profesional
            // Obtener todas las citas asociadas al profesional
            $citas = Citas::where('profesional_id', $request->profeId)->get();

            // Inicializar una variable para determinar si el servicio está asociado a alguna cita
            $estaAsociada = false;

            // Iterar sobre cada cita del profesional
            foreach ($citas as $cita) {
                // Verificar si el servicio está asociado a la cita actual
                $citaServicio = CitaServicios::where('id_servicio', $id)
                                            ->where('id_cita', $cita->id)
                                            ->first(); // Obtener el primer resultado

                if ($citaServicio) {
                    // Si se encuentra una relación, marcar como asociado y salir del bucle
                    $estaAsociada = true;
                    break;
                }
            }

            // Si el servicio está asociado a una o más citas, mostrar el mensaje de error
            if ($estaAsociada) {
                Alert::error('Error', 'No se puede eliminar el servicio porque está asociado a una o más citas. No se puede realizar esta acción.');
                return redirect()->back();
            }

            // Si no está asociada a ningún profesional, proceder a eliminar
            $servicio = ProfesionalServicio::where('profesional_id', $request->profeId)
                ->where('servicio_id', $id)
                ->first();

            if ($servicio) {
                $servicio->delete();
            }

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El servicio ha sido eliminada correctamente.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Manejar el error si ocurre alguna excepción
            Alert::error('Error', 'Hubo un problema al eliminar el servicio.' . $e->getMessage());
            \Log::error('Error al eliminar el servicio: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
