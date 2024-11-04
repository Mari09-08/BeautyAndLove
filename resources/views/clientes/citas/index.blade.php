@extends('clientes.template')

@section('contenido')
    <div class="container mt-5">
        <div class="row">
            @foreach ($citas as $cita)
                <div class="col-md-6 col-lg-4 mb-4 d-flex">
                    <div class="card ficha shadow-sm border-0 w-100" style="position: relative;">
                        <!-- Icono de la ficha -->
                        <div class="pin-top-right">
                            <i class="bi bi-pin-angle-fill text-danger"></i>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><i class="bi bi-calendar2-event me-2"></i> {{ $cita->fecha }}</h5>
                            <p class="card-text text-muted">
                                <strong>Cliente:</strong> {{ $cita->cliente->nombre1 }} {{ $cita->cliente->apellido1 }}<br>
                                <strong>Profesional:</strong> {{ $cita->profesional->nombre1 }}
                                {{ $cita->profesional->apellido1 }}<br>
                                <strong>Hora de Inicio:</strong> {{ $cita->hora_inicio }}<br>
                                <strong>Hora de Fin:</strong> {{ $cita->hora_fin }}
                            </p>

                            <ul class="list-unstyled mb-4">
                                @foreach ($cita->servicios as $servicio)
                                    <li><i class="bi bi-check-circle-fill text-success"></i>
                                        {{ $servicio->nombre_servicio }}</li>
                                @endforeach
                            </ul>


                            <button class="btn btn-outline-primary w-100" style="text-transform: uppercase;">
                                <i class="bi bi-trash me-2"></i>{{ $cita->status }}
                            </button>
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

    <style>
        .ficha {
            border-radius: 12px;
            background-color: #f8f9fa;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .ficha:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .pin-top-right {
            position: absolute;
            top: -15px;
            right: -15px;
            font-size: 28px;
            z-index: 1;
            background-color: #fff;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-weight: 600;
            color: #343a40;
        }

        .card-text {
            margin-bottom: 20px;
        }

        .btn-outline-danger {
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        /* Para asegurar que todas las tarjetas tengan el mismo tamaño */
        .card {
            height: 100%;
        }

        /* Responsivo para pantallas pequeñas */
        @media (max-width: 768px) {
            .pin-top-right {
                font-size: 22px;
                top: -12px;
                right: -12px;
            }

            .ficha {
                margin-bottom: 20px;
            }

            .card-body {
                padding: 20px;
            }
        }
    </style>
@endsection
