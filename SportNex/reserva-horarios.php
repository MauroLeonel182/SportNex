<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportnex";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $horario = $_POST['horario'];
    
    // Dividir el horario en hora_inicio y hora_fin
    list($hora_inicio, $hora_fin) = explode(" - ", $horario);

    // Suponiendo que tenemos un ID de usuario de sesión (puedes cambiar esto según tu lógica de usuario)
    $usuario_id = 1; // ID de usuario fijo para esta demostración
    
    // Insertar la nueva reserva en la base de datos
    $sql = "INSERT INTO reservas (usuario_id, fecha_reserva, hora_inicio, hora_fin) VALUES ('$usuario_id', '$fecha', '$hora_inicio', '$hora_fin')";

    if ($conn->query($sql) === TRUE) {
        echo "Reserva realizada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
