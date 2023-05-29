<?php
    
    include 'conexion_paciente.php';

    $nombres = $apellidos = $correo = $contraseña = $nacimiento = $sexo = $pais = $ciudad = $enmu = $fotoperfil = "";
    $token = bin2hex(random_bytes(10));
    $codigo = rand(100000,999999);
    date_default_timezone_set("America/Lima");
        $fecha = date('Y-m-d');

        $nombres = ucwords(trim($_POST["nombres"]));
        $apellidos = ucwords(trim($_POST["apellidos"]));
        $correo = trim($_POST["correo"]);
        $contraseña = trim($_POST["contraseña"]);
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
        $nacimiento = trim($_POST["nacimiento"]);
        $sexo = trim($_POST["sexo"]);
        $pais = trim($_POST["pais"]);
        $ciudad = ucwords(trim($_POST["ciudad"]));
        //COMPROBANDO LOS ERRORES DE INPUT ANTES DE GUARDARLOS EN LA BASE DE DATOS
        $sql = "INSERT INTO administradores (nombresAdmin, apellidosAdmin, correoAdmin, contraseñaAdmin, tokenAdmin, codigoAdmin, nacimientoAdmin, sexoAdmin, paisAdmin, ciudadAdmin, enmuAdmin, fotoperfilAdmin) VALUES ('$nombres', '$apellidos', '$correo', '$contraseña', '$token', '$codigo', '$nacimiento', '$sexo', '$pais', '$ciudad', '$fecha', 'defect.jpg')";
        $stmt = mysqli_query($conexion, $sql);
?>
