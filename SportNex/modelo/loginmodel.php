<?php
require_once "conexion.php"; // Asegúrate de incluir el archivo de conexión

class Login{
    private $_db;

    public function __construct(){
        $this->_db = new Conexion();
    }

    public function login($email, $contraseña){
        $this->_db->conectar();
        $consulta = $this->_db->conexion->prepare("SELECT * FROM usuario WHERE email=:email AND contraseña=:contrasena");
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':contrasena', $contraseña);
        $consulta->execute();
        $this->_db->desconectar();

        // Comprobamos si hay algún resultado
        if($consulta->fetch(PDO::FETCH_OBJ)){
            return true;
        } else {
            return false;
        }
    }
}
?>
