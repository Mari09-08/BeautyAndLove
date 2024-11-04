@extends('back.template')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white"><i class="bi bi-person-badge-fill"></i> Re-agendar Cita</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('profesional.update', $cita->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Seleccionar Fecha de la Cita -->
                <div class="form-group mt-3">
                    <label for="fecha">Fecha de la Cita:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $cita->fecha }}" min="{{ date('Y-m-d') }}" required>
                </div>
        
                <!-- Seleccionar Hora de la Cita -->
                <div class="form-group mt-3">
                    <label for="hora">Hora de la Cita:</label>
                    <input type="time" name="hora" id="hora" class="form-control" value="{{ $cita->hora_inicio }}" required>
                </div>
        
                <!-- Seleccionar Profesional -->
                <div class="form-group mt-3">
                    <label for="profesional">Profesional:</label>
                    <select name="profesional_id" id="profesional" class="form-control">
                            <option value="{{ $profesional->id }}" {{ $cita->profesional_id == $profesional->id ? 'selected' : '' }}>
                                {{ $profesional->nombre1 }} {{ $profesional->apellido1 }}
                            </option>
                    </select>
                </div>
        
                <!-- Botón para actualizar la cita -->
                <button type="submit" class="btn btn-primary mt-4">Re-agendar Cita</button>
            </form>
        </div>
    </div>
</div>

@endsection
