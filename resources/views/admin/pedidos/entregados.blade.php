@extends('back.template')

@section('contenido')
<style>
    .card-custom {
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-completado {
        border: 2px solid #28a745;
        background-color: #e9f7ef;
    }

    .card-pendiente {
        border: 2px solid #ffc107;
        background-color: #fff9e6;
    }

    .card-cancelado {
        border: 2px solid #dc3545;
        background-color: #f8d7da;
    }

    .btn-custom {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Panel de Pedidos Entregados</h5>
            <p class="mb-0">
                Aquí puedes consultar el historial de todos los pedidos que han sido entregados. 
                Revisa los detalles de cada entrega para mantener un registro claro y organizado. 
                Este historial te permitirá hacer un seguimiento eficiente de las órdenes completadas.
            </p>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        @foreach($pedidos as $pedido)
        <div class="col-md-4">
            <div class="card card-custom 
                {{ $pedido->estado == 'Reclamado' ? 'card-completado' : '' }}
                {{ $pedido->estado == 'Realizado' ? 'card-pendiente' : '' }}
                {{ $pedido->estado == 'Sin Reclamar' ? 'card-cancelado' : '' }}">
                <div class="card-body">
                    <h5 class="card-title">Pedido #{{ $pedido->id }}</h5>
                    <p class="card-text">Cliente: {{ optional($cliente->where('id', $pedido->cliente_id)->first())->nombre1 ?? '' }} 
                        {{ optional($cliente->where('id', $pedido->cliente_id)->first())->nombre2 ?? '' }}
                        {{ optional($cliente->where('id', $pedido->cliente_id)->first())->apellido1 ?? '' }}
                        {{ optional($cliente->where('id', $pedido->cliente_id)->first())->apellido2 ?? '' }}
                    </p>
                    <p class="card-text">Fecha: {{ $pedido->created_at->format('d/m/Y') }}</p>
                    <p class="card-text">Total: ${{ number_format($pedido->precio, 2) }}</p>
                    <p class="card-text">
                        Estado:
                        <span class="badge 
                            {{ $pedido->estado == 'Reclamado' ? 'bg-success' : '' }}
                            {{ $pedido->estado == 'Realizado' ? 'bg-warning' : '' }}
                            {{ $pedido->estado == 'Sin Reclamar' ? 'bg-danger' : '' }}">
                            {{ $pedido->estado }}
                        </span>
                    </p>
                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-sm btn-custom" data-bs-toggle="modal"
                        data-bs-target="#pedidoModal{{ $pedido->id }}">
                        Ver más
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="pedidoModal{{ $pedido->id }}" tabindex="-1"
            aria-labelledby="pedidoModalLabel{{ $pedido->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pedidoModalLabel{{ $pedido->id }}">Detalles del Pedido #{{
                            $pedido->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <!-- Lista de productos -->
                                @foreach($detallesPedidos as $detalle)
                                    @if ($detalle->pedido_id == $pedido->id)
                                        @php
                                            $productoEncontrado = $productos->where('id', $detalle->producto_id)->first();
                                        @endphp
                                        <div class="col-12 mb-3">
                                            <div class="card shadow-sm">
                                                <div class="card-body d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="card-title mb-0">{{ $productoEncontrado->nombre }}</h6>
                                                        <p class="mb-0">Cantidad: <strong>{{ $detalle->cantidad }}</strong></p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Total: <strong>${{
                                                                number_format($detalle->precio, 2) }}</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Total del Pedido -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-primary text-center">
                                        <strong>Total del Pedido:</strong> ${{ number_format($pedido->precio, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection