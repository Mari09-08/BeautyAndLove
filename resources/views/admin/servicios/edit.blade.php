@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Editar Servicio</h5>
                <form action="{{ route('dashboard.admin.servicios.update', $servicio->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Nombre del Servicio *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $servicio->nombre_servicio) }}">
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descrip') is-invalid @enderror" name="descrip"
                                rows="5">{{ old('descrip', $servicio->descripcion) }}</textarea>
                            @error('descrip')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valor del servicio *</label>
                            <input type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio', $servicio->precio) }}">
                            @error('precio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">¿Cuánto tiempo en minutos demora el servicio?</label>
                            <input type="number" id="tiempo" class="form-control @error('tiempo') is-invalid @enderror" name="tiempo" value="{{ old('tiempo', $servicio->duracion) }}">
                            <small id="tiempo-mostrado" class="form-text text-muted"></small>
                            @error('tiempo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                        
                    </div>
                    <button type="submit" class="btn btn-success">Crear Servicio</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tiempoInput = document.getElementById('tiempo');
        const tiempoMostrado = document.getElementById('tiempo-mostrado');
    
        tiempoInput.addEventListener('input', function() {
            const minutos = parseInt(tiempoInput.value) || 0;
            const horas = Math.floor(minutos / 60);
            const restoMinutos = minutos % 60;
    
            tiempoMostrado.textContent = `Su estimado del tiempo es: ${horas}h ${restoMinutos}m`;
        });
    });
</script>    
@endpush
@endsection