<?php
session_start();

include 'conexion.php';

$email = $_POST['email'];
$password = $_POST['contrasena'];
$password = hash('sha512', $password);

$validar_login = mysqli_query($conexion, "SELECT * FROM usuario WHERE email='$email' AND contrasena='$password'");

if (mysqli_num_rows($validar_login) > 0) {
    $row = mysqli_fetch_assoc($validar_login);
    $_SESSION['usuario'] = $email;
    $_SESSION['rol'] = $row['rol']; // Guardar el tipo de usuario en la sesión

    if ($row['rol'] == 'administrador') {
        header("Location: ../vista\admin\layuot\main.php");
    } elseif ($row['rol'] == 'cliente') {
        header("Location: ../vista/layouts/home.php");
    } else {
        // Redirigir a una página por defecto si el rol no es reconocido
        header("Location: ../vista/layout/home.php");
    }
    exit;
} else {
    echo '
    <script>
        alert("Usuario inexistente, favor verificar sus datos correctamente");
        window.location = "../login.php";
    </script>
    ';
    exit;
}
?>

