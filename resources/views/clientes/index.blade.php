@extends('clientes.template')

@section('contenido')
    <section class="pt-3 pb-4" id="count-stats">
        <div class="container">
            <div class="row">
                <div class="col-md-4 position-relative">
                    <div class="p-3 text-center">
                        <h1 class="text-gradient text-primary">
                            <span id="state1" countTo="{{ count($productos) }}">{{ count($productos) }}</span>+
                        </h1>
                        <h5 class="mt-3">Productos</h5>
                        <p class="text-sm font-weight-normal">Explora nuestra amplia gama de productos de belleza diseñados
                            para satisfacer todas tus necesidades.</p>
                    </div>
                    <hr class="vertical dark">
                </div>
                <div class="col-md-4 position-relative">
                    <div class="p-3 text-center">
                        <h1 class="text-gradient text-primary">
                            <span id="state2" countTo="{{ count($servicios) }}">{{ count($servicios) }}</span>+
                        </h1>
                        <h5 class="mt-3">Servicios</h5>
                        <p class="text-sm font-weight-normal">Ofrecemos una variedad de servicios profesionales para realzar
                            tu belleza y bienestar.</p>
                    </div>
                    <hr class="vertical dark">
                </div>
                <div class="col-md-4 position-relative">
                    <div class="p-3 text-center">
                        <h1 class="text-gradient text-primary">
                            <span id="state3" countTo="{{ count($profesionales) }}">{{ count($profesionales) }}</span>+
                        </h1>
                        <h5 class="mt-3">Profesionales</h5>
                        <p class="text-sm font-weight-normal">Contamos con un equipo de profesionales altamente calificados
                            para atender tus necesidades de belleza.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section class="my-5 py-5">
        <div class="container">
            <!-- Sección de resumen del proyecto -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="text-primary">Resumen del Proyecto</h2>
                    <p>Este proyecto propone el desarrollo de una plataforma web para la gestión integral de clientes,
                        turnos y pedidos de productos para el centro de estética Beauty & Love. La solución busca optimizar
                        las operaciones diarias del spa, mejorando la eficiencia y experiencia del cliente.</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('/imagenes/portada-mariana.jpg') }}" alt="Spa image"
                        class="img-fluid rounded shadow">
                </div>
            </div>

            <!-- Sección de objetivos -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-2">
                    <h2 class="text-primary">Objetivos del Proyecto</h2>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-success"></i> Diseñar y desarrollar una plataforma web
                            para mejorar la gestión de clientes y turnos.</li>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Facilitar el proceso de pedidos de
                            productos a través de un catálogo virtual.</li>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Optimizar la agenda y la disponibilidad de
                            los profesionales del spa.</li>
                    </ul>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <img src="{{ asset('/imagenes/bakerie.png') }}" alt="Objectives image" class="img-fluid rounded shadow">
                </div>
            </div>

            <!-- Sección de gestión de citas -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="text-primary">Gestión de Citas</h2>
                    <p>El sistema permite una programación eficiente de citas, adaptándose a la disponibilidad de los
                        profesionales del spa y asegurando que los recursos se utilicen de manera óptima. Las citas pueden
                        ser programadas, reprogramadas y canceladas fácilmente por los clientes.</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('/imagenes/uñas-portada.jpg') }}" alt="Appointments image"
                        class="img-fluid rounded shadow">
                </div>
            </div>

            <!-- Sección de mapa de ubicación -->
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h2 class="text-primary text-center mb-4">Ubicación de Beauty & Love</h2>
                    <div class="map-container rounded shadow" style="width: 100%; height: 400px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d198565.80538901592!2d-75.76460459948118!3d4.813483305989068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3887429fbb7a97%3A0xeca7a09d37922f3f!2sPereira%2C%20Risaralda%2C%20Colombia!5e0!3m2!1sen!2sco!4v1622644259377!5m2!1sen!2sco"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
