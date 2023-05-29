<?php

    $conexion = mysqli_connect("localhost", "themedun_admin", "lsBS&ffAB2022", "themedun_paciente");

    mysqli_query($conexion, "SET time_zone = 'America/Lima'");

    if($conexion === false){
        die("ERROR DE CONEXIÓN".mysqli_connect_error());
    }
    
?>