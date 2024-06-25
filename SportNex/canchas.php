<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportNex</title>
    <!-- Estilos -->
    <link rel="icon" href="public/img/logo.png" type="logo/png">
    
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/canchas.css">

    <script src="https://kit.fontawesome.com/ed3188a352.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require  'vista/layouts/header.php'; ?>
    
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
                    <?php require "controlador/obtener_horarios.php"; ?>
                </table>
            </div>
        </section>
    </main>
    <?php require'vista/layouts/footer.php'; ?>
</body>
</html>

