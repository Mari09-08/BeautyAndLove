<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\CitaServicios;
use App\Models\Clientes;
use App\Models\Profesionales;
use App\Models\ProfesionalServicio;
use App\Models\Servicios;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfesionalCitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');
        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();
        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
            ->where('profesional_id',  $profesional->id)
            ->where('fecha', '>=', $hoy)
            ->where('status', 'agendada')  // Filtrar citas con fecha mayor o igual a hoy
            ->orderBy('fecha', 'asc')  // Ordenar por fecha ascendente
            ->orderBy('hora_inicio', 'asc')  // Ordenar por hora de inicio ascendente
            ->paginate(6);

        // Para cada cita, obtenemos manualmente el cliente, profesional y los servicios
        foreach ($citas as $cita) {
            $cita->cliente = Clientes::find($cita->cliente_id);
            $cita->profesional = Profesionales::find($cita->profesional_id);
            $cita->servicios = DB::table('cita_servicios')
                ->join('servicios', 'cita_servicios.id_servicio', '=', 'servicios.id')
                ->where('cita_servicios.id_cita', $cita->id)
                ->get();
        }

        return view('profesionales.citas.index', compact('citas'));
    }

    public function canceladas()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');

        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();
        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
            ->where('status', 'cancelada')  // Filtrar citas con fecha mayor o igual a hoy
            ->where('profesional_id', $profesional->id)
            ->orderBy('fecha', 'asc')  // Ordenar por fecha ascendente
            ->orderBy('hora_inicio', 'asc')  // Ordenar por hora de inicio ascendente
            ->paginate(6);
        
        // Para cada cita, obtenemos manualmente el cliente, profesional y los servicios
        foreach ($citas as $cita) {
            $cita->cliente = Clientes::find($cita->cliente_id);
            $cita->profesional = Profesionales::find($cita->profesional_id);
            $cita->servicios = DB::table('cita_servicios')
                ->join('servicios', 'cita_servicios.id_servicio', '=', 'servicios.id')
                ->where('cita_servicios.id_cita', $cita->id)
                ->get();
        }

        return view('profesionales.citas.canceladas', compact('citas'));
    }

    public function realizadas()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');
        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();
        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
            ->where('status', 'realizada') 
            ->where('profesional_id', $profesional->id)
            ->orderBy('fecha', 'asc')  // Ordenar por fecha ascendente
            ->orderBy('hora_inicio', 'asc')  // Ordenar por hora de inicio ascendente
            ->paginate(6);

        // Para cada cita, obtenemos manualmente el cliente, profesional y los servicios
        foreach ($citas as $cita) {
            $cita->cliente = Clientes::find($cita->cliente_id);
            $cita->profesional = Profesionales::find($cita->profesional_id);
            $cita->servicios = DB::table('cita_servicios')
                ->join('servicios', 'cita_servicios.id_servicio', '=', 'servicios.id')
                ->where('cita_servicios.id_cita', $cita->id)
                ->get();
        }

        return view('profesionales.citas.realizadas', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Clientes::all();
        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();
        $profesionalServicios = ProfesionalServicio::where('profesional_id', $profesional->id)->get();
        // Crea un array de los IDs de los servicios
        $servicioIds = $profesionalServicios->pluck('servicio_id');
        // Obtiene los servicios utilizando los IDs de servicio
        $servicios = Servicios::whereIn('id', $servicioIds)->get();
        // $servicios = Servicios::where();
        return view('profesionales.citas.create', compact('clientes', 'servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obtener los servicios seleccionados y calcular la duración total
        $servicios = Servicios::whereIn('id', $request->servicios)->get();
        $duracionTotal = $servicios->sum('duracion');

        // Obtener los profesionales que pueden realizar los servicios seleccionados
        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();

        $cliente_id = $request->cliente_id;
        return view('profesionales.citas.select_profesional', compact('request', 'profesional', 'duracionTotal', 'cliente_id'));
    }

    public function confirmar(Request $request)
    {
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = Carbon::createFromFormat('H:i', date('H:i', strtotime($request->hora) + ($request->duracionTotal * 60)));

        $citas = Citas::where('profesional_id', $request->profesional_id)
            ->where('fecha', $request->fecha)
            ->where('status', 'agendada')
            ->where(function ($query) use ($request, $horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                    ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                    ->orWhere(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '<=', $horaInicio)
                            ->where('hora_fin', '>=', $horaFin);
                    });
            })->count();

        if ($citas > 0) {
            Alert::error('Error', 'El profesional no está disponible en este horario.')
                ->persistent(true)
                ->autoClose(false);
            $serviciosSeleccionados = is_array($request->servicios) ? $request->servicios : json_decode($request->servicios, true);

            $servicios = Servicios::whereIn('id', $serviciosSeleccionados)->get();

            // Obtener los profesionales que pueden realizar los servicios seleccionados
            $profesionales = Profesionales::find($request->profesional_id);

            return view('profesionales.citas.select_profesional', [
                'profesional' => $profesionales,
                'duracionTotal' => $request->duracionTotal,
                'cliente_id' => $request->cliente_id,
                'servicios' => $serviciosSeleccionados,
            ]);
        }

        $horaFin = date('H:i', strtotime($request->hora) + ($request->duracionTotal * 60));

        // Guardar la cita
        $cita = Citas::create([
            'cliente_id' => $request->cliente_id,
            'profesional_id' => $request->profesional_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora,
            'hora_fin' => $horaFin,
        ]);
        // Guardar los servicios seleccionados
        foreach (json_decode($request->servicios) as $servicio_id) {
            CitaServicios::create([
                'id_cita' => $cita->id,
                'id_servicio' => $servicio_id,
            ]);
        }

        return redirect()->route('profesional.dashboard')->with('success', 'Cita creada con éxito.');
    }

    public function marcarComoRealizada($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->status = 'realizada'; // Cambia el estado de la cita
        $cita->save();
        Alert::success('Exito', 'Se cambio el estado correctamente.')
        ->persistent(true)
        ->autoClose(false);
        return redirect()->back()->with('success', 'Cita marcada como realizada.');
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
        $cita = Citas::findOrFail($id);
        $profesional = Profesionales::where('id_user', Auth()->user()->id)->first();
        $servicios = Servicios::all();
    
        return view('profesionales.citas.edit', compact('cita', 'profesional', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'profesional_id' => 'required|exists:profesionales,id',
        ]);
    
        // Obtener la cita actual y datos del profesional
        $cita = Citas::findOrFail($id);
        $profesional = Profesionales::findOrFail($request->profesional_id);
    
        // Calcular la hora de fin basada en la duración de la cita
        $duracionTotal = $cita->servicios->sum('duracion'); // Duración de los servicios en minutos
        $horaInicio = Carbon::parse($request->fecha . ' ' . $request->hora);
        $horaFin = $horaInicio->copy()->addMinutes($duracionTotal);
    
        // Validar que la nueva fecha/hora esté dentro del horario laboral del profesional
        $horaInicioProfesional = Carbon::parse($profesional->hora_inicio);
        $horaFinProfesional = Carbon::parse($profesional->hora_fin);
    
        if ($horaInicio->lt($horaInicioProfesional) || $horaFin->gt($horaFinProfesional)) {
            return redirect()->back()
                ->withInput()
                ->withErrors('La cita debe estar dentro del horario laboral del profesional.');
        }
    
        // Validar que el profesional esté disponible en la nueva fecha/hora
        $citasConflicto = Citas::where('profesional_id', $request->profesional_id)
            ->where('fecha', $request->fecha)
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                      ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                      ->orWhere(function ($query) use ($horaInicio, $horaFin) {
                          $query->where('hora_inicio', '<=', $horaInicio)
                                ->where('hora_fin', '>=', $horaFin);
                      });
            })
            ->where('id', '!=', $cita->id) // Excluir la cita actual
            ->exists();
    
        if ($citasConflicto) {
            return redirect()->back()
                ->withInput()
                ->withErrors('El profesional ya tiene una cita programada en ese horario.');
        }
    
        // Si pasa las validaciones, actualizar la cita
        $cita->fecha = $request->fecha;
        $cita->hora_inicio = $horaInicio;
        $cita->hora_fin = $horaFin;
        $cita->profesional_id = $request->profesional_id;
        $cita->save();
    
        return redirect()->route('profesional.dashboard')->with('success', 'Cita re-agendada correctamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Citas::findOrFail($id);
        $cita->status = 'cancelada';
        $cita->save();

        Alert::success('Exito', 'Se cancelo la cita correctamente: ')
            ->persistent(true)
            ->autoClose(false);
        return redirect()->route('profesional.dashboard')->with('success', 'Cita cancelada correctamente.');
    }
}
