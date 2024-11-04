<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Profesionales;
use App\Models\ProfesionalProfesiones;
use App\Models\ProfesionalServicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class TrabajadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesionales = Profesionales::paginate(10);
        $users = User::where('rol', 2)->get();
        return view('admin.profesionales.index', compact('profesionales', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profesionales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre1' => 'required|string|max:25',
            'nombre2' => 'nullable|string|max:25',
            'apellido1' => 'required|string|max:25',
            'apellido2' => 'nullable|string|max:25',
            'tel' => 'required|numeric|digits_between:7,15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'horaIncio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i',
        ], [
            'nombre1.required' => 'El primer nombre es obligatorio.',
            'nombre1.max' => 'El primer nombre no puede exceder los 25 caracteres.',

            'nombre2.max' => 'El segundo nombre no puede exceder los 25 caracteres.',

            'apellido1.required' => 'El primer apellido es obligatorio.',
            'apellido1.max' => 'El primer apellido no puede exceder los 25 caracteres.',

            'apellido2.max' => 'El segundo apellido no puede exceder los 25 caracteres.',

            'tel.required' => 'El teléfono es obligatorio.',
            'tel.numeric' => 'El teléfono debe ser un número válido.',
            'tel.digits_between' => 'El teléfono debe tener entre 7 y 15 dígitos.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'horaIncio.required' => 'El campo de hora de inicio es obligatorio.',
            'horaIncio.date_format' => 'El campo de hora de inicio debe tener el formato HH:MM.',
            'horaFin.required' => 'El campo de hora de fin es obligatorio.',
            'horaFin.date_format' => 'El campo de hora de fin debe tener el formato HH:MM.',
        ]);


        if (strtotime($request->horaFin) <= strtotime($request->horaIncio)) {
            Alert::error('Error', 'La hora de fin debe ser mayor que la hora de inicio.');
            return back();
        }

        try {
            $fullName = trim($request['nombre1'] . ' ' . $request['nombre2'] . ' ' . $request['apellido1'] . ' ' . $request['apellido2']);
            // Crear el registro usando asignación masiva

            // Crear el usuario
            $dUser = User::create([
                'name' => $fullName,
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'rol' => 2,
            ]);

            // Crear el cliente asociado
            Profesionales::create([
                'nombre1' => $request['nombre1'],
                'nombre2' => $request['nombre2'],
                'apellido1' => $request['apellido1'],
                'apellido2' => $request['apellido2'],
                'telefono' => $request['tel'],
                'hora_inicio' => $request['horaIncio'],
                'hora_fin' => $request['horaFin'],
                'id_user' => $dUser->id,
            ]);


            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El profesional se ha creado correctamente.');
            return redirect()->route('dashboard.admin.profesionales');

        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al crear el profesional. Inténtalo de nuevo más tarde.');

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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Buscar el profesional, o lanzar una excepción si no se encuentra
            $profesional = Profesionales::findOrFail($id);

            // Buscar el usuario asociado, o lanzar una excepción si no se encuentra
            $user = User::findOrFail($profesional->id_user);

            // Retornar la vista con los datos del usuario y del profesional
            return view('admin.profesionales.edit', compact('user', 'profesional'));

        } catch (\Exception $e) {
            // Registrar el error en los logs
            \Log::error('Error al intentar editar el profesional: ' . $e->getMessage());

            // Redirigir al usuario con un mensaje de error
            Alert::error('Error', 'El profesional o el usuario asociado no se pudo encontrar.');
            return redirect()->route('dashboard.admin.profesionales.index');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Convertir la hora de 12 horas (AM/PM) a 24 horas
        $horaInicio = date("H:i", strtotime($request->horaIncio));
        $horaFin = date("H:i", strtotime($request->horaFin));

        // Sobrescribir los valores de hora con el formato de 24 horas
        $request->merge([
            'horaIncio' => $horaInicio,
            'horaFin' => $horaFin,
        ]);


        $request->validate([
            'nombre1' => 'required|string|max:25',
            'nombre2' => 'nullable|string|max:25',
            'apellido1' => 'required|string|max:25',
            'apellido2' => 'nullable|string|max:25',
            'tel' => 'required|numeric|digits_between:7,15',
            'password' => 'nullable|string|min:8',
            'horaIncio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i',
        ], [
            'nombre1.required' => 'El primer nombre es obligatorio.',
            'nombre1.max' => 'El primer nombre no puede exceder los 25 caracteres.',

            'nombre2.max' => 'El segundo nombre no puede exceder los 25 caracteres.',

            'apellido1.required' => 'El primer apellido es obligatorio.',
            'apellido1.max' => 'El primer apellido no puede exceder los 25 caracteres.',

            'apellido2.max' => 'El segundo apellido no puede exceder los 25 caracteres.',

            'tel.required' => 'El teléfono es obligatorio.',
            'tel.numeric' => 'El teléfono debe ser un número válido.',
            'tel.digits_between' => 'El teléfono debe tener entre 7 y 15 dígitos.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'horaIncio.required' => 'El campo de hora de inicio es obligatorio.',
            'horaIncio.date_format' => 'El campo de hora de inicio debe tener el formato HH:MM.',
            'horaFin.required' => 'El campo de hora de fin es obligatorio.',
            'horaFin.date_format' => 'El campo de hora de fin debe tener el formato HH:MM.',
        ]);


        if (strtotime($request->horaFin) <= strtotime($request->horaIncio)) {
            Alert::error('Error', 'La hora de fin debe ser mayor que la hora de inicio.');
            return back();
        }

        try {
            // Buscar el profesional y su usuario asociado
            $profesional = Profesionales::find($id);
            $user = User::find($profesional->id_user);

            // Actualizar el usuario solo si el campo password tiene algún valor
            $fullName = trim($request['nombre1'] . ' ' . $request['nombre2'] . ' ' . $request['apellido1'] . ' ' . $request['apellido2']);
            // Actualizar los datos del usuario
            $user->name = $fullName;
            // Solo actualizar la contraseña si se envía una nueva
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Actualizar el registro del profesional
            $profesional->update([
                'nombre1' => $request['nombre1'],
                'nombre2' => $request['nombre2'],
                'apellido1' => $request['apellido1'],
                'apellido2' => $request['apellido2'],
                'telefono' => $request['tel'],
                'hora_inicio' => $request['horaIncio'],
                'hora_fin' => $request['horaFin'],
            ]);

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El profesional se ha actualizado correctamente.');
            return redirect()->route('dashboard.admin.profesionales');
        } catch (\Exception $e) {
            // Capturar cualquier error que ocurra en el proceso y mostrar una alerta
            Alert::error('Error', 'Ocurrió un problema al actualizar el profesional. Inténtalo de nuevo más tarde.');

            // Puedes usar dd($e->getMessage()) para depurar si es necesario
            \Log::error('Error al actualizar el profesional: ' . $e->getMessage());

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
            $profesion = ProfesionalProfesiones::where('id_profesional', $id)->get();
            if ($profesion->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar al profesional porque está asociada a uno o más profesion. Desasocie la profesión antes de eliminarla.');
                return redirect()->back();
            }

            $servicios = ProfesionalServicio::where('profesional_id', $id)->get();
            if ($servicios->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar al profesional porque está asociada a uno o más servicios. Desasocie el servicio antes de eliminarla.');
                return redirect()->back();
            }

            $citas = Citas::where('profesional_id', $id)->get();
            if ($citas->isNotEmpty()) {
                // Si está asociada a un profesional, no permitir eliminar
                Alert::error('Error', 'No se puede eliminar al profesional porque está asociada a uno o más citas.');
                return redirect()->back();
            }

            // Si no está asociada a ningún profesional, proceder a eliminar
            $profesion = Profesionales::findOrFail($id);
            $profesion->delete();

            // Redirigir con mensaje de éxito
            Alert::success('Éxito', 'El profesional ha sido eliminada correctamente.');
            return redirect()->route('dashboard.admin.profesionales');

        } catch (\Exception $e) {
            // Manejar el error si ocurre alguna excepción
            Alert::error('Error', 'Hubo un problema al eliminar la profesión.'. $e->getMessage());
            \Log::error('Error al eliminar la profesión: ' . $e->getMessage());
            return redirect()->back();

        }
    }
}
