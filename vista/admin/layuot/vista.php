<?php
require "vista/admin/menu.php";
require_once 'modelo/conexion.php';  // Asegúrate de incluir la conexión
require_once 'controlador/ReservaController.php';  // Incluye el controlador

$reservaController = new ReservaController();
$datos = $reservaController->obtenerDatosFormulario();
$usuarios = $datos['usuarios'];
$canchas = $datos['canchas'];
?>
<style>
body {
    background-color: #121212;
}

/* Estilo para el título principal */
h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: white;
    text-align: center;
}

/* Estilo del formulario */
form {
    max-width: 1000px;
    margin: auto;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.8);
    /* Fondo oscuro con transparencia */
    border: 1px solid #e53e3e;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    backdrop-filter: blur(10px);
    position: relative;
    right: 110px;
    /* Llevar el formulario un poco más a la izquierda */
}

/* Estilo de los labels */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: white;
}

/* Estilo de los inputs y select */
input[type="text"],
input[type="date"],
input[type="time"],
input[type="number"],
select {
    width: calc(50% - 10px);
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #e53e3e;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.1);
    /* Fondo con transparencia */
    color: white;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="time"]:focus,
input[type="number"]:focus,
select:focus {
    outline: none;
    border-color: #e53e3e;
    /* Resaltar borde en foco */
    background-color: rgba(255, 255, 255, 0.2);
}

input[type="number"] {
    text-align: right;
}

