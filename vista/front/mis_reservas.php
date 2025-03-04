<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SportNex/modelo/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/SportNex/modelo/reserva.php';

// Inicia sesión
session_start();
// Verifica que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir si el usuario no está logueado
    exit();
}


// Obtener las reservas del usuario
$usuario_id = $_SESSION['usuario_id'];
$reservaModel = new ReservaModel();
$reservas = $reservaModel->getReservasByUsuario($usuario_id);

// Función para verificar si la reserva se puede cancelar (24 horas antes)
function puedeCancelar($fecha_reserva, $hora_inicio) {
    $horaLimiteCancelacion = strtotime($fecha_reserva . ' ' . $hora_inicio) - 21600; // 86400 segundos = 24 horas
    return time() <= $horaLimiteCancelacion;
}

// Paginación
$porPagina = 10; // Número de reservas por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$totalReservas = count($reservas);
$totalPaginas = ceil($totalReservas / $porPagina);
$offset = ($paginaActual - 1) * $porPagina;
$reservasPagina = array_slice($reservas, $offset, $porPagina);


?>

<!-- Incluye el header -->
<?php require $_SERVER['DOCUMENT_ROOT'] . '/SportNex/vista/layouts/headerfront.php'; ?>

<style>
/* Espaciado para evitar superposición */
body {
    margin-top: 90px;
    /* Ajustar al alto de la navbar */
    font-family: 'Arial', sans-serif;
    background: #ffffff;
    color: #000000;
}

.container .h2 {
    text-align: center;
    margin-top: 40px;
    font-size: 36px;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: bold;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
}

/* Estilo para la tabla */
table {
    width: 100%;
    margin-top: 30px;
    border-collapse: collapse;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    /* Sombra para el efecto flotante */
}

table thead {
    background: linear-gradient(135deg, #00b3a6, #009688);
    /* Degradado futurista */
    color: #ff4444;
}

table th,
table td {
    padding: 15px;
    text-align: center;
    font-size: 14px;
}

/* Fila de encabezado */
table th {
    font-size: 16px;
    letter-spacing: 1px;
}

/* Fila de datos */
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:nth-child(odd) {
    background-color: #eaeaea;
}

table td {
    color: #333;
}

/* Estilo para los botones de acción */
button {
    background-color: #00b3a6;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Sombra sutil */
}

button:hover {
    background-color: #009688;
    transform: translateY(-2px);
    /* Efecto de flotación */
}

button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

/* Mensajes de texto */
span {
    color: #ff4444;
    font-size: 14px;
    font-weight: bold;
}

/* Estilo para el formulario */
form {
    display: inline-block;
    margin-top: 10px;
}

form input {
    display: none;
}

/* Estilo para la tabla cuando no hay reservas */
table.empty {
    text-align: center;
    font-size: 18px;
    color: #ff6666;
}

/* Efecto de hover sobre filas */
table tr:hover {
    background-color: #d6f7f2;
    cursor: pointer;
    transform: scale(1.03);
    transition: all 0.3s ease;
}

/* Estilo para el mensaje de no reservas */
p {
    text-align: center;
    color: #ff4444;
    font-size: 18px;
    font-weight: bold;
}

.pagination {
    margin: 20px 0;
    text-align: center;
}

.pagination a {
    margin: 0 5px;
    text-decoration: none;
    color: #ff4444;
    font-weight: bold;
    border: 1px solid #333;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.pagination a:hover {
    background-color: #ff4444;
    color: white;
}

.pagination .active {
    background-color: #ff4444;
    color: white;
    border-color: #333;
}
</style>

<body>
    <div class="container">
        <h1 class="h2">Mis Reservas</h1>

        <?php if (empty($reservas)): ?>
        <p>No tienes reservas activas.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Cancha</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservasPagina as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['nombre_cancha']) ?></td>
                    <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                    <td><?= htmlspecialchars($reserva['hora_inicio']) ?></td>
                    <td><?= htmlspecialchars($reserva['hora_fin']) ?></td>
                    <td><?= htmlspecialchars($reserva['estado']) ?></td>
                    <td>
                        <?php if ($reserva['estado'] === 'PENDIENTE' && puedeCancelar($reserva['fecha_reserva'], $reserva['hora_inicio'])): ?>
                        <form method="POST" action="cancelar_reserva.php">
                            <input type="hidden" name="reserva_id" value="<?= $reserva['reserva_id'] ?>">
                            <button type="submit"
                                onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">Cancelar</button>
                        </form>
                        <?php else: ?>
                        <span>No se puede cancelar</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Navegación de paginación -->
        <div class="pagination">
            <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?= $paginaActual - 1 ?>">← Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>" class="<?= $i === $paginaActual ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($paginaActual < $totalPaginas): ?>
            <a href="?pagina=<?= $paginaActual + 1 ?>">Siguiente →</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</body>

<!-- Incluye el footer -->
<?php require $_SERVER['DOCUMENT_ROOT'] . '/SportNex/vista/layouts/footer.php'; ?>