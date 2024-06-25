<?php
class Conexion {
    public $conexion;

    public function conectar() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $opciones = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $this->conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones);
            return $this->conexion;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function desconectar() {
        $this->conexion = null;
    }
}
?>
