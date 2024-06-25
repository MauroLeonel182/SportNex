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

function generar_horarios_dia() {
    $horarios = array();
    for ($i = 0; $i < 24; $i++) {
        $hora_inicio = str_pad($i, 2, '0', STR_PAD_LEFT) . ":00";
        $hora_fin = str_pad($i, 2, '0', STR_PAD_LEFT) . ":59";
        $horarios[] = "$hora_inicio - $hora_fin";
    }
    return $horarios;
}

if (isset($_GET['fecha'])) {
    $fechaSeleccionada = $_GET['fecha'];
    
    // Consulta SQL para obtener los horarios reservados para la fecha seleccionada
    $sql = "SELECT hora_inicio, hora_fin FROM reservas WHERE fecha_reserva = '$fechaSeleccionada'";
    $result = $conn->query($sql);

    // Array para almacenar los horarios reservados
    $horarios_reservados = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $horarios_reservados[] = $row["hora_inicio"] . " - " . $row["hora_fin"];
        }
    }

    // Generar todos los horarios del día
    $todos_horarios = generar_horarios_dia();

    echo "<tr><td colspan='3'><h3>Horarios disponibles para el $fechaSeleccionada:</h3></td></tr>";
    echo "<tr><td colspan='3'>";
    echo "<table class='horarios-table'>";
    echo "<tr><th>Horario</th><th>Disponible</th><th>Acción</th></tr>";
    foreach ($todos_horarios as $horario) {
        $estado = !in_array($horario, $horarios_reservados);
        echo "<tr>";
        echo "<td>$horario</td>";
        echo "<td>" . ($estado ? "Sí" : "No") . "</td>";
        if ($estado) {
            echo "<td>";
            echo "<form method='post' action='reservar_horario.php'>";
            echo "<input type='hidden' name='fecha' value='$fechaSeleccionada'>";
            echo "<input type='hidden' name='horario' value='$horario'>";
            echo "<input type='submit' value='Reservar'>";
            echo "</form>";
            echo "</td>";
        } else {
            echo "<td>No disponible</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</td></tr>";
}

$conn->close();
?>
