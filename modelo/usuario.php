<?php

require_once 'conexion.php';

class Usuario {
    private $conexion;
    private $lista = array(); // Declara la propiedad $lista aquí
    public function __construct() {
        $conexionObj = new Conexion();
        $this->conexion = $conexionObj->conectar(); 
        $this->conexions= $conexionObj->desconectar();
    }

    // Método para verificar si el correo ya está registrado
    public function verificarCorreo($email) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Método para verificar si el nombre de usuario ya está registrado
    public function verificarUsuario($nombre_usuario) {
        $query = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Método para registrar una persona
    public function registrarPersona($nombre, $apellido, $email, $dni, $telefono) {
        $query = "INSERT INTO persona (nombre, apellido, email, dni, telefono) VALUES (:nombre, :apellido, :email, :dni, :telefono)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    // Método para registrar un usuario
    public function registrarUsuario($email, $nombre_usuario, $password_hash, $rol) {
        $query = "INSERT INTO usuario (email, nombre_usuario, contrasena, rol, fecha_registro) VALUES (:email, :nombre_usuario, :contrasena, :rol, current_timestamp())";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':contrasena', $password_hash);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }

    public function buscar($condicion) {
        $this->conexion;
        $consulta = $this->conexion->prepare("SELECT * FROM usuario WHERE " . $condicion);
        $consulta->execute();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)){
            $this->lista[] = $row;
        }
        $this->conexions;
        return $this->lista;
    }

    // Método para eliminar un usuario y su persona asociada
    public function eliminar($usuario_id) {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();
    
            // Obtener el email asociado al usuario
            $queryEmail = "SELECT email FROM usuario WHERE usuario_id = :usuario_id";
            $stmtEmail = $this->conexion->prepare($queryEmail);
            $stmtEmail->bindParam(':usuario_id', $usuario_id);
            $stmtEmail->execute();
            $usuario = $stmtEmail->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                $email = $usuario['email'];
                echo "Email: " . $email; // Debug
    
                // Eliminar usuario
                $queryUsuario = "DELETE FROM usuario WHERE usuario_id = :usuario_id";
                $stmtUsuario = $this->conexion->prepare($queryUsuario);
                $stmtUsuario->bindParam(':usuario_id', $usuario_id);
                $stmtUsuario->execute();
                echo "Usuario eliminado"; // Debug
    
                // Eliminar persona asociada al email
                $queryEliminarPersona = "DELETE FROM persona WHERE email = :email";
                $stmtEliminarPersona = $this->conexion->prepare($queryEliminarPersona);
                $stmtEliminarPersona->bindParam(':email', $email);
                $stmtEliminarPersona->execute();
                echo "Persona eliminada"; // Debug
            }
    
            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollBack();
            echo "Error: " . $e->getMessage(); // Debug
            return false;
        }
    }


    public function actualizar($usuario_id, $nombre_usuario, $email, $rol) {
        $query = "UPDATE usuario SET nombre_usuario = :nombre_usuario, email = :email, rol = :rol WHERE usuario_id = :usuario_id";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    
    
}
?>
