<?php
// Iniciar la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('America/Argentina/Buenos_Aires');
// Redirección y headers según el rol
if (isset($_SESSION['usuario']) && $_SESSION['rol'] === 'cliente') {
    require "vista/layouts/headerfront.php";
} else {
    require "vista/layouts/header.php";
}

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . urlsite . "?page=login");
    exit;
}

// Verificar y capturar 'cancha_id' y fecha desde la URL
$cancha_id = $_GET['cancha_id'] ?? null;
$fecha = $_GET['fecha'] ?? date('Y-m-d');

// Validar que 'cancha_id' esté presente
if (!$cancha_id) {
    die('No se ha seleccionado una cancha.');
}

// Inicializar el modelo de cancha
require_once "modelo/cancha.php"; // Asegúrate de incluir el modelo correctamente
$canchaModel = new Cancha();

// Obtener datos de la cancha
$cancha = $canchaModel->buscar2($cancha_id);
if (!$cancha) {
    die('Cancha no encontrada.');
}

// Obtener el precio por hora
$precioPorHora = $canchaModel->obtenerPrecioPorHora($cancha_id);
if (!$precioPorHora) {
    die('No se pudo obtener el precio de la cancha.');
}

// Obtener horarios reservados desde la base de datos
require_once "modelo/reserva.php"; // Asegúrate de incluir el modelo correctamente
$reservaModel = new ReservaModel();
$horarios_reservados = $reservaModel->obtenerHorariosReservados($cancha_id, $fecha);

?>


