<?php
require_once "conexion.php";

class TipoDeporte{
    private $_db;
    private $lista = array(); // Declara la propiedad $lista aquí
    public function __construct() {
        $this->_db = new Conexion();
    }

    public function listar() {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->prepare("SELECT * FROM tipo_deporte");
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_OBJ);
        $this->_db->desconectar();
        return $result;
    }

    public function buscar($condicion) {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->prepare("SELECT * FROM tipo_deporte WHERE " . $condicion);
        $consulta->execute();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)){
            $this->lista[] = $row;
        }
        $this->_db->desconectar();
        return $this->lista;
    }

    public function insertar($data) {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->query("INSERT INTO tipo_deporte (nombre) VALUES ($data)");
        $this->_db->desconectar();
        return $consulta ? true : false;
    }    

    public function actualizar($data, $condicion){
        $this->_db->conectar();
        $sql = "UPDATE tipo_deporte SET $data WHERE $condicion";
        $consulta = $this->_db->conexion->query($sql);
        $this->_db->desconectar();
        return $consulta ? true : false;
    }
    
    public function eliminar($condicion) {
        try {
            $this->_db->conectar();
            // Intentamos ejecutar la consulta DELETE
            $consulta = $this->_db->conexion->query("DELETE FROM tipo_deporte WHERE " . $condicion);
            $this->_db->desconectar();
            
            return $consulta ? true : false;
        } catch (PDOException $e) {
            // Si ocurre un error (como la violación de la restricción de clave foránea), lo capturamos
            return false;
        }
    }

}
