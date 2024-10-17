<?php
// Incluye la configuración de la base de datos
include('modelo/conexion.php');

// Incluye PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class RecuperarPasswordController {

    public static function index() {
        $resultado = ['mensaje' => '', 'type' => '']; // Array para almacenar el mensaje y tipo

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];

            // Crear una instancia de la conexión
            $conexion = new Conexion();
            $pdo = $conexion->conectar();

            // Verificar si el correo existe en la base de datos
            $query = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                // Generar un token único
                $token = bin2hex(random_bytes(16));
                $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token válido por 1 hora

                // Guardar el token en la base de datos
                $insertToken = "UPDATE usuario SET reset_token = :token, reset_token_expira = :expira WHERE email = :email";
                $stmt = $pdo->prepare($insertToken);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':expira', $expira);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                // URL de recuperación de contraseña
                $resetLink = "localhost/SportNex/modelo/reset_password.php?token=" . $token;

                // Llamar a la función para enviar el correo con PHPMailer
                self::enviarCorreoRecuperacion($email, $resetLink);

                // Mostrar mensaje de éxito
                $resultado['mensaje'] = 'Se ha enviado un enlace de recuperación a tu correo.';
                $resultado['type'] = 'success';
                $_POST = array(); // Limpiar $_POST para vaciar los campos del formulario
                
            } else {
                // Mostrar alerta de error si el correo no existe
                $resultado['mensaje'] = 'El correo ingresado no está registrado.';
                $resultado['type'] = 'error';
            }

            // Desconectar la base de datos
            $conexion->desconectar();

        }
        return $resultado; // Retornar el resultado para mostrarlo en la vista
    }

    // Función para enviar el correo
    private static function enviarCorreoRecuperacion($email, $resetLink) {
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Para cuentas de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'sportnex.sistem@gmail.com'; // Cambia esto por tu correo SMTP
            $mail->Password = 'yoxh imsl nvmh yhhs'; // Cambia esto por tu contraseña SMTP
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('sportnex.sistem@gmail.com', 'SportNex');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperar Password';
            $mail->Body = "<p>Hemos recibido una solicitud para restablecer tu contraseña. 
                           Haz clic en el siguiente enlace para cambiar tu contraseña:</p>
                           <a href='$resetLink'>$resetLink</a>
                           <p>Si no solicitaste este cambio, ignora este mensaje.</p>";

            $mail->send();
            header("refresh:2;http://localhost/SportNex/?page=login");

        } catch (Exception $e) {
            // Manejar el error del envío
            return ['mensaje' => 'Error al enviar el correo. Inténtalo de nuevo.', 'type' => 'error'];
        }
        
    }
    
}
?>
