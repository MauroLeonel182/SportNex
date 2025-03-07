<?php
require_once "modelo/conexion.php";

class Cancha {
    private $_db;
    private $lista = array(); // Declara la propiedad $lista aquí

    public function __construct() {
        $this->_db = new Conexion();
    }

    public function buscar($condicion) {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->prepare("SELECT * FROM cancha WHERE " . $condicion);
        $consulta->execute();
        while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            $this->lista[] = $row;
        }
        $this->_db->desconectar();
        return $this->lista;
    }
    public function buscar2($cancha_id) {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->prepare("SELECT * FROM cancha WHERE cancha_id = ?");
        $consulta->bindParam(1, $cancha_id, PDO::PARAM_INT);
        $consulta->execute();
        $cancha = $consulta->fetch(PDO::FETCH_OBJ);
        $this->_db->desconectar();
        return $cancha; // Devuelve solo un objeto
    }
    

    public function insertar($data) {
        $this->_db->conectar();
        $consulta = $this->_db->conexion->query("INSERT INTO cancha (nombre, precio, urlfoto, tipo_deporte_id, disponibilidad) VALUES ($data)");
        $this->_db->desconectar();
        return $consulta ? true : false;
    }

    public function actualizar($data, $condicion) {
        $this->_db->conectar();
        $sql = "UPDATE cancha SET $data WHERE $condicion";
        $consulta = $this->_db->conexion->query($sql);
        $this->_db->desconectar();
        return $consulta ? true : false;
    }
    
    public function eliminar($condicion) {
        try {
            $this->_db->conectar();
            // Intentamos ejecutar la consulta DELETE
            $consulta = $this->_db->conexion->query("DELETE FROM cancha WHERE " . $condicion);
            $this->_db->desconectar();
            
            return $consulta ? true : false;
        } catch (PDOException $e) {
            // Si ocurre un error (como la violación de la restricción de clave foránea), lo capturamos
            return false;
        }
    }
    

    public function obtenerCanchas() {
        $this->_db->conectar();
        $sql = "SELECT cancha_id, nombre, urlfoto, precio FROM cancha";
        $consulta = $this->_db->conexion->query($sql);
        $canchas = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->_db->desconectar();
        return $canchas;
    }

    public function obtenerHorariosReservados($cancha_id) {
        $this->_db->conectar();
        $sql = "SELECT hora_inicio, hora_fin FROM reservas WHERE cancha_id = ? AND estado = 'PENDIENTE' AND fecha_reserva = CURDATE()";
        $stmt = $this->_db->conexion->prepare($sql);
        $stmt->bindParam(1, $cancha_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_db->desconectar();
        return $resultados;
    }
        // Método para obtener el precio por hora de una cancha
        public function obtenerPrecioPorHora($cancha_id) {
            $this->_db->conectar();
            $sql = "SELECT precio FROM cancha WHERE cancha_id = :cancha_id";
            $stmt = $this->_db->conexion->prepare($sql);
            $stmt->bindParam(':cancha_id', $cancha_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['precio'] ?? 0; // Retorna el precio o 0 si no lo encuentra
            $this->_db->desconectar();
        }


}