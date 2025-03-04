<?php
session_start();
class AdminController {
    public static function index() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista\admin\layuot\main.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
    public static function cancha() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista/admin/layuot/cancha/listado.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
    public static function deporte() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista/admin/layuot/tipodeporte/listado.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
    public static function usuarios() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista/admin/layuot/usuarios/listado.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
    public static function vista() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista/admin/layuot/vista.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
    public static function diario() {
        // Verificar si es administrador
        if (isset($_SESSION['usuario']) && $_SESSION['rol'] == 'administrador') {
            require "vista/admin/layuot/diario.php";
        } else {
            header("Location: " . urlsite . "?page=login");
        }
    }
}
