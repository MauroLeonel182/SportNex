<?php
require_once 'modelo/reserva.php';

if (isset($_POST['fecha'], $_POST['horarios'], $_POST['total'])) {
    $fecha = $_POST['fecha'];
    $horarios = explode(',', $_POST['horarios']);
    $total = $_POST['total'];
    
    // Asegúrate de tener el usuario en sesión
    $usuario_id = $_SESSION['usuario_id']; 

    $reservaModel = new ReservaModel();
    
    foreach ($horarios as $horario) {
        // Asumiendo que el formato de hora es correcto, por ejemplo "13:00"
        list($hora_inicio, $hora_fin) = explode('-', $horario);
        $reservaModel->confirmarReserva($usuario_id, $_POST['cancha_id'], $hora_inicio, $hora_fin);
    }

    // Redirigir a una página de éxito
    header('Location: index.php?page=reservar&status=success');
} else {
    echo 'Datos incompletos.';
}
?>
