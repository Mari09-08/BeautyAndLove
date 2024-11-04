@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Crear Producto</h5>
                <form action="{{ route('dashboard.admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Nombre Del Productos *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                value="{{ old('nombre') }}">
                            @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descrip') is-invalid @enderror" name="descrip"
                                rows="5">{{ old('descrip') }}</textarea>
                            @error('descrip')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-6">
                            <label class="form-label">Precio *</label>
                            <input type="number" class="form-control @error('precio') is-invalid @enderror"
                                name="precio" value="{{ old('precio') }}">
                            @error('precio')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-6">
                            <label class="form-label">Stock *</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                                value="{{ old('stock') }}">
                            @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8 mb-6">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" class="form-select @error('categoria') is-invalid @enderror">
                                <option value="" selected>Seleccione la categoría
                                </option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                                @endforeach
                            </select>
                            @error('categoria')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Imagen *</label>
                            <input class="form-control @error('ima') is-invalid @enderror" type="file" name="ima"
                                value="{{ old('ima') }}" accept="image/png, image/jpeg, image/jpg">
                            @error('ima')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection