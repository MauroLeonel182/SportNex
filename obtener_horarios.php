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

    echo "<form method='post' action='controlador/reserva_horarios.php'>";
    
    echo "<input type='hidden' name='fecha' value='$fechaSeleccionada'>";
    echo "<tr><td colspan='3'><h3>Horarios disponibles para el $fechaSeleccionada:</h3></td></tr>";
    echo "<td><input type='submit' value='Reservar'></td>";
    echo "</form>";
    echo "<table class='horarios-table'>";
    echo "<tr><th></th><th>Horario</th><th>Disponible</th></tr>";
    
    foreach ($todos_horarios as $horario) {
        $estado = !in_array($horario, $horarios_reservados);
        echo "<tr class='horario-row'>";
        echo "<td><input type='checkbox' name='horario_seleccionado[]' value='$horario'></td>";
        echo "<td>$horario</td>";
        echo "<td>" . ($estado ? "Sí" : "No") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
$conn->close();
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form');
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const row = this.closest('.horario-row');
                if (this.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            });
        });

        form.addEventListener('submit', function(event) {
            const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');
        });
    });
</script>
<style>
    /* Estilos para la tabla de horarios */
    .horarios-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
        border-radius: 8px; /* Bordes redondeados */
        overflow: hidden; /* Para evitar que la sombra se extienda más allá de la tabla */
    }

    .horarios-table th, .horarios-table td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: center;
    }

    .horarios-table th {
        background-color: #333;
        color: #fff;
    }

    .horarios-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .horarios-table tr:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }

    /* Casillas de selección */
    .horarios-table input[type="checkbox"] {
        margin: 0;
        padding: 0;
        width: 16px;
        height: 16px;
        vertical-align: middle; /* Alinear al centro verticalmente */
    }
</style>