/* Estilo para los botones */
button,
input[type="submit"] {
    padding: 10px 15px;
    background-color: #e53e3e;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover,
input[type="submit"]:hover {
    background-color: #ff5733;
    /* Cambia color al hacer hover */
}

.form-group {
    display: flex;
    justify-content: space-between;
}

/* Estilo para los campos de entrada y select */
.form-group label,
.form-group input,
.form-group select {
    flex: 1;
    margin-right: 10px;
}

.form-group select {
    width: 100%;
    background-color: #121212;

}

.form-group input:last-child,
.form-group select:last-child {
    margin-right: 0;
}

/* Estilo para los totales */
.grand-total {
    text-align: right;
    font-size: 1.4em;
    font-weight: bold;
    color: #e53e3e;
    margin-top: 10px;
}
</style>

</head>

<body>
    <h1>Crear Nuevo Alquiler</h1>
    <div class="content content-menu-visible" id="content-area">
        <form action="controlador/ReservaController.php" method="POST">
            <!-- Seleccionar usuario -->
            <div class="form-group">
                <label>Nombre de usuario</label>
                <select name="usuario_id" id="usuario_id" onchange="actualizarContacto()" required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['usuario_id'] ?>" data-telefono="<?= $usuario['telefono'] ?>">
                        <?= $usuario['nombre_usuario'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Contacto -->
            <div class="form-group">
                <label>Contacto</label>
                <input type="text" name="contacto" id="contacto" readonly>
            </div>

            <!-- Seleccionar cancha -->
            <div class="form-group">
                <label>Cancha</label>
                <select name="cancha_id" id="cancha" onchange="actualizarTarifa()" required>
                    <option value="">Seleccione una cancha</option>
                    <?php foreach ($canchas as $cancha): ?>
                    <option value="<?= $cancha['cancha_id'] ?>" data-precio="<?= $cancha['precio'] ?>">
                        <?= $cancha['nombre'] ?> - $<?= number_format($cancha['precio'], 2) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tarifa por Hora -->
            <div class="form-group">
                <label>Tarifa por Hora</label>
                <input type="number" name="tarifa_hora" id="tarifa_hora" readonly>
            </div>

            <!-- Fecha -->
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" required onchange="validarHoraInicio()">
            </div>

            <!-- Hora Inicio -->
            <div class="form-group">
                <label>Hora Inicio</label>
                <select name="hora_inicio" id="hora_inicio" required onchange="calcularHoraFin()">
                    <option value="">Seleccione una hora</option>
                    <!-- Generar opciones de 17:00 a 23:00 -->
                    <?php for ($i = 15; $i <= 23; $i++): ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ?>">
                        <?= str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Horas -->
            <div class="form-group">
                <label>Horas</label>
                <input type="number" name="horas" id="horas" min="1" onchange="calcularTotal(); calcularHoraFin();"
                    required>
            </div>

            <!-- Hora Fin -->
            <div class="form-group">
                <label>Hora Fin</label>
                <input type="time" name="hora_fin" id="hora_fin" readonly>
            </div>

            <!-- Total -->
            <div class="form-group">
                <label>Total</label>
                <input type="number" name="total" id="total" readonly>
            </div>

            <div class="grand-total">
                Total: <span id="grandTotal">0.00</span>
            </div>

            <input type="submit" value="Guardar Reserva">
        </form>
    </div>

    <script>
    // Establecer la fecha mínima en el campo de fecha
    document.addEventListener("DOMContentLoaded", function() {
        const fechaInput = document.getElementById('fecha_inicio');
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
        const yyyy = today.getFullYear();
        const minDate = yyyy + '-' + mm + '-' + dd;
        fechaInput.setAttribute('min', minDate);
    });

    // Actualizar el contacto basado en el usuario seleccionado
    function actualizarContacto() {
        const usuarioSelect = document.getElementById('usuario_id');
        const contactoInput = document.getElementById('contacto');
        const selectedOption = usuarioSelect.options[usuarioSelect.selectedIndex];
        const telefono = selectedOption.getAttribute('data-telefono');
        contactoInput.value = telefono;
    }

    // Actualizar la tarifa basada en la cancha seleccionada
    function actualizarTarifa() {
        const canchaSelect = document.getElementById('cancha');
        const tarifaHora = document.getElementById('tarifa_hora');
        const selectedOption = canchaSelect.options[canchaSelect.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        tarifaHora.value = precio;
    }

    // Calcular la hora de fin y el total
    function calcularHoraFin() {
        const horaInicioSelect = document.getElementById('hora_inicio');
        const horasInput = document.getElementById('horas');
        const horaFinInput = document.getElementById('hora_fin');

        if (horaInicioSelect.value && horasInput.value) {
            const horaInicio = new Date(`1970-01-01T${horaInicioSelect.value}:00`);
            const horasAdicionales = parseInt(horasInput.value, 10);
            const horaFin = new Date(horaInicio.getTime() + horasAdicionales * 60 * 60 * 1000);
            const opciones = {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            };
            horaFinInput.value = horaFin.toLocaleTimeString('en-US', opciones);
            calcularTotal(); // Recalcular el total
        } else {
            horaFinInput.value = '';
        }
    }

    // Calcular el total
    function calcularTotal() {
        const tarifaHora = document.getElementById('tarifa_hora').value;
        const horasInput = document.getElementById('horas').value;
        const totalInput = document.getElementById('total');
        const grandTotalSpan = document.getElementById('grandTotal');

        if (tarifaHora && horasInput) {
            const total = tarifaHora * horasInput;
            totalInput.value = total.toFixed(2);
            grandTotalSpan.innerText = total.toFixed(2);
        } else {
            totalInput.value = '0.00';
            grandTotalSpan.innerText = '0.00';
        }
    }

    // Validar la hora de inicio en el formulario
    function validarHoraInicio() {
        const fechaInicio = new Date(document.getElementById('fecha_inicio').value);
        const horaInicio = new Date(fechaInicio);
        const horaInicioSelect = document.getElementById('hora_inicio');

        if (horaInicioSelect.value) {
            const [horas, minutos] = horaInicioSelect.value.split(':').map(Number);
            horaInicio.setHours(horas, minutos, 0);

            const ahora = new Date();
            ahora.setSeconds(0); // Ignorar los segundos

            if (horaInicio <= ahora) {
                alert('La hora de inicio debe ser en el futuro.');
                horaInicioSelect.value = ''; // Limpiar selección de hora
            }
        }
    }
    </script>
</body>





</html>