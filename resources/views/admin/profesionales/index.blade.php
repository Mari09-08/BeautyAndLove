@extends('back.template')

@section('contenido')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Panel de Profesionales</h5>
            <p class="mb-0">
                En esta sección podrás gestionar los profesionales de tu organización. Puedes crear nuevos
                profesionales, editar sus datos o eliminarlos según sea necesario.
            </p>

            <!-- Botón para crear un nuevo profesional -->
            <div class="mt-3">
                <a href="{{ route('dashboard.admin.profesionales.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Crear Profesional
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Profesionales Creados</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Telélefono</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Hora Inicio / Hora Fin</th>
                                <th scope="col">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($profesionales as $profesional)
                            <tr>
                                <td> {{ $profesional->nombre1 }} {{ $profesional->nombre2 }}</td>
                                <td> {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</td>
                                <td> {{ $profesional->telefono }} </td>
                                <td>{{ $users->firstWhere('id', $profesional->id_user)->email }}
                                <td> {{ \Carbon\Carbon::parse($profesional->hora_inicio)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($profesional->hora_fin)->format('h:i A') }} </td>
                                <td>
                                    <form action="{{ route('dashboard.profesion.profesional', $profesional->id) }}"
                                        method="GET" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm me-2">Profesiones</button>
                                    </form>
                                    <form action="{{ route('dashboard.profesion.servicios', $profesional->id) }}"
                                        method="GET" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm me-2">Servicios</button>
                                    </form>
                                    <form action="{{ route('dashboard.admin.profesionales.edit', $profesional->id) }}"
                                        method="GET" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm me-2">Editar</button>
                                    </form>
                                    <form action="{{ route('dashboard.admin.profesionales.delete', $profesional->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"> </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $profesionales->links() }}
            </div>
        </div>
    </div>
</div>

@endsection