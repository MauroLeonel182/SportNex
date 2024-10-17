<?php
require "modelo/cancha.php";
require "modelo/reserva.php";

class FrontController {

    public static function index() {
        require "vista/front/main.php";
    }

    public static function user() {
        // Iniciar la sesión si aún no ha sido iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario está logueado y su rol
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] === 'cliente') {
            require "vista/front/mainuser.php";
        } else {
            // Redirigir al usuario a la página de login si no está logueado
            // o mostrar un mensaje de error o redirigir a otra vista.
            header('Location: ' . urlsite . '?page=login');
            exit();
        }
    }
}
?>
