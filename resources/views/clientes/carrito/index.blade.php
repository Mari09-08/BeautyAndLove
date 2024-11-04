@extends('clientes.template')

@section('contenido')
<div class="container">
    <h2>Productos</h2>
    <div class="row">
        @foreach($productos as $producto)
        <div class="col-md-4 mt-2">
            <div class="card mb-4 h-100">
                <!-- Agregamos lazy loading y mejoramos el estilo de la imagen -->
                <img src="{{ $producto->url }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}"
                    loading="lazy" style="height: 250px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="card-text flex-grow-1">{{ $producto->descripcion }}</p>
                    <p class="card-text">Precio: ${{ number_format($producto->precio, 2) }}</p>
                    @auth
                    <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                        @csrf
                        <button class="btn btn-primary agregar-carrito mt-auto" type="submit">Agregar al
                            carrito</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Agregamos la paginación -->
    <div class="d-flex justify-content-center mt-3">
        {{ $productos->links() }}
    </div>
</div>
@endsection