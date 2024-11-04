@extends('back.template')

@section('contenido')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Panel de Productos</h5>
            <p class="mb-0">
                En esta sección podrás gestionar los Productos. Puedes crear nuevas
                productos, editar sus datos o eliminarlos según sea necesario.
            </p>

            <div class="mt-3">
                <a href="{{ route('dashboard.admin.productos.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Crear Producto
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Categorias Creadas</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Categoría</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($porductos as $producto)
                            <tr>
                                <td class="text-center"> <img src="{{ asset($producto->url) }}" class="rounded img-zoom" height="70"> </td>
                                <td> {{ $producto->nombre }} </td>
                                <td> {{ $producto->descripcion }} </td>
                                <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                <td> {{ number_format($producto->stock, 0, ',', '.') }}</td>
                                <td>{{ $categorias->where('id', $producto->categoria_id)->first()->nombre_categoria ??
                                    'Categoría no encontrada' }}</td>
                                <td>
                                    <button class="btn btn-sm me-2" id="toggle-status-{{ $producto->id }}"
                                        onclick="toggleStatus({{ $producto->id }})"
                                        style="color: white; background-color: {{ $producto->status ? '#dc3545' : '#28a745' }};">
                                        {{ $producto->status ? 'Desactivar' : 'Activar' }}
                                    </button>

                                    <form action="{{ route('dashboard.admin.productos.edit', $producto->id) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm me-2 mt-2">Editar</button>
                                    </form>

                                    <form action="{{ route('dashboard.admin.productos.destroy', $producto->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">Eliminar</button>
                                    </form>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center"> Sin datos </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $porductos->links() }}
            </div>
        </div>
    </div>
</div>
@push('js')

<script>
    function toggleStatus(productId) {
const button = document.getElementById('toggle-status-' + productId);

fetch(`/dashboard/admin/productos/status/${productId}`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF para proteger tu solicitud
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Actualizar el texto y el color del botón
        button.textContent = data.status ? 'Desactivar' : 'Activar';
        button.style.backgroundColor = data.status ? 'red' : 'green';
    } else {
        alert('Error: ' + data.message);
    }
})
.catch(error => {
    console.error('Error:', error);
});
}
</script>


@endpush
@endsection