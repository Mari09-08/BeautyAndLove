<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beauty & Love ADMIN</title>
<link rel="shortcut icon" type="image/png" href="{{ asset('imagenes/perfil.png') }}" />
<link rel="stylesheet" href="{{ asset('back/assets/css/styles.min.css') }}" />

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<style>
    .img-zoom {
        transition: transform 0.3s ease;
        /* Transición suave */
    }

    .img-zoom:hover {
        transform: scale(1.5);
        /* Aumentar el tamaño de la imagen al 150% */
    }

    .pagination {
        justify-content: center;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        /* Cambiar color del texto */
        border-radius: 50%;
        /* Hacer botones redondeados */
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }
</style>