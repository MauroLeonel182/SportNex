<?php
require_once 'modelo/usuario.php';

class RegistroController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function registrar() {
        $resultado = ['mensaje' => '', 'type' => '']; // Array para almacenar el mensaje y tipo

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
            $nombre_usuario = $_POST['nombre_usuario'];
            $contrasena = $_POST['contrasena'];
            $rol = $_POST['rol'];

            // Hash seguro de la contraseña usando password_hash
            $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            // Verificar que el correo no esté registrado
            if ($this->usuarioModel->verificarCorreo($email)) {
                $resultado['mensaje'] = 'Este correo ya está registrado, intenta con otro.';
                $resultado['type'] = 'error';
            } 
            // Verificar que el nombre de usuario no esté registrado
            elseif ($this->usuarioModel->verificarUsuario($nombre_usuario)) {
                $resultado['mensaje'] = 'Este nombre de usuario ya está registrado, intenta con otro.';
                $resultado['type'] = 'error';
            } 
            // Registrar persona y usuario
            else {
                if ($this->usuarioModel->registrarPersona($nombre, $apellido, $email, $dni, $telefono)) {
                    if ($this->usuarioModel->registrarUsuario($email, $nombre_usuario, $password_hash, $rol)) {
                        $resultado['mensaje'] = 'Registro exitoso. ¡Ahora puedes iniciar sesión!';
                        $resultado['type'] = 'success';
                        $_POST = array(); // Limpiar $_POST para vaciar los campos del formulario
                    } else {
                        $resultado['mensaje'] = 'Hubo un error en el registro, por favor intenta nuevamente.';
                        $resultado['type'] = 'error';
                    }
                } else {
                    $resultado['mensaje'] = 'Hubo un error al registrar la persona, intenta nuevamente.';
                    $resultado['type'] = 'error';
                }
            }
        }

        // Retornar el resultado para mostrar en la vista
        return $resultado;
    }
}