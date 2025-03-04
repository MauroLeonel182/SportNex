<?php
require_once __DIR__ . '/../modelo/conexion.php'; // Asegúrate de que la ruta sea correcta
class ReservaModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }


    public  function obtenerHorariosPorCancha($cancha_id, $fecha) {
        // Obtener todos los horarios disponibles para una cancha en una fecha específica
        $sql = "SELECT hora_inicio, hora_fin FROM horarios WHERE cancha_id = :cancha_id AND fecha = :fecha";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cancha_id', $cancha_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener horarios reservados
    public function obtenerHorariosReservados($cancha_id, $fecha) {
        $sql = "SELECT hora_inicio, hora_fin, estado FROM reservas WHERE cancha_id = ? AND fecha_reserva = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(1, $cancha_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Esto debería incluir 'estado' en cada fila
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
    
    public function confirmarReserva($usuario_id, $cancha_id, $hora_inicio, $hora_fin) {
        // Asegurarse de que las horas estén en formato correcto
        if (strpos($hora_inicio, ':') !== false && substr_count($hora_inicio, ':') == 1) {
            $hora_inicio .= ':00';
        }
        if (strpos($hora_fin, ':') !== false && substr_count($hora_fin, ':') == 1) {
            $hora_fin .= ':00';
        }
    
        $fecha_reserva = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
        
        $sql = "INSERT INTO reservas (usuario_id, cancha_id, fecha_reserva, hora_inicio, hora_fin, estado) 
                VALUES (?, ?, ?, ?, ?, 'PENDIENTE')";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $cancha_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $fecha_reserva, PDO::PARAM_STR);
        $stmt->bindParam(4, $hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(5, $hora_fin, PDO::PARAM_STR);
    
        // Ejecutamos la inserción
        $stmt->execute();
    
        // Retornamos el ID de la última reserva insertada
        return $this->conexion->lastInsertId();
    }
    

    // Método para obtener las reservas de un usuario
    public function getReservasByUsuario($usuario_id) {
        $sql = "SELECT r.reserva_id, r.fecha_reserva, r.hora_inicio, r.hora_fin, r.estado, c.nombre AS nombre_cancha
                FROM reservas r
                JOIN cancha c ON r.cancha_id = c.cancha_id
                WHERE r.usuario_id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function cancelarReserva($reserva_id, $usuario_id) {
        // Cambiar el estado de la reserva a 'CANCELADA'
        $sql = "UPDATE reservas SET estado = 'CANCELADA' WHERE reserva_id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(1, $reserva_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $usuario_id, PDO::PARAM_INT);
        
        $resultado = $stmt->execute();
        
        if ($resultado) {
            // Al cancelar la reserva, la cancha se marca como disponible nuevamente
            return true;
        }
        return false;
    }
    
    
    
}

?>