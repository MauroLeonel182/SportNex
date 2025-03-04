<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportNex</title>
    <!-- Estilos -->
    <link rel="icon" href="/SportNex/public/img/logo.png" type="logo/png">
    <link rel="stylesheet" href="/SportNex/public/css/styles.css">
    <script src="https://kit.fontawesome.com/ed3188a352.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<style>
.profile-dropdown {
    position: relative;
    display: inline-block;
    margin-left: 30px;
}

.profile-pic img {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
}

.profile-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
}

.profile-dropdown-content .profile-name {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
    font-weight: bold;
    background-color: #f1f1f1;
}

.profile-dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.profile-dropdown-content a:hover{
    background-color: #000000;
    color: #fff;
}

.profile-dropdown:hover .profile-dropdown-content {
    display: block;
}



header {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: #fff;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* Asegura que el header esté por encima de otros elementos */
}

header .container {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

header .logo h1 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
}

header .logo {
    display: flex;
    align-items: center;
}

header .logo img {
    width: 50px;
}


header nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
}

header nav ul li {
    margin-left: 20px;
}

header nav ul li a {
    text-decoration: none;
    color: #000;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

header nav ul li a:hover {
    background-color: #000000;
    color: #fff;
}


</style>
<body>
<header>
    <div class="container">
        <div class="logo">
            <img src="/SportNex/public/img/logo.png" alt="logo">
            <h1>SportNex</h1>
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo urlsite ?>?page=user">Inicio</a></li>
                <li><a href="<?php echo urlsite ?>?page=instalaciones">Instalaciones</a></li>
                <li class="profile-dropdown">
                    <div class="profile-pic">
                        <!-- La imagen de perfil siempre visible -->
                        <img src="/SportNex/public/img/user.png" alt="Profile Picture" name="asd">
                    </div>
                    <div class="profile-dropdown-content">
                        <!-- Mostrar el nombre del usuario en el dropdown -->
                        <?php 
                        if (isset($_SESSION['usuario'])) {
                            $usuario = htmlspecialchars($_SESSION['usuario']);
                            echo "<div class='profile-name'>$usuario</div>";
                        } else {
                            echo "<div class='profile-name'>Bienvenido, invitado!</div>";
                        }
                        ?>
                        <a href="vista\front\mis_reservas.php">Mis Reservas</a>
                        <a href="<?php echo urlsite; ?>?page=logout">Salir</a>
                    </div>
                </li>
                    <!-- Botón hamburguesa -->
                    <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </ul>
        </nav>
    </div>
</header>


    <script>
        // JavaScript para manejar el menú desplegable del perfil
        document.querySelector('.profile-pic').addEventListener('click', function() {
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
