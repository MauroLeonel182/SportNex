<?php
session_start();
require "modelo/pagomodel.php";
require "modelo/reserva.php";
require "modelo/cancha.php";
require "modelo/tipoDeporte.php";

class CanchasController{
    public static function listar(){
        require_once "auth.php"; // Verificación de sesión
        $categoria = new Cancha();
        $datos = $categoria->buscar("1");
        require "vista/admin/cancha/listado.php";
    }

    public static function form_insertar(){
        require_once "auth.php"; // Verificación de sesión
        require "vista/admin/cancha/nuevo.php";
    }

    public static function insertar() {
        $_nombre = $_REQUEST['txtnombre'];
        $_precio = $_REQUEST['txtprecio'];
        $_tipo_deporte = $_REQUEST['txttipodeporte'];
        $_disponibilidad = $_REQUEST['txtdisponibilidad'];
        $_urlfoto = $_FILES['urlfoto']['name'];
    
        $dir_subida = 'public/img/instalaciones/';
        $fichero_subido = $dir_subida . basename($_FILES['urlfoto']['name']);
        move_uploaded_file($_FILES['urlfoto']['tmp_name'], $fichero_subido);
    
        $categoria = new Cancha();
        $data = "'".$_nombre."', '".$_precio."', '".$_urlfoto."', '".$_tipo_deporte."', '".$_disponibilidad."'";
        $accion = $categoria->insertar($data);
    
        if($accion) {
            $_SESSION['msg'] = "¡Cancha agregada exitosamente!";
            header('location:'.urlsite."?page=cancha");
        } else {
            $_SESSION['msg'] = "¡Error al agregar la cancha!";
            header('location:'.urlsite."?page=cancha&opcion=form_insertar");
        }
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    }

    public static function form_editar(){
        require_once "auth.php"; // Verificación de sesión
        // Obtener los tipos de deportes
        $tipoDeporte = new TipoDeporte();
        $tipos_deporte = $tipoDeporte->listar();
        $categoria = new Cancha();
        $datos = $categoria->buscar("cancha_id=".$_REQUEST['cancha_id']); // Use the correct request key
        require "vista/admin/cancha/editar.php";
    }
    

    public static function editar() {
        $_id = $_REQUEST['id'];
        $_nombre = $_REQUEST['nombre'];
        $_precio = $_REQUEST['precio'];
        $_tipo_deporte = $_REQUEST['tipodeporte'];
        $_disponibilidad = $_REQUEST['disponibilidad'];
        $_urlfoto = "";
    
        if (!empty($_FILES['urlfoto']['name'])) {
            $dir_subida = 'public/img/instalaciones/';
            $fichero_subido = $dir_subida . basename($_FILES['urlfoto']['name']);
            move_uploaded_file($_FILES['urlfoto']['tmp_name'], $fichero_subido);
            $_urlfoto = "urlfoto='" . $_FILES['urlfoto']['name'] . "', ";
        }
    
        $data = "nombre='" . $_nombre . "', precio='" . $_precio . "', " . $_urlfoto . "tipo_deporte_id='" . $_tipo_deporte . "', disponibilidad='" . $_disponibilidad . "'";
        $categoria = new Cancha();
        $accion = $categoria->actualizar($data, "cancha_id=" . $_id);
    
        if ($accion) {
            $_SESSION['msg'] = "¡Cancha actualizada exitosamente!";
            header('location:' . urlsite . "?page=cancha");
        } else {
            $_SESSION['msg'] = "¡Error al actualizar la cancha!";
            header('location:' . urlsite . "?page=cancha&opcion=form_editar");
        }
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    }
    public static function obtenerCanchaPorId() {
        if (isset($_POST['click_view_btn']) && $_POST['click_view_btn'] == true) {
            $cancha_id = $_POST['cancha_id'];
            $cancha = new Cancha();
            $datos = $cancha->buscar("cancha_id = " . $cancha_id);
        
            if (!empty($datos)) {
                // Devuelve los datos en formato JSON
                echo json_encode($datos[0]);
            } else {
                echo json_encode(['error' => 'No se encontraron datos']);
            }
        }
    }
    
    public static function eliminar() {
        $categoria = new Cancha();
        $accion = $categoria->eliminar("cancha_id=".$_REQUEST['cancha_id']);
        
        if ($accion) {
            $_SESSION['msg'] = "¡Cancha eliminada exitosamente!";
        } else {
            $_SESSION['msg1'] = "No se puede eliminar la cancha porque contiene reservas.";
        }
        
        header('location:' . urlsite . "?page=cancha");
        exit();
    }
    

    // Controlador para mostrar las canchas
    public static function mostrarCanchas() {
        $canchaModel = new Cancha();
        $canchas = $canchaModel->obtenerCanchas();
        require 'vista/front/instalaciones.php'; // Cargar la vista de instalaciones
    }

