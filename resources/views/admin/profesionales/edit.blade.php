@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Editando a {{ $profesional->nombre1 }} {{ $profesional->nombre2
                    }} {{ $profesional->apellido1 }} {{ $profesional->apellido2 }}</h5>
                <form action="{{ route('dashboard.admin.profesionales.update', $profesional->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer Nombre *</label>
                            <input type="text" class="form-control @error('nombre1') is-invalid @enderror"
                                name="nombre1" value="{{ old('nombre1', $profesional->nombre1) }}">
                            @error('nombre1')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control @error('nombre2') is-invalid @enderror"
                                name="nombre2" value="{{ old('nombre2', $profesional->nombre2) }}">
                            @error('nombre2')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer Apellido *</label>
                            <input type="text" class="form-control @error('apellido1') is-invalid @enderror"
                                name="apellido1" value="{{ old('apellido1', $profesional->apellido1) }}">
                            @error('apellido1')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control @error('apellido2') is-invalid @enderror"
                                name="apellido2" value="{{ old('apellido2', $profesional->apellido2) }}">
                            @error('apellido2')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="number" class="form-control @error('tel') is-invalid @enderror" name="tel"
                                value="{{ old('tel', $profesional->telefono) }}">
                            @error('tel')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">A que horas inicia</label>
                            <input type="time" class="form-control timepicker @error('horaIncio') is-invalid @enderror"
                                name="horaIncio" value="{{ old('horaIncio', $profesional->hora_inicio) }}">
                            @error('horaIncio')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">A que horas finaliza</label>
                            <input type="time" class="form-control timepicker @error('horaFin') is-invalid @enderror"
                                name="horaFin" value="{{ old('horaFin', $profesional->hora_fin) }}">
                            @error('horaFin')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                name="password">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Editar Profesional</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    flatpickr(".timepicker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K", // Formato de 12 horas con AM/PM
});
</script>
@endpush
@endsection