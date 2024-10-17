<?php
session_start();
require "modelo/tipoDeporte.php";

class TipoDeporteController{
    public static function listar(){
        require_once "auth.php"; // Verificación de sesión
        $categoria = new TipoDeporte();
        $datos = $categoria->buscar("1");
        require "vista/admin/tipodeporte/listado.php";
    }
    public static function form_insertar(){
        require_once "auth.php"; // Verificación de sesión
        require "vista/admin/tipodeporte/nuevo.php";
    }

    public static function insertar(){
        $_nombre = $_REQUEST['txtnombre'];


        $categoria = new TipoDeporte();
        $data = "'".$_nombre."'";
        $accion   = $categoria->insertar($data);
        if($accion) {
            $_SESSION['msg'] = "¡Deporte agregado exitosamente!";
            header('location:'.urlsite."?page=deportes");
        } else {
            $_SESSION['msg'] = "¡Error al agregar el deporte!";
            header('location:'.urlsite."?page=deportes&opcion=form_insertar");
        }
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    }

    public static function form_editar(){
        require_once "auth.php"; // Verificación de sesión
        // Obtener los tipos de deportes
        $tipoDeporte = new TipoDeporte();
        $tipos_deporte = $tipoDeporte->listar();
        $categoria = new TipoDeporte();
        $datos = $categoria->buscar("tipo_deporte_id=".$_REQUEST['tipo_deporte_id']); // Use the correct request key
        require "vista/admin/tipodeporte/editar.php";
    }
    

    public static function editar() {
        // Obtener los datos del formulario
        $_id = $_REQUEST['id'];
        $_nombre = $_REQUEST['nombre'];

    
        // Actualizar los datos de la tipodeporte
        $data = "nombre='" . $_nombre . "'";
        $categoria = new TipoDeporte();
        $accion = $categoria->actualizar($data, "tipo_deporte_id=" . $_id);
        if($accion) {
            $_SESSION['msg'] = "¡Deporte actualizado exitosamente!";
            header('location:'.urlsite."?page=deportes");
        } else {
            $_SESSION['msg'] = "¡Error al agregar el deporte!";
            header('location:'.urlsite."?page=deportes&opcion=form_insertar");
        }
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    }

    public static function obtenerDeportePorId() {
        if (isset($_POST['click_view_btn']) && $_POST['click_view_btn'] == true) {
            $deporte_id = $_POST['tipo_deporte_id'];
            $categoria = new TipoDeporte();
            $datos = $categoria->buscar("tipo_deporte_id = " . $deporte_id);
        
            if (!empty($datos)) {
                // Devuelve los datos en formato JSON
                echo json_encode($datos[0]);
            } else {
                echo json_encode(['error' => 'No se encontraron datos']);
            }
        }
    }
    
    

    public static function eliminar(){
        $categoria  = new TipoDeporte();
        $accion = $categoria->eliminar("tipo_deporte_id=".$_REQUEST['tipo_deporte_id']);
        if ($accion) {
            $_SESSION['msg'] = "¡Deporte eliminado exitosamente!";
        } else {
            $_SESSION['msg'] = "¡Error al eliminar el Deporte!";
        }
        
        header('location:' . urlsite . "?page=deportes");
        exit(); // Detener la ejecución del script después de la redirección
    }


}