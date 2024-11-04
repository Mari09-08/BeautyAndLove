<nav
    class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
    <div class="container-fluid px-0">
        <a class="navbar-brand font-weight-bolder ms-sm-3" href="{{ route('home') }}"
            rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
            Beauty & Love
        </a>
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0 w-100" id="navigation">
            <ul class="navbar-nav navbar-nav-hover ms-auto">
                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                        Categorias
                    </a>
                    <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3"
                        aria-labelledby="dropdownMenuPages">
                        <div class="d-none d-lg-block">
                            @forelse ($categorias as $categoria)
                                <a href="#" class="dropdown-item border-radius-md">
                                    <span>{{ $categoria->nombre_categoria }}</span>
                                </a>
                            @empty
                            @endforelse
                        </div>

                        <div class="d-lg-none">
                            @forelse ($categorias as $categoria)
                                <a href="#" class="dropdown-item border-radius-md">
                                    <span>{{ $categoria->nombre_categoria }}</span>
                                </a>
                            @empty
                            @endforelse
                        </div>

                    </div>
                </li>
                @auth
                    <li class="nav-item dropdown dropdown-hover mx-2">
                        <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">
                                local_shipping</i>
                            Pedidos
                        </a>
                        <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3"
                            aria-labelledby="dropdownMenuPages">
                            <div class="d-none d-lg-block">
                                <a href="{{ route('carrito.index') }}" class="dropdown-item border-radius-md">
                                    <span>Realizar Pedidos</span>
                                </a>
                                <a href="{{ route('historial.index', Auth()->user()->id) }}"
                                    class="dropdown-item border-radius-md">
                                    <span>Historial de Pedidos</span>
                                </a>
                            </div>

                            <div class="d-lg-none">
                                <a href="{{ route('carrito.index') }}" class="dropdown-item border-radius-md">
                                    <span>Realizar Pedidos</span>
                                </a>
                                <a href="{{ route('historial.index', Auth()->user()->id) }}"
                                    class="dropdown-item border-radius-md">
                                    <span>Historial de Pedidos</span>
                                </a>
                            </div>

                        </div>
                    </li>
                    <li class="nav-item mx-2 d-none d-lg-block">
                        <a href="{{ route('carrito.ver') }}" class="nav-link ps-2 d-flex align-items-center">
                            <i class="material-icons opacity-6 me-2 text-md">shopping_cart</i>
                            Carrito
                        </a>
                    </li>
                    <li class="nav-item mx-2 d-lg-none">
                        <a href="{{ route('carrito.ver') }}" class="nav-link ps-2 d-flex align-items-center">
                            <i class="material-icons opacity-6 me-2 text-md">shopping_cart</i>
                            Carrito
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-hover mx-2">
                        <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">calendar_month</i>
                            Citas
                        </a>
                        <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3"
                            aria-labelledby="dropdownMenuPages">
                            <div class="d-none d-lg-block">
                                <a href="{{ route('clientes.citas.create') }}" class="dropdown-item border-radius-md">
                                    <span>Agendar Cita</span>
                                </a>
                                <a href="{{ route('clientes.citas.index', Auth()->user()->id) }}"
                                    class="dropdown-item border-radius-md">
                                    <span>Historial de Citas</span>
                                </a>
                            </div>

                            <div class="d-lg-none">
                                <a href="{{ route('clientes.citas.create') }}" class="dropdown-item border-radius-md">
                                    <span>Agendar Cita</span>
                                </a>
                                <a href="{{ route('clientes.citas.index', Auth()->user()->id) }}"
                                    class="dropdown-item border-radius-md">
                                    <span>Historial de Citas</span>
                                </a>
                            </div>

                        </div>
                    </li>
                @endauth

                @auth
                    <!-- Mostrar nombre del usuario y opción de cerrar sesión si está logueado -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                            <!-- Muestra el nombre del usuario autenticado -->
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                {{ __('Salir') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <!-- Mostrar enlaces de "Registrarse" e "Iniciar Sesión" si no está logueado -->
                    <li class="nav-item ms-lg-auto">
                        <a class="nav-link nav-link-icon me-2" href="{{ route('register') }}">
                            <i class="fa fa-user me-1"></i>
                            <p class="d-inline text-sm z-index-1 font-weight-bold">Registrate</p>
                        </a>
                    </li>
                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="{{ route('login') }}"
                            class="btn btn-sm bg-gradient-primary mb-0 me-1 mt-2 mt-md-0">Iniciar
                            Sesión</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
