<?php
    // conexion antigua al mysql "localhost", "root", 'tiburon2$ABC', "themedun_paciente"
    $conexion = mysqli_connect("144.22.51.20", "themedun", 'tiburon2$ABC', "themedun_paciente");

    mysqli_query($conexion, "SET time_zone = '-5:00'");

    if($conexion === false){
        die("ERROR DE CONEXIÓN".mysqli_connect_error());
    }
    
?>