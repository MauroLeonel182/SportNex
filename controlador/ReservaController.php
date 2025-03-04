<?php
require_once 'modelo/reserva.php';

require_once __DIR__ . '/../modelo/Conexion.php'; // Asegúrate de que la ruta sea correcta

class ReservaController {
    private $db;

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->conectar(); // Conecta y asigna la conexión a la propiedad
    }
    
    public function obtenerDatosFormulario() {
        // Obtener usuarios relacionados con persona
        $stmt = $this->db->query("
            SELECT u.usuario_id, u.nombre_usuario, p.telefono
            FROM usuario u
            JOIN persona p ON u.email = p.email
        ");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener canchas
        $stmt = $this->db->query("SELECT cancha_id, nombre, precio FROM cancha");
        $canchas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['usuarios' => $usuarios, 'canchas' => $canchas];
    }


    // No olvides desconectar después de usar la base de datos si es necesario
    public function __destruct() {
        $conexion = new Conexion();
        $conexion->desconectar();
    }

    public static function mostrarHorarios($fecha) {
        // Crear instancia del modelo
        $reservaModel = new ReservaModel();

        // Obtener los horarios reservados y todos los horarios del día
        $horarios_reservados = $reservaModel->obtenerHorariosReservados($fecha);
        $todos_horarios = $reservaModel->generarHorariosDia();

        // Asegurarse de que los datos se envían a la vista
        include __DIR__ . '/../vista/front/reservaporHorarios.php';
    }
    

    public function mostrarReservasPorFecha($fecha) {
        $reservaModel = new ReservaModel();
        
        // Obtener las reservas del modelo para la fecha proporcionada
        $reservas = $reservaModel->obtenerHorariosReservadosPorFecha($fecha);
        
        // Retornar las reservas para usarlas en la vista
        return $reservas;
    }


}