@extends('back.template')

@section('contenido')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Panel de Servicios</h5>
            <p class="mb-0">
                En esta sección podrás gestionar los servicios de tu organización. Puedes crear nuevos
                servicios, editar sus datos o eliminarlos según sea necesario.
            </p>

            <!-- Botón para crear un nuevo servicio -->
            <div class="mt-3">
                <a href="{{ route('dashboard.admin.servicios.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Crear Servicio
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Servicios Creados</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Duracion</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($servicios as $servicio)
                            <tr>
                                <td>{{ $servicio->nombre_servicio }}</td>
                                <td>{{ $servicio->descripcion }}</td>
                                <td>{{ $servicio->precio }}</td>
                                <td>
                                    @php
                                        $hours = intdiv($servicio->duracion, 60);
                                        $minutes = $servicio->duracion % 60;
                                    @endphp
                                    {{ $hours }}h {{ $minutes }}m
                                </td>
                                <td>
                                    <form action="{{ route('dashboard.admin.servicios.edit', $servicio->id) }}"
                                        method="GET" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm me-2">Editar</button>
                                    </form>
                                    <form action="{{ route('dashboard.admin.servicios.destroy', $servicio->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"> Sin Datos</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $servicios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection