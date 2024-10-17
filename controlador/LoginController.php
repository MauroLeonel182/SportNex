<?php
session_start();
require_once 'modelo/login.php';

class LoginController {
    public static function index() {
        // Si el usuario ya ha iniciado sesión
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['rol'] == 'administrador') {
                header('Location: ' . urlsite . '?page=admin');
            } elseif ($_SESSION['rol'] == 'cliente') {
                header('Location: ' . urlsite . '?page=user');
            }
        }

        // Mostrar el formulario de login
        require "vista/front/formlogin.php";
    }

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['contrasena'];  // No se hashea aquí directamente

            $loginModel = new Login();
            $usuario = $loginModel->login($email);  // Recupera el usuario por email

            if ($usuario && password_verify($password, $usuario->contrasena)) {  // Verificar la contraseña con password_verify
                // Guardar los datos en la sesión
                $_SESSION['usuario'] = $usuario->email;
                $_SESSION['rol'] = $usuario->rol;

                // Redirección basada en el rol
                if ($usuario->rol == 'administrador') {
                    header('Location: ' . urlsite . '?page=admin');
                } elseif ($usuario->rol == 'cliente') {
                    header('Location: ' . urlsite . '?page=user');
                }
            } else {
                header('Location: ' . urlsite . '?page=login&msg=error');
            }
        }
    }

    public static function logout() {
        // Cerrar sesión
        session_destroy();
        header('Location: ' . urlsite);
    }
}
?>