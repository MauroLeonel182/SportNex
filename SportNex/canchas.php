<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportNex</title>
    <!-- Estilos -->
    <link rel="icon" href="img/logo.png" type="logo/png">
    
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/canchas.css">

    <script src="https://kit.fontawesome.com/ed3188a352.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="img/logo.png" alt="logo">
                <h1>SportNex</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Horarios</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="horarios">
            <h2>Horarios</h2>
            <div class="horarios-container">
                <table class="horarios-table">
                    <tr>
                        <td colspan="3">
                            <h3>Seleccione una fecha:</h3>
                            <form method="get">
                                <input type="date" name="fecha">
                                <input type="submit" value="Ver Horarios">
                            </form>
                        </td>
                    </tr>
                    <?php include 'obtener-horarios.php'; ?>
                </table>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 SportNex. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