    // Controlador para mostrar los horarios de una cancha seleccionada
    public static function mostrarHorarios($cancha_id) {
        $canchaModel = new Cancha();
        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // Obtener la fecha desde la URL o la fecha actual
        
        // Obtener los horarios reservados de la base de datos
        $reservaModel = new ReservaModel();
        $horariosReservados = $reservaModel->obtenerHorariosReservados($cancha_id, $fecha);
    
        // Generar los horarios disponibles
        $horariosDisponibles = self::generarHorariosDisponibles($horariosReservados);
    
        // Pasar los datos a la vista
        require 'vista/front/reservaporhorarios.php';
    }
    
    private static function generarHorariosDisponibles($reservados) {
        $horarios_disponibles = [];
        $inicio_jornada = '14:00:00'; // Hora de inicio del día
        $fin_jornada = '23:59:00';   // Hora de fin del día
        
        // Convertir las horas a timestamps
        $inicio_jornada_ts = strtotime($inicio_jornada);
        $fin_jornada_ts = strtotime($fin_jornada);
        $hora_actual_ts = $inicio_jornada_ts;
    
        // Generar los horarios disponibles en bloques de 1 hora
        while ($hora_actual_ts < $fin_jornada_ts) {
            $proximo_horario_ts = $hora_actual_ts + 3600; // Bloques de 1 hora
            $reservado = false;
    
            // Verificar si el horario se solapa con los horarios reservados
            foreach ($reservados as $r) {
                $inicio_reservado_ts = strtotime($r['hora_inicio']);
                $fin_reservado_ts = strtotime($r['hora_fin']);
    
                // Si el horario se solapa, marcarlo como reservado
                if ($hora_actual_ts < $fin_reservado_ts && $proximo_horario_ts > $inicio_reservado_ts) {
                    // Si está cancelada, lo agregamos como disponible
                    if ($r['estado'] === 'CANCELADA') {
                        $horarios_disponibles[] = [
                            'inicio' => date("H:i", $hora_actual_ts),
                            'fin' => date("H:i", $proximo_horario_ts)
                        ];
                    }
                    $reservado = true;
                    break;
                }
            }
    
            // Si el horario no está reservado, lo agregamos a los disponibles
            if (!$reservado) {
                $horarios_disponibles[] = [
                    'inicio' => date("H:i", $hora_actual_ts),
                    'fin' => date("H:i", $proximo_horario_ts)
                ];
            }
    
            // Avanzamos a la siguiente hora
            $hora_actual_ts = $proximo_horario_ts;
        }
    
        return $horarios_disponibles;
    }
    
    


    public static function confirmarReserva() {
        // Validar los datos enviados por POST
        if (
            empty($_POST['fecha']) || 
            empty($_POST['hora_inicio']) || 
            empty($_POST['hora_fin']) || 
            empty($_POST['total']) || 
            empty($_POST['cancha_id']) || 
            empty($_POST['usuario_id'])  
        ) {
            $_SESSION['msg'] = "Faltan datos para completar la reserva.";
            header("Location: ../vista/error.php");
            exit();
        }
    
        // Asignar y limpiar los datos
        $fecha_reserva = htmlspecialchars($_POST['fecha']);
        $hora_inicio = htmlspecialchars($_POST['hora_inicio']);
        $hora_fin = htmlspecialchars($_POST['hora_fin']);
        $total = (float) htmlspecialchars($_POST['total']);
        $cancha_id = (int) htmlspecialchars($_POST['cancha_id']);
        $usuario_id = (int) htmlspecialchars($_POST['usuario_id']);
        $metodo_pago = htmlspecialchars($_POST['metodo_pago']); // Default: MERCADO PAGO
    

         // Generar un mp_transaccion_id único
        $mp_transaccion_id = 'TX' . uniqid();
        // Valores estáticos para el pago
        $detalle_estado = 'approved';
    
        // Inicializar los modelos
        $reservaModel = new ReservaModel();
        $pagoModel = new PagoModel();
    
        // Procesar la reserva
        $reserva_id = $reservaModel->confirmarReserva($usuario_id, $cancha_id, $hora_inicio, $hora_fin);
        
        if ($reserva_id) {
            // Registrar el pago
            $resultadoPago = $pagoModel->registrarPago($usuario_id, $reserva_id, $total, $metodo_pago, $mp_transaccion_id, $detalle_estado);
    
            if ($resultadoPago) {
                // Almacenar los detalles de la reserva en la sesión
                $_SESSION['reserva'] = [
                    'fecha' => $fecha_reserva,
                    'hora_inicio' => $hora_inicio,
                    'hora_fin' => $hora_fin,
                    'total' => $total,
                    'cancha_id' => $cancha_id,
                    'usuario_id' => $usuario_id
                ];
    
                // Redirigir a la confirmación
                header("Location: controlador/confirmacion.php");
                exit();
            } else {
                $_SESSION['msg'] = "Error al registrar el pago.";
                header("Location: ../vista/error.php");
                exit();
            }
        } else {
            $_SESSION['msg'] = "No se pudo confirmar la reserva.";
            header("Location: ../vista/error.php");
            exit();
        }
    }
    
    
    
    
    
    
    
    
    
    

}