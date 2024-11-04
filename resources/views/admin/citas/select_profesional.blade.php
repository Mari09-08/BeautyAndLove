@extends('back.template')

@section('contenido')
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white"><i class="bi bi-person-badge-fill"></i> Confirmar Cita</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('citas.confirmar') }}" method="POST">
                    @csrf

                    <!-- Selección de Profesional -->
                    <div class="form-group mb-4">
                        <label for="profesional_id" class="form-label fw-bold"><i class="bi bi-person-fill"></i> Seleccionar
                            Profesional:</label>
                        <select name="profesional_id" id="profesional_id" class="form-select form-select-lg shadow-sm"
                            required>
                            <option value="" disabled selected>Seleccione un profesional</option>
                            @foreach ($profesionales as $profesional)
                                <option value="{{ $profesional->id }}"
                                    {{ old('profesional_id') == $profesional->id ? 'selected' : '' }}>
                                    {{ $profesional->nombre1 }} {{ $profesional->apellido1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campo de Fecha -->
                    <div class="form-group mb-4">
                        <label for="fecha" class="form-label fw-bold"><i class="bi bi-calendar-event-fill"></i>
                            Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control form-control-lg shadow-sm"
                            min="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Campo de Hora -->
                    <div class="form-group mb-4">
                        <label for="hora" class="form-label fw-bold"><i class="bi bi-clock-fill"></i> Hora de
                            inicio:</label>
                        <input type="time" name="hora" id="hora" class="form-control form-control-lg shadow-sm"
                            required>
                    </div>

                    <!-- Campos ocultos para datos adicionales -->
                    <div class="form-group">
                        @if (!empty($request->servicios))
                            <input type="hidden" name="servicios" value="{{ json_encode($request->servicios) }}">
                            <input type="hidden" name="duracionTotal" value="{{ $duracionTotal }}">
                            <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                        @else
                            <input type="hidden" name="servicios" value="{{ json_encode($servicios) }}">
                            <input type="hidden" name="duracionTotal" value="{{ $duracionTotal }}">
                            <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                        @endif
                    </div>

                    <!-- Botón de Confirmar -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm"><i
                                class="bi bi-check-circle-fill"></i> Confirmar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
