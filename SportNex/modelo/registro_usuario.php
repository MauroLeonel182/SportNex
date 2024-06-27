<?php
include 'conexion.php'; // Asegúrate de que 'conexion.php' establece la conexión correctamente

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$dni = $_POST['dni'];
$telefono = $_POST['telefono'];
$nombre_usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];
$tipo_usuario = $_POST['rol']; // Este valor es 'cliente' por defecto desde el formulario

// Hash de la contraseña
$password_hash = hash('sha512', $contrasena);

// Verificar que el correo no esté registrado
$query_correo = "SELECT * FROM usuario WHERE email = ?";
$stmt_correo = mysqli_prepare($conexion, $query_correo);
mysqli_stmt_bind_param($stmt_correo, "s", $email);
mysqli_stmt_execute($stmt_correo);
$result_correo = mysqli_stmt_get_result($stmt_correo);

if (mysqli_num_rows($result_correo) > 0) {
    echo '
    <script>
        alert("Este correo ya está registrado, intenta con otro...");
        window.location = "../login.php";
    </script>    
    ';
    exit();
}

// Verificar que el nombre de usuario no esté registrado
$query_usuario = "SELECT * FROM usuario WHERE nombre_usuario = ?";
$stmt_usuario = mysqli_prepare($conexion, $query_usuario);
mysqli_stmt_bind_param($stmt_usuario, "s", $nombre_usuario);
mysqli_stmt_execute($stmt_usuario);
$result_usuario = mysqli_stmt_get_result($stmt_usuario);

if (mysqli_num_rows($result_usuario) > 0) {
    echo '
    <script>
        alert("Este nombre de usuario ya está registrado, intenta con otro...");
        window.location = "../login.php";
    </script>    
    ';
    exit();
}

// Insertar datos en la tabla persona
$query_persona = "INSERT INTO persona (nombre, apellido, email, dni, telefono) 
                  VALUES (?, ?, ?, ?, ?)";
$stmt_persona = mysqli_prepare($conexion, $query_persona);
mysqli_stmt_bind_param($stmt_persona, "sssss", $nombre, $apellido, $email, $dni, $telefono);
$ejecutar_persona = mysqli_stmt_execute($stmt_persona);

if ($ejecutar_persona) {
    // Insertar datos en la tabla usuario
    $query_usuario = "INSERT INTO usuario (email, nombre_usuario, contrasena, rol, fecha_registro)
                      VALUES (?, ?, ?, ?, current_timestamp())";
    $stmt_usuario = mysqli_prepare($conexion, $query_usuario);
    mysqli_stmt_bind_param($stmt_usuario, "ssss", $email, $nombre_usuario, $password_hash, $tipo_usuario);
    $ejecutar_usuario = mysqli_stmt_execute($stmt_usuario);

    if ($ejecutar_usuario) {
        echo '
            <script>
                alert("Usuario registrado exitosamente");
                window.location = "../index.php";
            </script>    
        ';
    } else {
        echo '
            <script>
                alert("Error al registrar usuario");
                window.location = "../login.php";
            </script>    
        ';
    }
} else {
    echo '
        <script>
            alert("Error al registrar persona");
            window.location = "../login.php";
        </script>    
    ';
}

mysqli_stmt_close($stmt_persona);
mysqli_stmt_close($stmt_usuario);
mysqli_close($conexion);
?>
