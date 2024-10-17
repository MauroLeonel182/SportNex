<?php
// reset_password.php
include('conexion.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    // Buscar el token en la base de datos y verificar si no ha expirado
    $query = "SELECT * FROM usuario WHERE reset_token = :token AND reset_token_expira > NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch();

    // Si el token es válido, mostrar el formulario
    if ($user) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar la nueva contraseña (puedes agregar más reglas de validación)
            $nuevaPassword = $_POST['nueva_password'];
            if (strlen($nuevaPassword) < 8) {
                echo "La contraseña debe tener al menos 8 caracteres.";
            } else {
                // Hash de la nueva contraseña
                $password_hash = password_hash($nuevaPassword, PASSWORD_DEFAULT);

                // Actualizar la contraseña y limpiar el token
                $updateQuery = "UPDATE usuario SET contrasena = :password, reset_token = NULL, reset_token_expira = NULL WHERE reset_token = :token";
                $stmt = $pdo->prepare($updateQuery);
                $stmt->bindParam(':password', $password_hash);
                $stmt->bindParam(':token', $token);
                $stmt->execute();


                // Mostrar un script que cierra la ventana después de un breve mensaje
                echo "<script>
                        alert('Contraseña actualizada correctamente. La ventana se cerrará ahora.');
                        window.close();
                      </script>";
                exit();
            }
        }
    } else {
        // Si el token no es válido o ha expirado
        echo "El token es inválido o ha expirado.";
    }
} else {
    echo "No se proporcionó un token.";
}
?>


<!-- Formulario para cambiar la contraseña -->
<form action="" method="POST">
    <label for="nueva_password">Nueva Contraseña:</label>
    <input type="password" name="nueva_password" id="nueva_password" required>
    <button type="submit">Cambiar Contraseña</button>
</form>
