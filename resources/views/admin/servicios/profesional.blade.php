@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Asociar Servicios a {{ $profesional->nombre1 }} {{
                    $profesional->nombre2 }} {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</h5>
                <p class="mb-0">En esta seccion podras asociar los servicios para el o la profesional</p>
                <form action="{{ route('dashboard.profesion.servicios.store', $profesional->id) }}" method="POST">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <select name="servicio" class="form-select @error('servicio') is-invalid @enderror">
                                <option value="" selected>Seleccione el servicio</option>
                                @foreach ($servicios as $ser)
                                    <option value="{{ $ser->id }}">{{ $ser->nombre_servicio }}</option>
                                @endforeach
                            </select>
                            @error('servicio')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="number" name="profesional" value="{{ $profesional->id }}" hidden>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-success">Agregar Servicio</button>
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
                <h5 class="card-title fw-semibold mb-4">Servicios de {{ $profesional->nombre1 }} {{
                    $profesional->nombre2 }} {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</h5>
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
                                @forelse ($allServicios as $servicio)
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
                                        <form action="{{ route('dashboard.profesion.servicios.destroy', $servicio->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="profeId" value="{{ $profesional->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Quitar Servicio</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No existen datos relacionados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $allServicios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection