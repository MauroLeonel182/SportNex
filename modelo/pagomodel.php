<?php
require_once __DIR__ . '/../modelo/Conexion.php'; // Asegúrate de que la ruta sea correcta
class PagoModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    public function registrarPago($usuario_id, $reserva_id, $total, $metodo_pago, $mp_transaccion_id, $detalle_estado) {
        $stmt = $this->conexion->prepare("
            INSERT INTO pagos (usuario_id, reserva_id, total, metodo_pago, mp_transaccion_id, detalle_estado) 
            VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$usuario_id, $reserva_id, $total, $metodo_pago, $mp_transaccion_id, $detalle_estado]);
    }
    
}