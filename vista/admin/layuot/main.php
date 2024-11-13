<?php
require "vista/admin/menu.php";
require_once 'modelo/reporte.php';

$reporte = new Reporte();

// Obtener los datos dinámicos
$ganancias = $reporte->obtenerGananciasTotales();
$usuariosRegistrados = $reporte->obtenerUsuariosRegistrados();
$horasAlquiladas = $reporte->obtenerHorasAlquiladas();
$clientesFrecuentes = $reporte->obtenerClientesFrecuentes();
$horasPorDia = $reporte->obtenerHorasPorDia(); // Obtener horas por día para el gráfico de barras
$gananciasPorDia = $reporte->obtenerGananciasPorDia();
$reservasCanceladas = $reporte->obtenerReservasCanceladas();  // Obtener las reservas canceladas
?>

<style>
body {
    background-color: #121212;
    color: white;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Estilo para el mensaje de bienvenida */
.welcome-message {
    text-align: center;
    font-size: 20px;
    margin-bottom: 20px;
    color: #eee;
    /* Color más claro para destacar sobre el fondo oscuro */
}

/* Resto de tus estilos */
.tabs {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.tab {
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    /* Fondo semi-transparente */
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    /* Sombra más pronunciada */
    color: white;
    border-radius: 4px;
    transition: background 0.3s;
}

.tab:hover {
    background: rgba(255, 255, 255, 0.2);
    /* Efecto hover */
}

.stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-box {
    background: rgba(255, 255, 255, 0.1);
    /* Fondo semi-transparente */
    padding: 20px;
    width: 30%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
    border-radius: 4px;
}

.stat-box h3 {
    font-size: 16px;
    margin-bottom: 10px;
    color: #ccc;
    /* Color más claro para el texto */
}

.stat-box p {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-box p {
    color: #28a745;
}

.charts {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;

}

.chart-box {
    background: rgba(255, 255, 255, 0.1);
    /* Fondo semi-transparente */
    padding: 20px;
    width: 45%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

.chart-box h3 {
    font-size: 16px;
    margin-bottom: 10px;
    color: #ccc;
    /* Color más claro para el texto */
}

.bar-chart-box {
    background: rgba(255, 255, 255, 0.1);
    /* Fondo semi-transparente */
    padding: 20px;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    border-radius: 4px;

}

.container-xl {
    max-width: 1380px;
    margin: auto;
    /* Centrar el contenedor */
    padding: 20px;
    /* Añadir espaciado interno */
}

/* Estilo para la sección de reservas canceladas */
.cancelled-reservations {
    background: rgba(255, 255, 255, 0.1);
    /* Fondo semi-transparente */
    padding: 20px;
    margin-top: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    /* Sombra */
    color: white;
    width: 70%; /* Reducir al 50% del tamaño original */
    margin: 0 auto; /* Centrar horizontalmente */
}

.cancelled-reservations h3 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #ff6f61;
    /* Color llamativo para el título */
}

.cancelled-reservations ul {
    list-style-type: none;
    padding: 0;
}

.cancelled-reservations .cancelled-item {
    display: flex;
    justify-content: space-between;
    padding: 15px;
    margin-bottom: 15px;
    background: rgba(255, 255, 255, 0.2);
    /* Fondo más claro para cada ítem */
    border-radius: 6px;
    transition: background 0.3s ease;
}

.cancelled-reservations .cancelled-item:hover {
    background: rgba(255, 255, 255, 0.3);
    /* Fondo más claro al pasar el cursor */
}

.cancelled-reservations .cancelled-info {
    font-size: 18px;
    color: #f1f1f1;
    font-weight: bold;
}

.cancelled-reservations .cancelled-details p {
    margin: 5px 0;
    font-size: 14px;
    color: #ddd;
}

.cancelled-reservations .status {
    color: #ff6f61;
    /* Color rojo para resaltar el estado */
    font-weight: bold;
}

.cancelled-reservations p {
    font-size: 16px;
    text-align: center;
    color: #f1f1f1;
}

</style>


<body>
    <div class="container-xl">
        <!-- Mensaje de bienvenida -->
        <div class="welcome-message">
            <?php 
                if (isset($_SESSION['rol']) && isset($_SESSION['usuario'])) {
                    $rol = htmlspecialchars($_SESSION['rol']);
                    $usuario = htmlspecialchars($_SESSION['usuario']);
                    echo "Bienvenido, " . $usuario . "! Tu rol es " . $rol . ".";
                } else {
                    echo "Bienvenido, invitado!";
                }
            ?>
        </div>

        <!-- Sección de estadísticas -->
        <div class="stats">
            <div class="stat-box">
                <h3>Ganancias</h3>
                <p>$<?php echo number_format($ganancias, 2); ?></p>

            </div>
            <div class="stat-box">
                <h3>Usuarios Registrados</h3>
                <p><?php echo $usuariosRegistrados; ?></p>

            </div>
            <div class="stat-box">
                <h3>Alquiler de Horas</h3>
                <p><?php echo $horasAlquiladas; ?></p>

            </div>
        </div>

        <!-- Sección de gráficos y clientes frecuentes -->
        <div class="charts">
            <div class="chart-box">
                <h3>Ganancias</h3>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Clientes Frecuentes</h3>
                <ul>
                    <?php foreach ($clientesFrecuentes as $cliente): ?>
                    <li><?php echo htmlspecialchars($cliente['nombre_usuario']) . " - " . htmlspecialchars($cliente['email']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Gráfico de barras de horas más alquiladas -->
        <div class="bar-chart-box">
            <h3>Horas más Alquiladas</h3>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Sección de reservas canceladas -->
    <div class="cancelled-reservations">
        <h3>Reservas Canceladas</h3>
        <?php if (empty($reservasCanceladas)): ?>
        <p>No hay reservas canceladas.</p>
        <?php else: ?>
        <ul>
            <?php foreach ($reservasCanceladas as $reserva): ?>
            <li class="cancelled-item">
                <div class="cancelled-info">
                    <strong>Usuario: <?php echo htmlspecialchars($reserva['nombre_usuario']); ?></strong> -
                    <?php echo htmlspecialchars($reserva['email']); ?>
                </div>
                <div class="cancelled-details">
                    <p><strong>Fecha de la reserva:</strong> <?php echo htmlspecialchars($reserva['fecha_reserva']); ?>
                    </p>
                    <p><strong>Estado:</strong> <span
                            class="status"><?php echo htmlspecialchars($reserva['estado']); ?></span></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- Script de gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const barCtx = document.getElementById('barChart').getContext('2d');

    // Pasar datos de PHP a JavaScript
    const fechasGanancias = <?php echo json_encode($gananciasPorDia['fechas']); ?>;
    const datosGanancias = <?php echo json_encode($gananciasPorDia['ganancias']); ?>;
    const horasPorDia = <?php echo json_encode($horasPorDia); ?>;

    // Gráfico de línea para Ganancias (datos dinámicos)
    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: fechasGanancias,
            datasets: [{
                label: 'Ganancias',
                data: datosGanancias,
                borderColor: '#000',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de barras para Horas más Alquiladas (datos dinámicos)
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            datasets: [{
                label: 'Horas más Alquiladas',
                data: horasPorDia,
                backgroundColor: '#000'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>

</html>
