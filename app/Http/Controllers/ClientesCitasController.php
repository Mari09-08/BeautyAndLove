<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Citas;
use App\Models\CitaServicios;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Profesionales;
use App\Models\Servicios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientesCitasController extends Controller
{
    public function index()
    {
        try {
            $clientes = Clientes::all();
            $servicios = Servicios::all();
            $profesionales = Profesionales::all();
            $productos = Productos::where('status', true)->get();
            $profesionales = Profesionales::all();
            $servicios = Servicios::all();
            $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();
            $hoy = Carbon::now()->format('Y-m-d');
            $cliente = Clientes::where('id_user', auth()->user()->id)->first();  // Obtener el cliente basado en el id_user

            $citas = Citas::with(['cliente', 'profesional', 'servicios'])
                ->where('cliente_id', $cliente->id)  // Filtrar por el cliente autenticado
                ->where('fecha', '>=', $hoy)  // Mantener la condición de fecha mayor o igual a hoy
                ->orderBy('fecha', 'asc')  // Ordenar por fecha ascendente
                ->orderBy('hora_inicio', 'asc')  // Ordenar por hora de inicio ascendente
                ->paginate(6);  // Paginación

            return view('clientes.citas.index', compact('citas','clientes', 'servicios', 'profesionales', 'productos', 'profesionales', 'servicios', 'categorias'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Hubo un problema al cargar las citas.')
                ->persistent(true)
                ->autoClose(false);
            return redirect()->back()->withErrors('Hubo un error al cargar las citas.');
        }
    }

    public function create()
    {
        try {
            $clientes = Clientes::all();
            $servicios = Servicios::all();
            $profesionales = Profesionales::all();
            $productos = Productos::where('status', true)->get();
            $profesionales = Profesionales::all();
            $servicios = Servicios::all();
            $categorias = CategoriasProductos::orderBy('nombre_categoria', 'ASC')->get();

            return view('clientes.citas.agendar', compact('clientes', 'servicios', 'profesionales', 'productos', 'profesionales', 'servicios', 'categorias'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Hubo un problema al cargar los datos necesarios.')
                ->persistent(true)
                ->autoClose(false);
            return redirect()->back()->withErrors('Ocurrió un error al cargar el formulario de citas.');
        }
    }
    // Obtener los profesionales que pueden realizar los servicios seleccionados
    public function getProfesionales(Request $request)
    {
        $serviciosSeleccionados = $request->servicios;

        // Filtrar profesionales que ofrezcan todos los servicios seleccionados
        $profesionales = Profesionales::whereHas('servicios', function ($query) use ($serviciosSeleccionados) {
            $query->whereIn('servicio_id', $serviciosSeleccionados);
        })->get();

        return response()->json($profesionales);
    }

    // Obtener la disponibilidad del profesional en un día específico
    public function getDisponibilidad(Request $request)
    {
        $profesional_id = $request->profesional_id;
        $fecha = $request->fecha;

        $profesional = Profesionales::findOrFail($profesional_id);

        // Horario del profesional
        $horaInicio = Carbon::parse($profesional->hora_inicio);
        $horaFin = Carbon::parse($profesional->hora_fin);

        // Citas existentes para ese día
        $citas = Citas::where('profesional_id', $profesional_id)
            ->whereDate('fecha', $fecha)
            ->get(['hora_inicio', 'hora_fin']);

        // Generar bloques de tiempo disponibles
        $disponibilidad = $this->generarBloquesDisponibles($horaInicio, $horaFin, $citas);

        return response()->json($disponibilidad);
    }

    // Función para generar bloques de tiempo disponibles
    private function generarBloquesDisponibles($horaInicio, $horaFin, $citas)
    {
        $intervalo = 30;  // Intervalo de 30 minutos
        $bloquesDisponibles = [];

        // Generar los bloques entre la hora de inicio y fin del profesional
        while ($horaInicio->lt($horaFin)) {
            $horaBloqueFin = $horaInicio->copy()->addMinutes($intervalo);

            // Revisar si el bloque está libre
            $ocupado = $citas->contains(function ($cita) use ($horaInicio, $horaBloqueFin) {
                return Carbon::parse($cita->hora_inicio)->lt($horaBloqueFin) && Carbon::parse($cita->hora_fin)->gt($horaInicio);
            });

            if (!$ocupado) {
                $bloquesDisponibles[] = [
                    'inicio' => $horaInicio->format('H:i'),
                    'fin' => $horaBloqueFin->format('H:i')
                ];
            }

            $horaInicio->addMinutes($intervalo);
        }

        return $bloquesDisponibles;
    }

    // Guardar la cita con los servicios seleccionados
    public function store(Request $request)
    {
        $request->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $cliente_id = auth()->user()->cliente->id;

        // Guardar la cita
        $cita = Citas::create([
            'cliente_id' => $cliente_id,
            'profesional_id' => $request->profesional_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora,
            'hora_fin' => Carbon::parse($request->hora)->addMinutes($request->duracionTotal),  // Calcula la hora de fin
        ]);

        // Guardar los servicios seleccionados
        foreach ($request->servicios as $servicio) {
            CitaServicios::create([
                'id_cita' => $cita->id,
                'id_servicio' => $servicio,
            ]);
        }
        Alert::success('Exito', 'Se agendo la cita con exito')
        ->persistent(true)
        ->autoClose(false);
        return redirect()->route('clientes.citas.index')->with('success', 'Cita agendada con éxito.');
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
