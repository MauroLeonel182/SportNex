<?php
require_once __DIR__ . '/../modelo/Conexion.php'; // Asegúrate de que la ruta sea correcta
class ReservaModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function confirmarReserva($usuario_id, $cancha_id, $hora_inicio, $hora_fin) {
        $this->_db->conectar();
        $sql = "INSERT INTO reservas (usuario_id, cancha_id, fecha_reserva, hora_inicio, hora_fin, estado) 
                VALUES (?, ?, CURDATE(), ?, ?, 'confirmada')";
        $stmt = $this->_db->conexion->prepare($sql);
        $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $cancha_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(4, $hora_fin, PDO::PARAM_STR);
        $resultado = $stmt->execute();
        $this->_db->desconectar();
        return $resultado;
    }
    

    public static function obtenerHorariosPorCancha($cancha_id, $fecha) {
        // Obtener todos los horarios disponibles para una cancha en una fecha específica
        $sql = "SELECT hora_inicio, hora_fin FROM horarios WHERE cancha_id = :cancha_id AND fecha = :fecha";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cancha_id', $cancha_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerHorariosReservados($cancha_id, $fecha) {
        // Obtener horarios que ya están reservados
        $sql = "SELECT hora_inicio, hora_fin FROM reservas WHERE cancha_id = :cancha_id AND fecha_reserva = :fecha";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cancha_id', $cancha_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerHorariosReservadosPorFecha($fecha) {
        $query = "SELECT r.reserva_id, r.hora_inicio, r.hora_fin, r.estado, c.nombre AS cancha, p.nombre AS cliente
                  FROM reservas r
                  JOIN cancha c ON r.cancha_id = c.cancha_id
                  JOIN usuario u ON r.usuario_id = u.usuario_id
                  JOIN persona p ON u.email = p.email
                  WHERE r.fecha_reserva = :fecha";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerReservaPorId($id) {
        // Lógica para consultar la base de datos
        $sql = "SELECT hora_fin, estado FROM reservas WHERE reserva_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}

?>