<?php
// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
    // Redirigir a la página de login
    header("Location: " . urlsite . "?page=login");
    exit();
}
?>
