<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/logo.png" type="logo/png">
    <title>SportNex Administrador</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: #f7f7f7;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            font-size: 24px;
            margin-right: 20px;
        }

        .header-left h2 {
            font-size: 18px;
            color: #666;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .report-btn {
            background: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-right: 20px;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
            margin-right: 20px;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
            top: 60px; /* Ajusta la posición vertical según tu diseño */
            border-radius: 5px;
        }

        .profile-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-pic img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
        }

        main {
            padding: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            background: #fff;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #fff;
            padding: 20px;
            width: 30%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
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
            background: #fff;
            padding: 20px;
            width: 45%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }

        .bar-chart-box {
            background: #fff;
            padding: 20px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left .logo {
            width: 80px; /* Ajusta el tamaño de la imagen */
            height: auto; /* Mantén la proporción de la imagen */
            margin-right: 10px; /* Espacio entre la imagen y el texto */
        }

        .header-left h1 {
            font-size: 24px;
            margin-right: 20px;
        }

        .header-left h2 {
            font-size: 18px;
            color: #666;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
    <div class="header-left">
        <img src="../../../public/img/logo.png" alt="Logo" class="logo">
        <h1>SportNex</h1>
        <h2>Horarios</h2>
    </div>
    <div class="header-right">
        <button class="report-btn">Generar Reporte</button>
        <div class="profile-dropdown">
            <div class="profile-pic">
                <img src="../../../public/img/asd.png" alt="Profile Picture">
            </div>
            <div class="profile-dropdown-content">
                <a href="#">Perfil</a>
                <a href="#">Configuración</a>
                <a href="../../../modelo/cerrar_sesion.php">Salir</a>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="tabs">
        <button class="tab">Tab 1</button>
        <button class="tab">Tab 2</button>
        <button class="tab">Tab 3</button>
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
</main>
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

    // JavaScript para manejar el menú desplegable del perfil
    document.querySelector('.profile-pic').addEventListener('click', function() {
        const dropdown = document.querySelector('.profile-dropdown-content');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.profile-dropdown-content');
        const profilePic = document.querySelector('.profile-pic img');
        if (!profilePic.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>
</body>
</html>

