<?php
require "vista/admin/menu.php"; // Menú incluido arriba
require_once 'controlador/ReservaController.php';

// Instancia el controlador y obtén las reservas
$reservaController = new ReservaController();

// Configuración de la fecha actual
setlocale(LC_TIME, 'es_ES.utf8');
$fechaActual = isset($_GET['fecha']) ? new DateTime($_GET['fecha']) : new DateTime();
$fechaAnterior = clone $fechaActual;
$fechaAnterior->modify('-1 day');
$fechaSiguiente = clone $fechaActual;
$fechaSiguiente->modify('+1 day');

// Aquí obtenemos las reservas para la fecha actual llamando al método del controlador
$reservas = $reservaController->mostrarReservasPorFecha($fechaActual->format('Y-m-d'));

?>

<style>
body {
    background-color: #121212;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: white;
    text-align: center;
}

.date-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #121212;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.date-nav a {
    color: #e53e3e;
    text-decoration: none;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border: 2px solid #e53e3e;
    border-radius: 9999px;
    transition: all 0.3s ease;
}

.date-nav a:hover {
    background-color: #e53e3e;
    color: white;
}

.current-date {
    font-size: 1.25rem;
    font-weight: bold;
    background-color: #e53e3e;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
}

.reserva {
    background-color: rgba(0, 0, 0, 0.8);
    border: 1px solid #e53e3e;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.3s ease;
    backdrop-filter: blur(10px);
}

.reserva:hover {
    transform: scale(1.02);
}

.reserva-hora {
    color: #e53e3e;
    font-size: 1.5rem;
    font-weight: bold;
}

.reserva-cancha {
    color: white;
    margin-left: 1rem;
}

.reserva-cliente {
    background-color: #742a2a;
    color: #fecaca;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
}

/* Estilos del modal */
.modal {
    display: none;
    /* Oculto por defecto */
    position: fixed;
    /* Posicionado en la pantalla */
    z-index: 1000;
    /* Colocado sobre otros elementos */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    /* Habilitar desplazamiento si es necesario */
    background-color: rgba(0, 0, 0, 0.8);
    /* Fondo oscuro */
}

.modal-content {
    background-color: #121212;
    margin: 15% auto;
    /* Centro en la pantalla */
    padding: 20px;
    border: 1px solid #e53e3e;
    width: 80%;
    /* Ancho del modal */
    max-width: 600px;
    /* Ancho máximo del modal */
}

.close {
    color: #aaa;
    /* Color del texto */
    float: right;
    /* Flota a la derecha */
    font-size: 28px;
    /* Tamaño del texto */
    font-weight: bold;
    /* Negrita */
}

.close:hover,
.close:focus {
    color: white;
    /* Color al pasar el mouse */
    text-decoration: none;
    /* Sin subrayado */
    cursor: pointer;
    /* Cursor de puntero */
}

.reserva-hora-fin {
    color: #e53e3e;
    font-size: 1.2rem;
    margin-right: 10px;
}

.reserva-estado {
    color: #fecaca;
    font-size: 1rem;
    margin-right: 10px;
}

.no-reservas {
    color: #e53e3e;
    /* Color rojo para destacar el mensaje */
    font-size: 1.5rem;
    /* Tamaño de fuente más grande */
    font-weight: bold;
    /* Negrita para darle énfasis */
    text-align: center;
    /* Centrar el texto */
    margin-top: 2rem;
    /* Espaciado superior */
    padding: 1rem;
    /* Espaciado interno */
    background-color: rgba(255, 255, 255, 0.1);
    /* Fondo semitransparente */
    border: 1px solid #e53e3e;
    /* Borde del mismo color que el texto */
    border-radius: 0.5rem;
    /* Bordes redondeados */
}
</style>

<body>
    <div class="container">
        <h1>Reservas Diarias</h1>
        <div class="date-nav">
            <a href="?page=diario&fecha=<?= $fechaAnterior->format('Y-m-d') ?>">&#8592; Anterior</a>
            <span class="current-date"><?= strftime('%d de %B, %Y', $fechaActual->getTimestamp()) ?></span>
            <a href="?page=diario&fecha=<?= $fechaSiguiente->format('Y-m-d') ?>">Siguiente &#8594;</a>
        </div>

        <!-- Verificar si hay reservas -->
        <?php if (isset($reservas) && count($reservas) > 0): ?>
        <?php foreach ($reservas as $reserva): ?>
        <div class="reserva">
            <div>
                <span class="reserva-hora"><?= date('H:i', strtotime($reserva['hora_inicio'])) ?></span>
                <span class="reserva-cancha"><?= $reserva['cancha'] ?></span>
            </div>
            <div>
                <span class="reserva-hora-fin">Fin: <?php echo $reserva['hora_fin']; ?></span>
                <span class="reserva-estado">Estado: <?php echo $reserva['estado']; ?></span>
            </div>
            <span class="reserva-cliente"><?= $reserva['cliente'] ?></span>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="no-reservas">No hay reservas para este día.</p>
        <?php endif; ?>
    </div>
</body>



</html>