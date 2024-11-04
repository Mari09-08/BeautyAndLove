<!doctype html>
<html lang="en">

<head>
    @include('back.componentes.head')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#" class="text-nowrap logo-img mt-4">
                        <img src="{{ asset('imagenes/bakerie.png') }}" alt="" height="125" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation ADMIN-->
                @if (Auth()->user()->rol == 1)
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                                <span class="hide-menu">Citas</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('citas.index') }}" aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Agendar</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                                <span class="hide-menu">Pedidos</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.pendientes') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Pendientes</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.entregados') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Entregados</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.carritos') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Carritos</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                                <span class="hide-menu">Productos</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.productos') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Productos</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.categorias') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Categorias</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                                <span class="hide-menu">Profesionales</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.profesionales') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Panel Profesionales</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.servicios') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Servicios</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard.admin.profesiones') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Profesiones</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
                <!-- End Sidebar navigation ADMIN-->
                <!-- Sidebar navigation PROFESIONAL-->
                @if (Auth()->user()->rol == 2)
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                                <span class="hide-menu">Citas</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('profesional.dashboard') }}"
                                    aria-expanded="false">
                                    <span>
                                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6">
                                        </iconify-icon>
                                    </span>
                                    <span class="hide-menu">Agendar</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
                <!-- End Sidebar navigation PROFESIONAL-->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>

                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('imagenes/perfil.png') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>


                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-block">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary mx-3 mt-2"
                                                onclick="clearRedirectFlag()">Salir</button>
                                        </form>


                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                {{-- aqui va todo --}}
                @yield('contenido')
            </div>
        </div>
        @stack('js')
        <script src="{{ asset('back/assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('back/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('back/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('back/assets/libs/simplebar/dist/simplebar.js') }}"></script>
        <script src="{{ asset('back/assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('back/assets/js/app.min.js') }}"></script>
        <script src="{{ asset('back/assets/js/dashboard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @include('sweetalert::alert')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
        @if (Auth::check() && Auth::user()->rol == 2)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Verificar si ya se ha redirigido en esta sesión
                    if (!sessionStorage.getItem('redirected')) {
                        // Redirigir al dashboard de profesional
                        window.location.href = "{{ route('profesional.dashboard') }}";
                        // Marcar como redirigido
                        sessionStorage.setItem('redirected', 'true');
                    }
                });
            </script>
        @else
        @endif
        <script>
            function clearRedirectFlag() {
                // Eliminar la bandera de redireccionamiento al cerrar sesión
                sessionStorage.removeItem('redirected');
            }
        </script>
</body>

</html>
