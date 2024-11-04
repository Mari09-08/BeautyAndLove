@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Asociar Profesiones a {{ $profesional->nombre1 }} {{
                    $profesional->nombre2 }} {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</h5>
                <p class="mb-0">En esta seccion podras asociar las profesiones nesarias para el o la profesional</p>
                <form action="{{ route('dashboard.profesion.profesional.store', $profesional->id) }}" method="POST">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <select name="profesion" class="form-select @error('profesion') is-invalid @enderror">
                                <option value="" selected>Seleccione la profesión</option>
                                <!-- Asegúrate de que el value sea "" -->
                                @foreach ($profesiones as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->nombre }}</option>
                                @endforeach
                            </select>
                            @error('profesion')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="number" name="profesional" value="{{ $profesional->id }}" hidden>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-success">Agregar Profesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Profesiones de {{ $profesional->nombre1 }} {{
                    $profesional->nombre2 }} {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allProfesiones as $profesion)
                                <tr>
                                    <td>{{ $profesion->nombre }}</td>
                                    <td>{{ $profesion->descripcion }}</td>
                                    <td>
                                        <form action="{{ route('dashboard.admin.profesiones.destroy', $profesion->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Quitar Profesión</button>
                                            <input type="hidden" name="pro" value="{{ $profesional->id }}">
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center"> No existen datos relacionados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $allProfesiones->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection