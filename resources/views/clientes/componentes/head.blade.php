<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('imagenes/perfil.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('imagenes/perfil.png') }}" />


<title>
    Beauty & Love
</title>
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

<!-- Nucleo Icons -->
<link href="{{ asset('front/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('front/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<!-- CSS Files -->



<link id="pagestyle" href="{{ asset('front/assets/css/material-kit.css?v=3.0.4') }}" rel="stylesheet" />





<!-- Nepcha Analytics (nepcha.com) -->
<!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
<script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Botón de abrir la modal */
    .open-modal-btn {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Estilos para la modal */
    .modal {
        display: block;
        /* Cambiar a block para que se muestre */
        position: fixed;
        z-index: 1050;
        /* Aumenta el z-index para estar por encima de otros elementos */
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
        /* Cobertura completa de la pantalla */
        background-color: rgba(0, 0, 0, 0.6);
        /* Fondo gris semitransparente */
        display: flex;
        align-items: center;
        justify-content: center;
        /* Centrar la modal */
    }


    /* Contenido de la modal */
    .modal-content {
        background-color: white;
        margin: 15% auto;
        /* Ajuste central */
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Efecto de animación para que la modal aparezca suavemente */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Botón de cierre */
    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
    }

    /* Botón de confirmación */
    .confirm-btn {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
    }

    .confirm-btn:hover {
        background-color: #c82333;
    }

    /* Responsivo */
    @media (max-width: 600px) {
        .modal-content {
            width: 95%;
            padding: 15px;
        }
    }
</style> --}}