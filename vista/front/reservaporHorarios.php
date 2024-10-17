<?php
// Iniciar la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario']) && $_SESSION['rol'] === 'cliente') {
    require "vista/layouts/headerfront.php";
} else {
    require "vista/layouts/header.php";
}

// Capturar el 'cancha_id' y la fecha desde la URL
$cancha_id = isset($_GET['cancha_id']) ? $_GET['cancha_id'] : null;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

// Verificar si se recibió el cancha_id
if (!$cancha_id) {
    die('No se ha seleccionado una cancha.');
}

// Obtener los datos de la cancha
$canchaModel = new Cancha();
$cancha = $canchaModel->buscar2($cancha_id);  // Llamar al método correcto

if (!$cancha) {
    die('Cancha no encontrada.');
}

// Obtener los horarios de esa cancha para la fecha seleccionada
$todos_horarios = [
    '13:00', '14:00', '15:00', '16:00', '17:00', 
    '18:00', '19:00', '20:00', '21:00', '22:00', '23:00' // Horarios disponibles por defecto
];

// Simulamos horarios reservados (esto normalmente vendría de tu base de datos)
$horarios_reservados = []; // Esto debe ser llenado según tus reservas reales

// Aquí deberías incluir la lógica que llena $horarios_reservados
// Ejemplo: $horarios_reservados = $horarioModel->obtenerHorariosReservados($cancha_id, $fecha);

?>

<style>
.containerr {
    max-width: 1600px;
    margin: auto;
    padding: 100px;
}

h3 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.formulario {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

.formulario label {
    font-size: 16px;
    margin-right: 10px;
}

.formulario input[type="date"] {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    flex: 1;
    /* Permite que los campos de fecha se expandan */
}

.formulario input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin: 5px;
    transition: background-color 0.3s ease;
}

.formulario input[type="submit"]:hover {
    background-color: #45a049;
}

.horarios-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    background-color: white;
}

.horarios-table th,
.horarios-table td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
}

.horarios-table th {
    background-color: #333;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
}

.horarios-table td {
    font-size: 16px;
}

.horarios-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.horarios-table tr:hover {
    background-color: #f1f1f1;
}

.horarios-table tr.disabled {
    background-color: #f2f2f2;
    color: #ccc;
}

.horarios-table input[type="checkbox"] {
    margin: 0;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.selected {
    background-color: #c1e1c1 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .containerr {
        padding: 60px;
        /* Reducir el padding en pantallas pequeñas */
    }

    .formulario {
        flex-direction: column;
        /* Cambiar a columna en móviles */
        align-items: flex-start;
        /* Alinear elementos a la izquierda */
    }

    .formulario label {
        margin-bottom: 10px;
        /* Espacio debajo de las etiquetas */
    }

    .formulario input[type="date"],
    .formulario input[type="submit"] {
        width: 100%;
        /* Hacer los campos de entrada ocupar todo el ancho */
        box-sizing: border-box;
        /* Asegurar que el padding se incluya en el ancho */
    }

    .formulario input[type="submit"] {
        margin: 5px 0;
        /* Espacio entre botones */
    }

    h3 {
        font-size: 1.5rem;
        /* Tamaño de fuente más pequeño para el título */
    }

    .horarios-table th,
    .horarios-table td {
        font-size: 14px;
        /* Reducir tamaño de fuente de la tabla */
        padding: 10px;
        /* Reducir padding en celdas */
    }
}

@media (max-width: 576px) {
    h3 {
        font-size: 1.25rem;
        /* Tamaño de fuente aún más pequeño para pantallas pequeñas */
    }

    .horarios-table th,
    .horarios-table td {
        font-size: 12px;
        /* Tamaño de fuente más pequeño para la tabla */
    }
}
</style>


<div class="containerr">
    <h3>Horarios disponibles para <?= htmlspecialchars($cancha->nombre) ?> el <?= htmlspecialchars($fecha) ?>:</h3>

    <form class="formulario" method="get" action="index.php">
        <input type="hidden" name="page" value="horarios">
        <input type="hidden" name="cancha_id" value="<?= htmlspecialchars($cancha_id) ?>">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required
            onchange="validarHoraInicio()">
        <input type="submit" value="Mostrar Horarios">
        <input type="submit" value="Reservar">
    </form>

    <table class="horarios-table">
        <tr>
            <th></th>
            <th>Horario</th>
            <th>Disponible</th>
        </tr>
        <?php foreach ($todos_horarios as $horario): ?>
        <?php $estado = !in_array($horario, $horarios_reservados); ?>
        <tr class="horario-row <?= $estado ? '' : 'disabled'; ?>">
            <td>
                <?php if ($estado): ?>
                <input type="checkbox" name="horario_seleccionado[]" value="<?= htmlspecialchars($horario) ?>">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($horario) ?></td>
            <td><?= $estado ? 'Sí' : 'No' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
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
});
</script>

<?php require "vista/layouts/footer.php"; ?>