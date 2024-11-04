@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Crear Categoria</h5>
                <form action="{{ route('dashboard.admin.categorias.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Nombre De La Categoria *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}">
                            @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descrip') is-invalid @enderror" name="descrip" rows="5">{{ old('descrip') }}</textarea>
                            @error('descrip')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
