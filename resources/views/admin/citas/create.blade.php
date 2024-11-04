@extends('back.template')

@section('contenido')
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center text-white">
                <h4 class="mb-0 text-white"><i class="bi bi-calendar-plus"></i> Crear Cita</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('citas.store') }}" method="POST">
                    @csrf

                    <!-- Selección de Cliente -->
                    <div class="form-group mb-4">
                        <label for="cliente_id" class="form-label fw-bold"><i class="bi bi-person-fill"></i> Seleccionar
                            Cliente:</label>
                        <select name="cliente_id" id="cliente_id" class="form-select form-select-lg shadow-sm" required>
                            <option value="" disabled selected>Seleccione un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre1 }} {{ $cliente->nombre2 }}
                                    {{ $cliente->apellido1 }} {{ $cliente->apellido2 }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Selección de Servicios -->
                    <div class="form-group mb-4">
                        <label for="servicios" class="form-label fw-bold"><i class="bi bi-list-check"></i> Seleccionar
                            Servicios:</label>
                        <div class="row g-3">
                            @foreach ($servicios as $servicio)
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="servicios[]"
                                            value="{{ $servicio->id }}" data-duracion="{{ $servicio->duracion }}"
                                            id="servicio-{{ $servicio->id }}">
                                        <label class="form-check-label" for="servicio-{{ $servicio->id }}">
                                            {{ $servicio->nombre_servicio }} ({{ $servicio->duracion }} mins)
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Puedes seleccionar múltiples servicios</small>
                    </div>

                    <!-- Mostrar la Duración Total -->
                    <div class="form-group mb-4">
                        <label for="duracion_total" class="form-label fw-bold"><i class="bi bi-clock"></i> Duración
                            total:</label>
                        <p class="fs-5"><strong><span id="duracion_total">0</span> minutos</strong></p>
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm"><i
                                class="bi bi-arrow-right-circle"></i> Siguiente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para calcular la duración total de los servicios seleccionados -->
    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"][data-duracion]');
        const duracionTotalElement = document.getElementById('duracion_total');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let totalDuracion = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        totalDuracion += parseInt(cb.getAttribute('data-duracion'));
                    }
                });
                duracionTotalElement.innerText = totalDuracion;
            });
        });
    </script>
@endsection
