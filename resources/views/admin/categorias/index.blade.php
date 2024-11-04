@extends('back.template')

@section('contenido')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Panel de Categorias</h5>
            <p class="mb-0">
                En esta sección podrás gestionar las categorias de tus productos. Puedes crear nuevas
                categorias, editar sus datos o eliminarlos según sea necesario.
            </p>

            <!-- Botón para crear un nuevo profesional -->
            <div class="mt-3">
                <a href="{{ route('dashboard.admin.categorias.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Crear categoria
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
                                <th scope="col">Nombres</th>
                                <th scope="col">Descripción</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorias as $categoria)
                            <tr>
                                <td> {{ $categoria->nombre_categoria }} </td>
                                <td> {{ $categoria->descripcion }} </td>
                                <td>
                                    <form action="{{ route('dashboard.admin.categorias.edit', $categoria->id) }}"
                                        method="GET" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm me-2">Editar</button>
                                    </form>
                                    <form action="{{ route('dashboard.admin.categorias.destroy', $categoria->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center"> Sin datos </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</div>

@endsection