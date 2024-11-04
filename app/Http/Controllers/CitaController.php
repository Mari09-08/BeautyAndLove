<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\CitaServicios;
use App\Models\Clientes;
use App\Models\Profesionales;
use App\Models\Servicios;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CitaController extends Controller
{
    public function index()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');

        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
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

        return view('admin.citas.index', compact('citas'));
    }

    public function canceladas()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');

        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
            ->where('status', 'cancelada')  // Filtrar citas con fecha mayor o igual a hoy
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

        return view('admin.citas.canceladas', compact('citas'));
    }

    public function realizadas()
    {
        // Obtener todas las citas, organizadas por fecha y con paginación
        $hoy = Carbon::now()->format('Y-m-d');

        // Obtener las citas con fechas futuras o iguales a hoy, y ordenarlas por fecha y hora
        $citas = Citas::with(['cliente', 'profesional', 'servicios'])
            ->where('status', 'realizada')  // Filtrar citas con fecha mayor o igual a hoy
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

        return view('admin.citas.realizadas', compact('citas'));
    }
    public function create()
    {
        $clientes = Clientes::all();
        $servicios = Servicios::all();
        return view('admin.citas.create', compact('clientes', 'servicios'));
    }


    public function store(Request $request)
    {
        // Obtener los servicios seleccionados y calcular la duración total
        $servicios = Servicios::whereIn('id', $request->servicios)->get();
        $duracionTotal = $servicios->sum('duracion');

        // Obtener los profesionales que pueden realizar los servicios seleccionados
        $profesionales = DB::table('profesional_servicios')
            ->join('profesionales', 'profesional_servicios.profesional_id', '=', 'profesionales.id')
            ->whereIn('profesional_servicios.servicio_id', $request->servicios)
            ->select('profesionales.*')
            ->distinct()
            ->get();

        $cliente_id = $request->cliente_id;
        return view('admin.citas.select_profesional', compact('request', 'profesionales', 'duracionTotal', 'cliente_id'));
    }


    public function confirmar(Request $request)
    {
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = Carbon::createFromFormat('H:i', date('H:i', strtotime($request->hora) + ($request->duracionTotal * 60)));

        $citas = Citas::where('profesional_id', $request->profesional_id)
            ->where('fecha', $request->fecha)
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
            $profesionales = DB::table('profesional_servicios')
                ->join('profesionales', 'profesional_servicios.profesional_id', '=', 'profesionales.id')
                ->whereIn('profesional_servicios.servicio_id', $serviciosSeleccionados) // Usa el array ya verificado
                ->select('profesionales.*')
                ->distinct()
                ->get();

            return view('admin.citas.select_profesional', [
                'profesionales' => $profesionales,
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

        return redirect()->route('citas.index')->with('success', 'Cita creada con éxito.');
    }

    public function destroy($id)
    {

        $cita = Citas::findOrFail($id);
        $cita->status = 'cancelada';
        $cita->save();

        Alert::success('Exito', 'Se cancelo la cita correctamente: ')
            ->persistent(true)
            ->autoClose(false);
        return redirect()->route('citas.index')->with('success', 'Cita cancelada correctamente.');
    }

}
