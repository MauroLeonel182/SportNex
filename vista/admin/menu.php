<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportNex</title>
    <link rel="icon" href="public/img/logo.png" type="logo/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        margin: 0;
        padding: 0;
    }

    /* Estilo para la barra lateral */
    .sidebar {
        width: 280px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #121212;
        color: #fff;
        padding-top: 20px;
        transition: transform 0.3s ease;
        overflow-y: auto;
        /* Añade esta propiedad para la barra de desplazamiento */
        scrollbar-width: thin;
        /* Opcional: ajusta el grosor de la barra en Firefox */
    }

    /* Opcional: estiliza la barra de desplazamiento en navegadores WebKit (Chrome, Safari) */
    .sidebar::-webkit-scrollbar {
        width: 8px;
        /* Grosor de la barra de desplazamiento */
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: #B80C09;
        /* Color de la barra de desplazamiento */
        border-radius: 10px;
        /* Bordes redondeados */
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background-color: #ff5733;
        /* Cambia el color cuando el usuario la está usando */
    }

    .sidebar h2 {
        color: #B80C09;
        /* Color rojo para el título */
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .sidebar a {
        padding: 15px 20px;
        text-decoration: none;
        color: #b8b8b8;
        /* Color gris para los enlaces */
        display: block;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #B80C09;
        /* Color rojo en hover */
        color: #fff;
        /* Texto blanco */
    }

    .sidebar .section-title {
        padding: 10px 20px;
        color: #B80C09;
        /* Color rojo para los títulos de secciones */
        text-transform: uppercase;
        font-size: 12px;
        margin-top: 20px;
        font-weight: bold;
    }

    /* Estilo para el contenido */
    .content {
        margin-left: 240px;
        padding: 20px;
        transition: margin-left 0.3s ease;
        background-color: #181818;
        /* Fondo oscuro para el contenido */
        color: #fff;
        /* Texto blanco */
    }

    /* Estilo para la barra superior */
    .navbar {
        /* Fondo oscuro */
        color: #fff;
        /* Texto blanco */
        padding: 10px 20px;
        margin: 0;
        /* Asegúrate de que no haya margen */
        position: relative;
        top: 0;
        left: 0;
        width: 100%;
    }


    .navbar h1 {
        font-size: 24px;
        font-weight: bold;
        margin-left: 15px;
        
    }

    .profile-pic {
        cursor: pointer;
        position: relative;
    }

    .profile-pic img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        border: 2px solid #B80C09;
        /* Bordes rojos */
    }

    .profile-dropdown-content {
        display: none;
        position: absolute;
        top: 60px;
        right: 0;
        background-color: #121212;
        /* Fondo oscuro */
        border: 1px solid #B80C09;
        /* Bordes rojos */
        min-width: 150px;
        z-index: 1;
        text-align: left;
    }

    .profile-dropdown-content a {
        color: #fff;
        padding: 10px;
        text-decoration: none;
        display: block;
        font-weight: bold;
    }

    .profile-dropdown-content a:hover {
        background-color: #B80C09;
        /* Rojo en hover */
    }

    /* Ocultar dropdown si haces click afuera */
    .profile-pic img:focus+.profile-dropdown-content,
    .profile-dropdown-content:focus-within {
        display: block;
    }


    /* Efectos responsivos */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            transform: translateX(-100%);
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .content {
            margin-left: 0;
        }
    }

    /* Estilo del botón de toggle */
    .toggle-btn {
        display: inline-block;
        padding: 10px 20px;
        color: red;
        cursor: pointer;
        font-size: 18px;
        position: fixed;
        /* Fijo en la parte superior izquierda */
        top: 20px;
        left: 10px;
        z-index: 10000;
        /* Para que esté siempre encima */
    }

    .sidebar h2 {
        color: #B80C09;
        /* Color rojo para el título */
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        position: relative;
        /* Relativo para que el botón se posicione respecto a este */
        padding-left: 60px;
        /* Añade espacio para el botón de toggle */
    }


    .sidebar.hidden {
        transform: translateX(-100%);
    }


    .content.sidebar-hidden {
        margin-left: 60px;
        /* Ajusta el margen cuando el menú esté oculto */
        margin-right: 180px;
        /* Desplaza a la derecha para no superponerse al botón */
    }
    </style>
</head>

<body>
    <!-- Botón de toggle visible siempre -->
    <div class="toggle-btn" id="toggle-menu-btn" onclick="toggleSidebar()">☰</div>
    <div class="sidebar" id="sidebar">
        <h2>SportNex</h2>
        <div class="section-title">Dashboard</div>
        <a href="<?php echo urlsite; ?>?page=admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <div class="section-title">Main</div>
        <a href="<?php echo urlsite; ?>?page=vista"><i class="fas fa-futbol"></i> Alquiler de Canchas</a>
        <div class="section-title">Reportes</div>
        <a href="<?php echo urlsite; ?>?page=diario"><i class="fas fa-file-alt"></i> Alquileres diarios</a>
        <div class="section-title">Master List</div>
        <a href="<?php echo urlsite; ?>?page=cancha"><i class="fas fa-list"></i> Lista de Canchas</a>
        <a href="<?php echo urlsite; ?>?page=deportes"><i class="fas fa-list"></i> Lista de Deportes</a>
        <div class="section-title">Mantenimiento</div>
        <a href="<?php echo urlsite;?>?page=usuarios"><i class="fas fa-users"></i> Lista de Usuarios</a>
        <a href="#configuraciones"><i class="fas fa-cog"></i> Configuraciones</a>
    </div>


    <!-- Content -->
    <div class="content" id="content">
        <!-- Encabezado -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <h1>Sistema de Alquiler de Canchas</h1>
            <div class="ml-auto">
                <div class="profile-dropdown">
                    <div class="profile-pic">
                        <img src="public\img\asd.png" alt="Profile Picture">
                    </div>
                    <div class="profile-dropdown-content">
                        <a href="<?php echo urlsite; ?>?page=logout">Salir</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <script>
    // Función para ocultar/mostrar el sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const contentArea = document.getElementById('content-area'); // Obtener el contenedor de la tabla

        sidebar.classList.toggle('hidden');
        content.classList.toggle('sidebar-hidden');
        contentArea.classList.toggle('sidebar-hidden'); // Alternar la clase para la tabla
    }



    // JavaScript para manejar el menú desplegable del perfil
    // JavaScript para manejar el menú desplegable del perfil
    document.querySelector('.profile-pic').addEventListener('click', function(event) {
        event.stopPropagation(); // Evita que el click cierre el dropdown inmediatamente
        const dropdown = document.querySelector('.profile-dropdown-content');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.profile-dropdown-content');
        const profilePic = document.querySelector('.profile-pic img');
        if (!profilePic.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
    </script>
    <!-- jQuery and Bootstrap 4.5.2 JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>