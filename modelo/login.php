<?php
require_once "modelo/conexion.php";

class Login {
    private $_db;

    public function __construct() {
        $this->_db = new Conexion();
    }

    public function login($email) {
        // Conectar a la base de datos
        $this->_db->conectar();
        
        // Preparar la consulta para obtener el usuario basado solo en el email
        $consulta = $this->_db->conexion->prepare("SELECT * FROM usuario WHERE email = :email");
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        
        // Obtener el usuario
        $usuario = $consulta->fetch(PDO::FETCH_OBJ);
        
        // Desconectar de la base de datos
        $this->_db->desconectar();
    
        // Retornar el objeto usuario o false si no existe
        return $usuario ? $usuario : false;
    }
    
}