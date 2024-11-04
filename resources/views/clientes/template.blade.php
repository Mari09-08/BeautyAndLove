<!DOCTYPE html>
<html lang="en">

<head>
    @include('clientes.componentes.head')
</head>

<body class="index-page bg-gray-200">
    <!-- Navbar -->
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('clientes.componentes.menu')
            </div>
        </div>
    </div>

    <header class="header-2">
        <div class="page-header min-vh-75 relative" style="background-image: url('{{ asset('imagenes/fondo.png') }}')">
            <span class="mask bg-gradient-primary opacity-1"></span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 text-center mx-auto mt-5">
                        <h1 class="pt-3 mt-n5">Beauty & Love</h1>
                        <p class="lead mt-3"> Es una plataforma web diseñada para optimizar la gestión de
                            clientes, turnos y pedidos en el centro de estética. Esta herramienta permite a los usuarios
                            agendar citas,
                            visualizar la disponibilidad de los profesionales y realizar pedidos de productos en línea,
                            mejorando la eficiencia operativa y la experiencia del cliente.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    {{-- blur shadow-blur mx-3 mx-md-4 mt-n6 --}}
    <div class="card card-body">

        @yield('contenido')

    </div>

    @stack('js')
    {{-- aquí va el footer --}}
    <footer class="bg-muted text-white pt-5 pb-4">
        <div class="container text-md-left">
            <div class="row text-md-left">
                <!-- Logo y Descripción -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Beauty & Love</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto bg-primary" style="width: 60px;" />
                    <p>Beauty & Love es un centro de estética especializado en ofrecer servicios personalizados para
                        resaltar tu belleza y bienestar.</p>
                </div>

                <!-- Links de Navegación -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Links</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto bg-primary" style="width: 60px;" />
                    <p><a href="{{ route('home') }}" class="text-white" style="text-decoration: none;">Inicio</a></p>
                    <p><a href="{{ route('login') }}" class="text-white" style="text-decoration: none;">Iniciar
                            Sesion</a></p>
                    <p><a href="{{ route('register') }}" class="text-white"
                            style="text-decoration: none;">Registrase</a></p>
                </div>

                <!-- Sección de contacto -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Contacto</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto bg-primary" style="width: 60px;" />
                    <p><i class="bi bi-house-door-fill me-2"></i>Pereira, Colombia</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>info@beautyandlove.com</p>
                    <p><i class="bi bi-phone-fill me-2"></i>+57 123 456 7890</p>
                    <p><i class="bi bi-whatsapp me-2"></i>+57 987 654 3210</p>
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase font-weight-bold">Síguenos</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto bg-primary" style="width: 60px;" />
                    <div>
                        <a href="#" class="text-white me-4"><i class="fa fa-facebook text-white text-lg"></i></a>
                        <a href="https://www.instagram.com/nails_beautyandlove/" class="text-white me-4"><i class="fa fa-instagram text-white text-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="bg-primary footer-copyright text-center py-3">
            <p class="m-0">© 2024 Beauty & Love | Todos los derechos reservados.</p>
        </div>
    </footer>

    <style>
        footer {
            background-color: #343a40;
        }

        footer p,
        footer h6 {
            color: #f1f1f1;
        }

        footer a {
            text-decoration: none;
            color: #f1f1f1;
        }

        footer a:hover {
            color: #f8b400;
            text-decoration: underline;
        }

        footer .bi {
            font-size: 1.5rem;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            footer .row {
                text-align: center;
            }

            footer .col-md-3,
            footer .col-md-2,
            footer .col-md-4 {
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <!--   Core JS Files   -->
    <script src="{{ asset('front/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>




    <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="{{ asset('front/assets/js/plugins/countup.min.js') }}"></script>





    <script src="{{ asset('front/assets/js/plugins/choices.min.js') }}"></script>



    <script src="{{ asset('front/assets/js/plugins/prism.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/highlight.min.js') }}"></script>



    <!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
    <script src="{{ asset('front/assets/js/plugins/rellax.min.js') }}"></script>
    <!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
    <script src="{{ asset('front/assets/js/plugins/tilt.min.js') }}"></script>
    <!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
    <script src="{{ asset('front/assets/js/plugins/choices.min.js') }}"></script>

    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="{{ asset('front/assets/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>

    @include('sweetalert::alert')
</body>

</html>
