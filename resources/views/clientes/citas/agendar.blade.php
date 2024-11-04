@extends('clientes.template')

@section('contenido')
    <div class="container py-5">
        <h2 class="text-center font-weight-bold mb-5" style="font-size: 2rem; color: #343a40;">Agendar una Cita</h2>

        <!-- Errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-5 rounded-lg shadow-lg" style="background-color: #f8f9fa;">
            <form id="agendarCita" action="{{ route('clientes.citas.store') }}" method="POST">
                @csrf

                <!-- Selección de Servicios -->
                <div class="form-group">
                    <label for="servicios" class="font-weight-bold" style="font-size: 1.2rem;">Selecciona los
                        servicios:</label>
                    @foreach ($servicios as $servicio)
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="servicios[]" value="{{ $servicio->id }}"
                                id="servicio{{ $servicio->id }}">
                            <label class="form-check-label"
                                for="servicio{{ $servicio->id }}">{{ $servicio->nombre_servicio }}
                                ({{ $servicio->duracion }} minutos)</label>
                        </div>
                    @endforeach
                </div>

                <!-- Selección de Profesional (cargado dinámicamente) -->
                <div class="form-group mt-3">
                    <label for="profesional" class="font-weight-bold" style="font-size: 1.2rem;">Selecciona un
                        profesional:</label>
                    <select name="profesional_id" id="profesional" class="form-select" required></select>
                </div>

                <!-- Selección de Fecha -->
                <div class="form-group mt-3">
                    <label for="fecha" class="font-weight-bold" style="font-size: 1.2rem;">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control"
                        min="{{ now()->toDateString() }}" required>
                </div>

                <!-- Selección de Hora (cargada dinámicamente) -->
                <div class="form-group mt-3">
                    <label for="hora" class="font-weight-bold" style="font-size: 1.2rem;">Hora:</label>
                    <select name="hora" id="hora" class="form-control" required></select>
                </div>

                <!-- Botón para agendar -->
                <button type="submit" class="btn btn-primary btn-block mt-4">
                    Agendar Cita
                </button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            // AJAX para cargar profesionales según los servicios seleccionados
            $('input[name="servicios[]"]').change(function() {
                var serviciosSeleccionados = $('input[name="servicios[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if (serviciosSeleccionados.length > 0) {
                    $.ajax({
                        url: '{{ route('clientes.citas.getProfesionales') }}',
                        type: 'GET',
                        data: {
                            servicios: serviciosSeleccionados
                        },
                        success: function(profesionales) {
                            var selectProfesional = $('#profesional');
                            selectProfesional.empty();

                            $.each(profesionales, function(key, profesional) {
                                selectProfesional.append('<option value="' + profesional.id + '">' +
                                    profesional.nombre1 + ' ' + profesional.apellido1 +
                                    '</option>');
                            });
                        }
                    });
                }
            });

            // AJAX para cargar horas disponibles según el profesional y fecha
            $('#fecha').change(function() {
                var profesional_id = $('#profesional').val();
                var fecha = $(this).val();

                if (profesional_id && fecha) {
                    $.ajax({
                        url: '{{ route('clientes.citas.getDisponibilidad') }}',
                        type: 'GET',
                        data: {
                            profesional_id: profesional_id,
                            fecha: fecha
                        },
                        success: function(disponibilidad) {
                            var selectHora = $('#hora');
                            selectHora.empty();

                            $.each(disponibilidad, function(key, bloque) {
                                selectHora.append('<option value="' + bloque.inicio + '">' + bloque
                                    .inicio + '</option>');
                            });
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