<style>
.containerr {
    max-width: 1600px;
    margin: auto;
    padding: 150px;
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

.formulario input[type="button"] {
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

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#confirmarReserva {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

#confirmarReserva:hover {
    background-color: #45a049;
}

@media (max-width: 768px) {
    .formulario {
        flex-direction: column;
        align-items: flex-start;
    }

    .formulario label {
        margin-bottom: 10px;
    }

    .formulario input[type="date"],
    .formulario input[type="submit"] {
        width: 100%;
        box-sizing: border-box;
    }

    .formulario input[type="submit"] {
        margin: 5px 0;
    }
}
</style>


<div class="containerr">
    <h3>Horarios disponibles para <?= htmlspecialchars($cancha->nombre) ?> el <?= htmlspecialchars($fecha) ?>:</h3>
    <form class="formulario" method="get" action="?page=horarios">
        <input type="hidden" name="page" value="horarios">
        <input type="hidden" name="cancha_id" value="<?= htmlspecialchars($cancha_id) ?>">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required
            min="<?= date('Y-m-d') ?>">
        <input type="submit" value="Mostrar Horarios">
        <input type="button" value="Reservar" id="btnReservar">
        <input type="hidden" id="canchaId" value="<?= htmlspecialchars($cancha_id) ?>"> <!-- El ID de la cancha -->
        <input type="hidden" id="usuario_id"
            value="<?= isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : '' ?>">


    </form>

    <!-- Formulario para enviar la reserva -->
    <form id="form-reservar" method="POST" action="?page=reservar">
        <input type="hidden" name="fecha" value="<?= htmlspecialchars($fecha) ?>">
        <input type="hidden" name="hora_inicio" id="hora_inicio_input">
        <input type="hidden" name="hora_fin" id="hora_fin_input">
        <input type="hidden" name="total" id="totalReservaInput">
        <input type="hidden" name="cancha_id" value="<?= htmlspecialchars($cancha_id) ?>">
        <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($usuario_id) ?>">
        <input type="hidden" name="metodo_pago" id="metodo_pago" value="MERCADO PAGO">


        <table class="horarios-table">
            <tr>
                <th></th>
                <th>Horario</th>
                <th>Disponible</th>
            </tr>
            <?php foreach ($horariosDisponibles as $horario): ?>
            <?php $estado = true; // Si estamos en este punto, el horario está disponible ?>
            <tr class="horario-row <?= $estado ? '' : 'disabled'; ?>">
                <td>
                    <?php if ($estado): ?>
                    <input type="checkbox" name="horario_seleccionado[]"
                        value="<?= htmlspecialchars($horario['inicio']) ?>,<?= htmlspecialchars($horario['fin']) ?>">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($horario['inicio']) ?> - <?= htmlspecialchars($horario['fin']) ?></td>
                <td><?= $estado ? 'Sí' : 'No' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const canchaId = document.getElementById('canchaId').value;
    const usuarioId = document.getElementById('usuario_id').value;
    const precioPorHora = <?= $precioPorHora ?>;

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

    const reservarBtn = document.getElementById("btnReservar");
    const modal = document.getElementById("reservaModal");
    const span = document.getElementsByClassName("close")[0];
    const totalReserva = document.getElementById("totalReserva");
    const confirmarReserva = document.getElementById("confirmarReserva");
    const metodoPago = document.getElementById("medoto_pago");


    const horaInicioInput = document.getElementById('hora_inicio_input');
    const horaFinInput = document.getElementById('hora_fin_input');
    const totalReservaInput = document.getElementById('totalReservaInput');

    reservarBtn.addEventListener("click", function() {
        const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');
        const horasSeleccionadas = Array.from(checkedBoxes).map(cb => cb.value.split(','));

        if (horasSeleccionadas.length === 0) {
            alert("Por favor, selecciona al menos un horario.");
            return;
        }

        // Asegurémonos de que la hora de inicio y fin se asignen correctamente
        const horaInicio = horasSeleccionadas[0][0]; // HH:mm
        const horaFin = horasSeleccionadas[horasSeleccionadas.length - 1][1]; // HH:mm

        // Validar y ajustar las horas
        const ajustarHora = hora => {
            if (hora.includes(':') && hora.split(':').length === 2) {
                return hora + ':00';
            }
            return hora;
        };

        const horaInicioConSegundos = ajustarHora(horaInicio);
        const horaFinConSegundos = ajustarHora(horaFin);



        // Depuración: Imprime los valores en la consola
        console.log("Hora inicio (enviada):", horaInicioConSegundos);
        console.log("Hora fin (enviada):", horaFinConSegundos);

        // Calcular el total basado en el número de horas seleccionadas
        const totalHoras = horasSeleccionadas.length;
        const total = totalHoras * precioPorHora;

        // Mostrar los datos en el modal
        document.getElementById("cancha_id").innerText = canchaId;
        document.getElementById("usuario_id_modal").innerText = usuarioId;
        document.getElementById("hora_inicio").innerHTML = horaInicioConSegundos;
        document.getElementById("hora_fin").innerHTML = horaFinConSegundos;
        totalReserva.innerText = `$${total.toLocaleString()}`;

        // Llenar los campos ocultos para el formulario de reserva
        horaInicioInput.value = horaInicioConSegundos;
        horaFinInput.value = horaFinConSegundos;
        totalReservaInput.value = total;

        // Mostrar el modal
        modal.style.display = "block";
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    confirmarReserva.addEventListener("click", function() {
        const fecha = document.querySelector('input[name="fecha"]').value;
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;
        const total = totalReservaInput.value;
        const metodoPago = document.getElementById("metodo_pago").value; // Correcto

        // Crear un formulario dinámico para enviar los datos por POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '?page=reservar';

        const agregarCampoOculto = (name, value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        };

        agregarCampoOculto('fecha', fecha);
        agregarCampoOculto('hora_inicio', horaInicio);
        agregarCampoOculto('hora_fin', horaFin);
        agregarCampoOculto('total', total);
        agregarCampoOculto('cancha_id', canchaId);
        agregarCampoOculto('usuario_id', usuarioId);
        agregarCampoOculto('metodo_pago', metodoPago); // Asegúrate de agregar este campo

        // Depuración: Imprime el formulario antes de enviarlo
        console.log("Formulario enviado:", form);

        // Agregar el formulario al body y enviarlo
        document.body.appendChild(form);
        form.submit();
    });

});
</script>

<!-- Modal Structure -->
<div id="reservaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Resumen de Reserva</h2>
        <p><strong>Cancha ID:</strong> <span id="cancha_id"></span></p>
        <p><strong>Usuario ID:</strong> <span id="usuario_id_modal"></span></p>
        <p><strong>Hora de Inicio:</strong> <span id="hora_inicio"></span></p>
        <p><strong>Hora de Fin:</strong> <span id="hora_fin"></span></p>
        <p><strong>Total:</strong> <span id="totalReserva"></span></p>
        <button id="confirmarReserva">Confirmar Reserva</button>
    </div>
</div>




<?php require "vista/layouts/footer.php"; ?>