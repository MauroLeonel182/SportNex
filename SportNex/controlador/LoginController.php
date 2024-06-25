<?php
session_start();

require "modelo\loginmodel.php"; // Asegúrate de incluir el archivo del modelo

// Verificamos si ya hay una sesión activa, si es así, redirigimos al usuario
if(isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit;
}

// Si se envió el formulario de login
if(isset($_POST['email']) && isset($_POST['contrasena'])){
    $email = $_POST['email'];
    $contraseña = $_POST['contrasena'];

    // Instanciamos el modelo Login
    $login = new Login();

    // Llamamos al método login para verificar las credenciales
    if($login->login($email, $contraseña)){
        // Si el login es exitoso, establecemos la sesión y redirigimos al usuario
        $_SESSION['usuario'] = $email;
        header("Location: index.php");
        exit;
    } else {
        // Si las credenciales no son válidas, mostramos un mensaje de error
        echo '
        <script>
            alert("Usuario inexistente, favor verificar sus datos correctamente");
            window.location = "../index.php";
        </script>
        ';
        exit;
    }
} else {
    // Si no se enviaron todos los campos requeridos, redirigimos al usuario
    echo '
    <script>
        alert("Por favor complete todos los campos");
        window.location = "../index.php";
    </script>
    ';
    exit;
}
?>

?>
