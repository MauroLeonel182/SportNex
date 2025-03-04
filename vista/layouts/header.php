<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportNex</title>
    <!-- Estilos -->
    <link rel="icon" href="public/img/logo.png" type="logo/png">
    <link rel="stylesheet" href="/SportNex/public/css/styles.css">
    <script src="https://kit.fontawesome.com/ed3188a352.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <header>
        <div class="contenido">
            <div class="logo">
                <img src="public/img/logo.png" alt="logo">
                <h1>SportNex</h1>
            </div>
            <nav>
                <ul class="menu">
                    <li><a href="<?php echo urlsite ?>">Inicio</a></li>
                    <li><a href="<?php echo urlsite ?>?page=instalaciones">Instalaciones</a></li>
                    <li><a href="<?php echo urlsite ?>?page=login">Iniciar Sesion</a></li>
                </ul>
                <!-- Botón hamburguesa -->
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>


            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const menuToggle = document.getElementById('menu-toggle');
                const menu = document.querySelector('nav ul');

                menuToggle.addEventListener('click', function() {
                    menu.classList.toggle('active');
                });
            });
            </script>

    </header>