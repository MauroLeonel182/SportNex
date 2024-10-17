<?php
session_start();

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
        $categoria  = new Cancha();
        $accion = $categoria->eliminar("cancha_id=" . $_REQUEST['cancha_id']);
        
        if ($accion) {
            $_SESSION['msg'] = "¡Cancha eliminada exitosamente!";
        } else {
            $_SESSION['msg'] = "¡Error al eliminar la cancha!";
        }
        
        header('location:' . urlsite . "?page=cancha");
        exit(); // Detener la ejecución del script después de la redirección
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
        $horariosReservados = $canchaModel->obtenerHorariosReservados($cancha_id);
        $horariosDisponibles = self::generarHorariosDisponibles($horariosReservados);
        require 'vista/front/reservaporhorarios.php'; // Cargar la vista de horarios
    }

    private static function generarHorariosDisponibles($reservados) {
        $horarios_disponibles = [];
        $inicio_jornada = '08:00:00';
        $fin_jornada = '23:59:00';
        
        // Convertir a timestamps
        $inicio_jornada_ts = strtotime($inicio_jornada);
        $fin_jornada_ts = strtotime($fin_jornada);
        $hora_actual_ts = $inicio_jornada_ts;
    
        while ($hora_actual_ts < $fin_jornada_ts) {
            $proximo_horario_ts = $hora_actual_ts + 3600; // Bloques de 1 hora
            $reservado = false;
    
            foreach ($reservados as $r) {
                $inicio_reservado_ts = strtotime($r['inicio']);
                $fin_reservado_ts = strtotime($r['fin']);
                if ($hora_actual_ts < $fin_reservado_ts && $proximo_horario_ts > $inicio_reservado_ts) {
                    $reservado = true;
                    break;
                }
            }
    
            if (!$reservado) {
                $horarios_disponibles[] = ['inicio' => date("H:i:s", $hora_actual_ts), 'fin' => date("H:i:s", $proximo_horario_ts)];
            }
    
            $hora_actual_ts = $proximo_horario_ts;
        }
    
        return $horarios_disponibles;
    }

}