<?php
require "config.php";
$page ="index"; // Página predeterminada
if(isset($_GET['page'])) 
    $page = $_GET['page'];

switch ($page) {
    case 'recuperar_password':
        require "controlador/recuperar_password.php"; // Asegúrate de incluir la clase
        $resultado = RecuperarPasswordController::index(); // Llama al método estático
        require "vista/front/formlogin.php"; // Carga la vista del formulario de login
        break;
        
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

    case 'instalaciones':
        require 'controlador/CanchasController.php';
        CanchasController::mostrarCanchas();
        break;
    
    case 'horarios':
        require 'controlador/CanchasController.php';
        $controller = new CanchasController(); // Crear una instancia del controlador
        if (isset($_GET['cancha_id'])) {
            $controller->mostrarHorarios($_GET['cancha_id']); // Llamar al método desde la instancia
        } else {
            echo 'Cancha no seleccionada';
        }
        break;    

    case 'reservar':
        require_once 'controlador/CanchasController.php';
        CanchasController::confirmarReserva();
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
    case 'register':
        require_once 'controlador/RegistroController.php';
        $registroController = new RegistroController();
        $resultado = $registroController->registrar();
        require_once 'vista/front/formlogin.php'; // Asegúrate de que esta vista reciba $resultado
        break;    
    case 'deportes':
        require "controlador/TipoDeporteController.php";
        $controller = new TipoDeporteController();
        if (isset($_GET['opcion'])) {
            $metodo = $_GET['opcion'];
            if (method_exists($controller, $metodo)) {
                $controller->{$metodo}();
            }
            } else {
                $controller->listar();
            }
    break;
    case 'usuarios':
        require "controlador/UsuariosController.php";
        $controller = new UsuariosController();
        if (isset($_GET['opcion'])) {
            $metodo = $_GET['opcion'];
            if (method_exists($controller, $metodo)) {
                $controller->{$metodo}();
            }
            } else {
                $controller->listar();
            }
    break;
    case 'vista':
        require "controlador/AdminController.php";
        AdminController::vista();
        break;
    case 'diario':
        require "controlador/AdminController.php";
        AdminController::diario();
        break;
    case 'user':
        require_once "controlador/FrontController.php";
        FrontController::user();
        break;
    default:
        require "controlador/FrontController.php";
        FrontController::index();
        break;
}