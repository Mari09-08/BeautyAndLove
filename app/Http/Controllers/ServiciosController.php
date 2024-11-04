<?php

namespace App\Http\Controllers;

use App\Models\CitaServicios;
use App\Models\ProfesionalServicio;
use App\Models\Servicios;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicios::orderBy('nombre_servicio', 'asc')->paginate(5);
        return view('admin.servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descrip' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'tiempo' => 'required|integer|min:5|regex:/^\d+$/',
        ], [
            // Mensajes personalizados de validación
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre del servicio debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del servicio no debe exceder 255 caracteres.',
            'descrip.required' => 'La descripción del servicio es obligatoria.',
            'descrip.string' => 'La descripción del servicio debe ser una cadena de texto.',
            'descrip.max' => 'La descripción del servicio no debe exceder 1000 caracteres.',
            'precio.required' => 'El valor del servicio es obligatorio.',
            'precio.numeric' => 'El valor del servicio debe ser un número.',
            'precio.min' => 'El valor del servicio no puede ser negativo.',
            'tiempo.required' => 'El tiempo de servicio es obligatorio.',
            'tiempo.integer' => 'El tiempo de servicio debe ser un número entero.',
            'tiempo.min' => 'El tiempo de servicio debe ser de al menos 5 minutos.',
            'tiempo.regex' => 'El tiempo de servicio debe ser un número sin puntos.',
        ]);
    
        try {
            Servicios::create([
                'nombre_servicio' => $validatedData['nombre'],
                'descripcion' => $validatedData['descrip'],
                'duracion' => $validatedData['tiempo'],
                'precio' => $validatedData['precio'],
            ]);
    
            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El servicio se ha creado correctamente.');
            return redirect()->route('dashboard.admin.servicios');

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear el servicio. Inténtalo de nuevo más tarde.');

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error al crear el profesion: ' . $e->getMessage());

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

            $servicio = Servicios::findOrFail($id);
            return view('admin.servicios.edit', compact('servicio'));

        } catch (\Exception $e) {

            \Log::error('Error al intentar editar el servicio: ' . $e->getMessage());

            Alert::error('Error', 'El servicio asociado no se pudo encontrar.');
            return redirect()->route('dashboard.admin.servicios');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descrip' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'tiempo' => 'required|integer|min:5|regex:/^\d+$/',
        ], [
            // Mensajes personalizados de validación
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre del servicio debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del servicio no debe exceder 255 caracteres.',
            'descrip.required' => 'La descripción del servicio es obligatoria.',
            'descrip.string' => 'La descripción del servicio debe ser una cadena de texto.',
            'descrip.max' => 'La descripción del servicio no debe exceder 1000 caracteres.',
            'precio.required' => 'El valor del servicio es obligatorio.',
            'precio.numeric' => 'El valor del servicio debe ser un número.',
            'precio.min' => 'El valor del servicio no puede ser negativo.',
            'tiempo.required' => 'El tiempo de servicio es obligatorio.',
            'tiempo.integer' => 'El tiempo de servicio debe ser un número entero.',
            'tiempo.min' => 'El tiempo de servicio debe ser de al menos 5 minutos.',
            'tiempo.regex' => 'El tiempo de servicio debe ser un número sin puntos.',
        ]);
    
        try {
            $servicio = Servicios::findOrFail($id);
            $servicio->update([
                'nombre_servicio' => $validatedData['nombre'],
                'descripcion' => $validatedData['descrip'],
                'duracion' => $validatedData['tiempo'],
                'precio' => $validatedData['precio'],
            ]);

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El servicio se ha editado correctamente.');
            return redirect()->route('dashboard.admin.servicios');

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear el servicio. Inténtalo de nuevo más tarde.');

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error al crear el profesion: ' . $e->getMessage());

            // Redirigir con la entrada actual del formulario
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
            $dataOtra = ProfesionalServicio::where('servicio_id', $id)->get();

            if ($dataOtra->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar el servicio porque está asociada a uno o más profesionales. No se puede realizar esta acción.');
                return redirect()->back();
            }

            $dataOtra2 = CitaServicios::where('id_servicio', $id)->get();

            if ($dataOtra2->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar el servicio porque está asociada a uno o más citas. No se puede realizar esta acción.');
                return redirect()->back();
            }

            // Si no está asociada a ningún profesional, proceder a eliminar
            $servicio = Servicios::findOrFail($id);
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
