@extends('clientes.template')

@section('contenido')
<div class="container">
    <h2>Tu carrito</h2>
    @if(!empty($detallePedido))
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detallePedido as $id => $producto)
                @php
                $productoEncontrado = $productos->where('id', $producto->producto_id)->first();
                @endphp
                <tr>
                    <td>{{ $id + 1 }}</td>
                    <td>{{ $productoEncontrado ? $productoEncontrado->nombre : 'Producto no encontrado' }}</td>
                    <td class="text-center">
                        {{ $producto['cantidad'] }}
                    </td>
                    <td class="text-center">
                        @if($producto['cantidad'] > 0)
                        ${{ number_format($producto->precio / $producto['cantidad'], 2) }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="text-center">${{ number_format($producto['precio'], 2) }}</td>
                    <td class="text-center">
                        <form action="{{ route('carrito.eliminar', $producto->id) }}" method="post">
                            @csrf
                            <button class="btn btn-danger" type="submit">Eliminar</button>    
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h4 id="total-carrito">${{ number_format($infoPedido->precio, 2) }}</h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Realizar Pedido
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Header de la Modal -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Resumen de tu Pedido</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- Cuerpo de la Modal -->
                <div class="modal-body">
                    <!-- Tabla de productos -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detallePedido as $id => $producto)
                                @php
                                $productoEncontrado = $productos->where('id', $producto->producto_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $productoEncontrado ? $productoEncontrado->nombre : 'Producto no encontrado'
                                        }}</td>
                                    <td>{{ $producto['cantidad'] }}</td>
                                    <td>
                                        @if($producto['cantidad'] > 0)
                                        ${{ number_format($producto->precio / $producto['cantidad'], 2) }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Total -->
                    <p class="text-end fw-bold">Total: ${{ number_format($infoPedido->precio, 2) }}</p>
                    <!-- Nota importante -->
                    <div class="alert alert-warning text-white" role="alert">
                        <strong>Nota Importante:</strong> Recuerda que no contamos con servicio a domicilio. Debes pasar
                        por tu pedido en nuestro local. ¡Muchas gracias!
                    </div>
                </div>
                <!-- Footer de la Modal -->
                <div class="modal-footer">
                    <form action="{{ route('carrito.confirmar', $infoPedido->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Confirmar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se puede eliminar, no contamos con inventario suficiente del producto: {{ $producto->nombre }}. Cantidad disponible: {{ $producto->stock }}',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#ff5733',  // Cambia el color del botón
            buttonsStyling: true,  // Aplica estilo al botón
        });
    </script>
    @else
    <p>Tu carrito está vacío.</p>
    @endif
</div>

@endsection