@extends('back.template')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Editar Producto</h5>
                <form action="{{ route('dashboard.admin.productos.update', $producto->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Nombre del Producto *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                value="{{ old('nombre', $producto->nombre) }}">
                            @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descrip') is-invalid @enderror" name="descrip"
                                rows="5">{{ old('descrip', $producto->descripcion) }}</textarea>
                            @error('descrip')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-6">
                            <label class="form-label">Precio *</label>
                            <input type="number" class="form-control @error('precio') is-invalid @enderror"
                                name="precio" value="{{ old('precio', $producto->precio) }}">
                            @error('precio')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-6">
                            <label class="form-label">Stock *</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                                value="{{ old('stock', $producto->stock) }}">
                            @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8 mb-6">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" class="form-select @error('categoria') is-invalid @enderror">
                                <option value="">Seleccione la categoría</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ?
                                    'selected' : '' }}>
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
                            <label class="form-label">Imagen Actual</label>
                            <br>
                            <img src="{{ asset($producto->url) }}" class="rounded img-zoom" height="70">
                        </div>
                        <div class="col-md-12 mb-6">
                            <label class="form-label">Nueva Imagen (opcional)</label>
                            <input class="form-control @error('ima') is-invalid @enderror" type="file" name="ima">
                            @error('ima')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection