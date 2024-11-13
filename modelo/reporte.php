<?php
require_once 'conexion.php';

class Reporte extends Conexion {

    // Obtener las ganancias totales
    public function obtenerGananciasTotales() {
        $sql = "SELECT SUM(monto) as total FROM pagos";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultado['total'];
    }

    // Obtener el número total de usuarios registrados
    public function obtenerUsuariosRegistrados() {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultado['total'];
    }

    // Obtener las horas reservadas (ejemplo: conteo total de reservas)
    public function obtenerHorasAlquiladas() {
        $sql = "SELECT COUNT(*) as total FROM reservas";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultado['total'];
    }

    // Obtener los clientes frecuentes (usuarios con más reservas)
    public function obtenerClientesFrecuentes() {
        $sql = "SELECT u.nombre_usuario, u.email, COUNT(r.reserva_id) as reservas
                FROM usuario u
                JOIN reservas r ON u.usuario_id = r.usuario_id
                GROUP BY u.usuario_id
                ORDER BY reservas DESC
                LIMIT 5";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultados;
    }

    // Función para obtener las horas más alquiladas por día de la semana
    public function obtenerHorasPorDia() {
        $sql = "SELECT DAYNAME(fecha_reserva) AS dia, COUNT(*) AS total
                FROM reservas
                GROUP BY dia
                ORDER BY FIELD(dia, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->desconectar();
        
        // Creamos un array con los días de la semana en el orden correcto
        $diasSemana = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
        
        // Actualizamos el array con los datos obtenidos de la consulta
        foreach ($resultados as $resultado) {
            $diasSemana[$resultado['dia']] = (int)$resultado['total'];
        }
        
        return array_values($diasSemana); // Devolvemos solo los valores para pasarlos al gráfico
    }
        // Función para obtener las ganancias diarias
        public function obtenerGananciasPorDia() {
            $sql = "SELECT DATE(fecha_pago) AS fecha, SUM(monto) AS total
                    FROM pagos
                    GROUP BY DATE(fecha_pago)
                    ORDER BY fecha ASC
                    LIMIT 7";  // Limitamos a los últimos 7 días como ejemplo
            $stmt = $this->conectar()->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->desconectar();
    
            // Creamos dos arrays para etiquetas y datos
            $fechas = [];
            $ganancias = [];
            foreach ($resultados as $resultado) {
                $fechas[] = $resultado['fecha'];
                $ganancias[] = (int)$resultado['total'];
            }
            
            return ['fechas' => $fechas, 'ganancias' => $ganancias];
        }
        // Obtener las reservas canceladas y los usuarios que las cancelaron
    public function obtenerReservasCanceladas() {
        $sql = "SELECT u.nombre_usuario, u.email, r.fecha_reserva, r.estado
                FROM reservas r
                JOIN usuario u ON r.usuario_id = u.usuario_id
                WHERE r.estado = 'CANCELADA'";  // Asumiendo que 'cancelada' es el estado que marca una reserva cancelada
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultados;
    }
}
