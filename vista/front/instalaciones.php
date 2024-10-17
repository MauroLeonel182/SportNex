<?php
require_once "modelo/conexion.php";
require_once "modelo/cancha.php"; // Suponiendo que tu clase Cancha está en esta ruta

// Inicia la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar el rol del usuario en la sesión
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente') {
    require "vista/layouts/headerfront.php"; // Cargar header para clientes
} else {
    require "vista/layouts/header.php"; // Cargar header general
}

$canchaModel = new Cancha();
$canchas = $canchaModel->buscar("1"); // Selecciona todas las canchas
?>

<main>
    <section class="instalaciones">
        <div class="container">
            <h2>INSTALACIONES</h2>
            <div class="grid-container">
                <?php foreach ($canchas as $r): ?>
                <div class="grid-item">
                    <div class="card">
                        <img src="public/img/instalaciones/<?php echo $r->urlfoto ?>" alt="<?php echo $r->nombre?>"
                            class="card-img">
                        <div class="card-content">
                            <h3><?= $r->nombre ?></h3>
                            <p><?= $r->disponibilidad ?></p>
                            <a href="<?php echo urlsite ?>?page=horarios&cancha_id=<?php echo $r->cancha_id ?>"
                                class="btn btn-primary">Ver Horarios</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php
require_once "vista/layouts/footer.php";
?>

<style>
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    /* Tarjetas más pequeñas */
    gap: 20px;
    /* Espacio entre las tarjetas */
}

.card {
    background-color: #fff;
    /* Fondo blanco para las tarjetas */
    border: 1px solid #ddd;
    /* Borde suave */
    border-radius: 8px;
    /* Bordes redondeados */
    overflow: hidden;
    /* Evitar que el contenido se desborde */
    transition: transform 0.3s;
    margin: 0 auto;
    /* Centrar las tarjetas */
    box-sizing: border-box;
    /* Incluir padding y bordes en el tamaño total */
    display: flex;
    /* Usar flexbox */
    flex-direction: column;
    /* Alinear los elementos verticalmente */
}

.card:hover {
    transform: translateY(-5px);
    /* Sombra ligera al pasar el mouse */
}

.card-img {
    width: 100%;
    /* Imagen ocupa el 100% del contenedor */
    height: auto;
    /* Mantener la proporción */
}

.card-content {
    padding: 16px;
    /* Espaciado interno */
    text-align: center;
    /* Centrar el texto */
    flex: 1;
    /* Permitir que el contenido llene el espacio disponible */
    display: flex;
    /* Usar flexbox para el contenido */
    flex-direction: column;
    /* Alinear elementos verticalmente */
    justify-content: space-between;
    /* Espaciar elementos dentro de la tarjeta */
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #ff4136;
    color: #fff;
}

.btn-primary:hover {
    background-color: #e60000;
}

.card-content a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: color 0.3s;
}

.card-content a:hover {
    color: #0056b3;
}

.btn:hover {
    background-color: #e60000;
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        /* Tarjetas más anchas en pantallas más grandes */
    }

    .instalaciones h2 {
        font-size: 2rem;
        /* Ajustar tamaño de título */
        text-align: center;
        /* Centrar título */
    }
}

@media (max-width: 576px) {
    .grid-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        /* Tarjetas más anchas en pantallas pequeñas */
    }

    .card {
        max-width: 100%;
        /* Asegúrate de que las tarjetas no desborden */
        margin: 0 auto;
        /* Centrar tarjetas */
        height: auto;
        /* Permitir que la altura se ajuste al contenido */
    }

    .card-content {
        display: flex;
        /* Usar flexbox para alinear contenido */
        flex-direction: column;
        /* Alinear contenido verticalmente */
        justify-content: space-between;
        /* Espaciar elementos dentro de la tarjeta */
        flex: 1;
        /* Permitir que el contenido llene el espacio disponible */
    }

    .btn {
        font-size: 0.9rem;
        /* Tamaño de fuente más pequeño para botones */
    }

    .card-content h3 {
        font-size: 1.2rem;
        /* Tamaño de fuente más pequeño para el título */
    }

    .card-content p {
        font-size: 0.9rem;
        /* Tamaño de fuente más pequeño para el texto */
    }
}
</style>