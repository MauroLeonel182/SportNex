<?php require "vista/admin/menu.php"?>

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

.stat-box span {
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

        <div class="stats">
            <div class="stat-box">
                <h3>Ganancias</h3>
                <p>$45,678.90</p>
                <span>+20% mes a mes</span>
            </div>
            <div class="stat-box">
                <h3>Usuarios Registrados</h3>
                <p>2,405</p>
                <span>+33% mes a mes</span>
            </div>
            <div class="stat-box">
                <h3>Alquiler de Horas</h3>
                <p>10,353</p>
                <span>-8% mes a mes</span>
            </div>
        </div>
        <div class="charts">
            <div class="chart-box">
                <h3>Título</h3>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Clientes Frecuentes</h3>
                <ul>
                    <li>Helena - email@figmasfakedomain.net</li>
                    <li>Oscar - email@figmasfakedomain.net</li>
                    <li>Daniel - email@figmasfakedomain.net</li>
                    <li>Daniel Jay Park - email@figmasfakedomain.net</li>
                    <li>Mark Rojas - email@figmasfakedomain.net</li>
                </ul>
            </div>
        </div>
        <div class="bar-chart-box">
            <h3>Horas más Alquiladas</h3>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const barCtx = document.getElementById('barChart').getContext('2d');

    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['23 Nov', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: 'Ganancias',
                data: [25000, 27000, 30000, 35000, 37000, 40000, 45000, 50000],
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

    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            datasets: [{
                label: 'Horas más Alquiladas',
                data: [14, 17, 19, 21, 18, 19, 15],
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