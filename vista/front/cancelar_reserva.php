<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/SportNex/modelo/conexion.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/SportNex/modelo/reserva.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir si el usuario no está logueado
    exit();
}

if (isset($_POST['reserva_id'])) {
    $reserva_id = (int) $_POST['reserva_id'];
    $usuario_id = $_SESSION['usuario_id'];

    $reservaModel = new ReservaModel();
    $resultado = $reservaModel->cancelarReserva($reserva_id, $usuario_id);

    if ($resultado) {
        $_SESSION['msg'] = "Reserva cancelada exitosamente.";
        header("Location: mis_reservas.php");
        exit();
    } else {
        $_SESSION['msg'] = "No se pudo cancelar la reserva. Intenta nuevamente.";
        header("Location: mis_reservas.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "No se proporcionó un ID de reserva válido.";
    header("Location: mis_reservas.php");
    exit();
}
