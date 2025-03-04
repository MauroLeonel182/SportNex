<?php
session_start();
// Cargar autoload de Composer
require "../vendor/autoload.php";


// Configurar Mercado Pago
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken('APP_USR-1022145548778758-112022-f729eb7940cf49386a7229732c7e4afb-2109753486');
// Verificar si la reserva existe en la sesión
if (isset($_SESSION['reserva'])) {
    $reserva = $_SESSION['reserva'];
    $fecha_reserva = htmlspecialchars($reserva['fecha']);
    $hora_inicio = htmlspecialchars($reserva['hora_inicio']);
    $hora_fin = htmlspecialchars($reserva['hora_fin']);
    $total = (float) htmlspecialchars($reserva['total']);
    $cancha_id = (int) htmlspecialchars($reserva['cancha_id']);
    $usuario_id = (int) htmlspecialchars($reserva['usuario_id']);
} else {
    // Redirigir si los datos no están en la sesión
    $_SESSION['msg'] = 'Datos incompletos en la sesión.';
    header("Location: ../vista/error.php");
    exit();
}

// Suponiendo que estas son las horas codificadas recibidas en el formulario
$hora_inicio = urldecode($hora_inicio);  // Decodificar hora de inicio
$hora_fin = urldecode($hora_fin);        // Decodificar hora de fin


// Crear la preferencia de Mercado Pago
$client = new PreferenceClient();

$preference = $client->create([
    "items" => [
        [
            "title" => "Reserva de Cancha #" . htmlspecialchars($cancha_id),
            "quantity" => 1,
            "unit_price" => (float)$total, // Asegúrate de que sea un valor válido
        ],
    ],
    "statement_descriptor" => "SportNex",
    "back_urls" => [
        "success" => "http://localhost/SportNex/?page=horarios&cancha_id=" . urlencode($cancha_id),
        "failure" => "http://localhost/SportNex/vista/front/failure.php",
        "pending" => "http://localhost/SportNex/vista/front/pending.php"
    ],
    "auto_return" => "approved"
]);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SportNex</title>
    <link rel="icon" href="/SportNex/public/img/logo.png" type="logo/png">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        color: #333;
        text-align: center;
    }

    h1 {
        color: #d32f2f; /* Rojo fuerte, acorde al diseño */
        font-size: 28px;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        line-height: 1.5;
        margin: 10px 0;
    }

    .details {
        display: inline-block;
        background: #fff; /* Fondo blanco para resaltar */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .details p {
        font-weight: 500;
        margin: 8px 0;
    }
</style>

<body>
    <h1>Para Confirmar la reserva necesita abonarla en su totalidad.</h1>
    <p>Detalles de su reserva:</p>
    <div class="details">
        <p>Fecha: <?= htmlspecialchars($fecha_reserva) ?></p>
        <p>Hora Inicio: <?= htmlspecialchars($hora_inicio) ?></p>
        <p>Hora Fin: <?= htmlspecialchars($hora_fin) ?></p>
        <p>Total: $<?= number_format($total, 2, ',', '.') ?></p>
    </div>
</body>
    <script>
    const mp = new MercadoPago('APP_USR-1a5253bf-4ca6-4370-b669-44167040b74d', {
        locale: 'es-AR'
    });

    // Crear el botón de pago
    mp.bricks().create("wallet", "cho-container", {
        initialization: {
            preferenceId: "<?= $preference->id ?>" // Pasar el ID de la preferencia
        }
    });
    </script>

    <div id="cho-container"></div> <!-- Contenedor del botón de pago -->
</body>

</html>