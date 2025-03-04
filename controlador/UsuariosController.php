<?php
session_start();
require "modelo/usuario.php";

class UsuariosController{
    public static function listar(){
        require_once "auth.php"; // Verificación de sesión
        $categoria = new Usuario();
        $datos = $categoria->buscar("1");
        require "vista/admin/usuarios/listado.php";
    }

    public static function editar() {
        // Instancia el modelo de usuario
        $usuarioModel = new Usuario();
    
        // Recibe los datos del formulario
        $usuario_id = $_POST['usuario_id'];
        $nombre_usuario = $_POST['nombre'];
        $email_nuevo = $_POST['email']; // Email del formulario
        $rol = $_POST['rol'];
    
        // Obtener el usuario actual desde la base de datos
        $usuarioActual = $usuarioModel->buscar("usuario_id=" . $usuario_id);
    
        // Comprobar si el usuario existe
        if (empty($usuarioActual)) {
            $_SESSION['msg'] = "¡Usuario no encontrado!";
            header('location:' . urlsite . "?page=usuarios");
            exit();
        }

    
        // Llamar al método de actualización del usuario, independientemente del cambio de email
        $resultado = $usuarioModel->actualizar($usuario_id, $nombre_usuario, $email_nuevo, $rol);
    
        // Comprobar si la actualización fue exitosa
        if ($resultado) {
            $_SESSION['msg'] = "¡Usuario actualizado exitosamente!";
            header('location:' . urlsite . "?page=usuarios");
        } else {
            $_SESSION['msg'] = "¡Error al actualizar el usuario!";
            header('location:' . urlsite . "?page=usuarios&opcion=form_editar");
        }
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    }
    

    
    public static function obtenerUsuariosPorId() {
        if (isset($_POST['usuario_id'])) { // Verifica si el ID está presente
            $usuario_id = $_POST['usuario_id'];
            $usuario = new Usuario();
            $datos = $usuario->buscar("usuario_id = " . $usuario_id); // Corrige la variable
    
            if (!empty($datos)) {
                // Devuelve los datos en formato JSON
                echo json_encode($datos[0]);
            } else {
                echo json_encode(['error' => 'No se encontraron datos']);
            }
        } else {
            echo json_encode(['error' => 'ID de usuario no enviado']);
        }
    }
    
    

    public static function eliminar() {
        $usuario_id = $_REQUEST['usuario_id'];
        $usuarioModel = new Usuario();
        $resultado = $usuarioModel->eliminar($usuario_id);
    
        if ($resultado) {
            $_SESSION['msg'] = "¡Usuario eliminado exitosamente!";
        } else {
            $_SESSION['msg'] = "¡Error al eliminar la Usuario!";
        }
        
        header('location:' . urlsite . "?page=usuarios");
        exit(); // Detener la ejecución del script después de la redirección
    }
    
}