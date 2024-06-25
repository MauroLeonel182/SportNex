<?php
    require "config.php";
    require "modelo/conexion.php";
    $db= new Conexion();
    $db->conectar();
    require "vista/layouts/header.php";
    require "vista/layouts/content.php";
    require "vista/layouts/footer.php";
