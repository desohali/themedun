<?php

    $conexion = mysqli_connect("localhost", "root", 'tiburon2$ABC', "themedun_paciente");

    mysqli_query($conexion, "SET time_zone = '-5:00'");

    if($conexion === false){
        die("ERROR DE CONEXIÓN".mysqli_connect_error());
    }
    
?>