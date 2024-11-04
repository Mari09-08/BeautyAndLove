@extends('back.template')

@section('contenido')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Panel de Citas</h5>
                <p class="mb-0">
                    En esta sección podrás gestionar las Citas. Puedes crear nuevas citas, editar los detalles de las
                    existentes o eliminarlas según sea necesario. Mantén el control de tu agenda de manera eficiente y
                    organizada.
                </p>
                <div class="d-flex flex-wrap justify-content-between mt-3">
                    <a href="{{ route('citas.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Crear Cita
                    </a>
                    <a href="{{ route('citas.canceladas') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-user-plus"></i> Ver Citas Canceladas
                    </a>
                    <a href="{{ route('citas.realizadas') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-user-plus"></i> Ver Citas Realizadas
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            @foreach ($citas as $cita)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card ficha shadow-sm" style="position: relative;">
                        <!-- Icono de la ficha -->
                        <div class="pin-top-right">
                            <i class="bi bi-pin-angle-fill" style="color: red;"></i>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-calendar2-event"></i> {{ $cita->fecha }}</h5>
                            <p class="card-text">
                                <strong>Cliente:</strong> {{ $cita->cliente->nombre1 }} {{ $cita->cliente->apellido1 }}<br>
                                <strong>Profesional:</strong> {{ $cita->profesional->nombre1 }}
                                {{ $cita->profesional->apellido1 }}<br>
                                <strong>Hora de Inicio:</strong> {{ $cita->hora_inicio }}<br>
                                <strong>Hora de Fin:</strong> {{ $cita->hora_fin }}<br>
                            </p>
                            <ul class="list-unstyled">
                                @foreach ($cita->servicios as $servicio)
                                    <li><i class="bi bi-check-circle-fill"></i> {{ $servicio->nombre_servicio }}</li>
                                @endforeach
                            </ul>

                            <!-- Botón para cancelar cita -->
                            <form action="{{ route('citas.destroy', $cita->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta cita?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3"><i class="bi bi-trash"></i> Cancelar
                                    Cita</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $citas->links('pagination::bootstrap-4') }}
    </div>
    </div>

    <style>
        .ficha {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
            padding-top: 20px;
        }

        .ficha:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .pin-top-right {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 24px;
            z-index: 1;
        }
    </style>
@endsection
