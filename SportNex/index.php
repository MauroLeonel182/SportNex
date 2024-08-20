<?php
require "config.php";
$page ="index"; // Página predeterminada
if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

switch ($page) {
    case 'login':
        require "controlador/LoginController.php";
        LoginController::index();
        break;

    case 'loginout':
        require "controlador/LoginController.php";
        LoginController::login();
        break;

    case 'logout': 
        require "controlador/LoginController.php";
        LoginController::logout();
        break;

    case 'admin':
        require "controlador/AdminController.php";
        AdminController::index();
        break;

    case 'horarios':
        require "controlador/ReservaController.php";
        ReservaController::mostrarHorarios($fecha);
        break;

    case 'cancha':
            require "controlador/CanchasController.php";
            $controller = new CanchasController();
            if (isset($_GET['opcion'])) {
                $metodo = $_GET['opcion'];
                if (method_exists($controller, $metodo)) {
                    $controller->{$metodo}();
                }
                } else {
                    $controller->listar();
                }
    break;

    default:
        require "controlador/FrontController.php";
        FrontController::index();
        break;
}

