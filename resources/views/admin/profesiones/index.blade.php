@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Panel Profesiones</h5>
                <p class="mb-0">En esta seccion podras crar, editar, eliminar todas las profesiones que veas necesarias
                    para los profesionales que trabajan de tu lado</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold">Crear Profesion</h5>
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.profesiones.guardar') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre Profesión *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                value="{{ old('nombre') }}">
                            @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descrip') is-invalid @enderror" name="descrip"
                                rows="5">{{ old('descrip') }}</textarea>
                            @error('descrip')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Profesiones Creadas</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($profesiones as $profesion)
                                <tr>
                                    <td>{{ $profesion->nombre }}</td>
                                    <td>{{ $profesion->descripcion }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $profesion->id }}">
                                            Editar
                                        </button>
                                        
                                        <form action="{{ route('dashboard.admin.profesiones.eliminar', $profesion->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $profesion->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Profesión
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('dashboard.admin.profesiones.actualizar', $profesion->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Nombre Profesión *</label>
                                                        <input type="text"
                                                            class="form-control @error('nombreUp') is-invalid @enderror"
                                                            name="nombreUp"
                                                            value="{{ old('nombreUp', $profesion->nombre) }}">
                                                        @error('nombreUp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Descripción *</label>
                                                        <textarea
                                                            class="form-control @error('descripUP') is-invalid @enderror"
                                                            name="descripUP"
                                                            rows="5">{{ old('descripUP', $profesion->descripcion) }}</textarea>
                                                        @error('descripUP')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-success">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="3">No hay profesiones registradas en este momento.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Enlaces de paginación -->
                <div class="d-flex justify-content-center">
                    {{ $profesiones->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection