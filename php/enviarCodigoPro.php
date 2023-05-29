<?php
include 'conexion_paciente.php';
$respuesta=[];
//VALIDAR CREDENCIALES
$sql = "SELECT idpro, nombrespro, apellidospro, correopro, contraseñapro, nacimientopro, sexopro, especialidad, paispro, ciudadpro, idiomapro, colegiatura, enmu, precio, fototitulo, fotoperfilpro FROM usuariospro WHERE correopro = '".$_POST['correo']."' AND estado <> 'V'";
if($stmt = mysqli_prepare($conexion, $sql)){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $idpro, $nombrespro, $apellidospro, $correopro, $hashed_contraseña, $nacimientopro, $sexopro, $especialidad, $paispro, $ciudadpro, $idiomapro, $colegiatura, $enmu, $precio, $fototitulo, $fotoperfilpro);
            if(mysqli_stmt_fetch($stmt)){
                $id1 = $idpro;
                $nombres1 = $nombrespro;
                $apellidos1 = $apellidospro;
                $correo1 = $correopro;
                $token = bin2hex(random_bytes(10));
                $codigo = rand(100000,999999);
                if($sexopro == "Femenino"){
                    $estimado = "Estimada, Dra.";
                }else{
                    $estimado = "Estimado, Dr.";
                }
                $titulo = "RECUPERAR CUENTA";
                $mensaje = "
                <html>
                <head>
                    <title>RECUPERAR</title>
                </head>
                <body>
                    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
                    <p>".$estimado." ".$nombrespro." ".$apellidospro.":<br><br>Hemos recibido una solicitud para restablecer su contraseña de The Med Universe | Profesional. Para restablecer su contraseña, ingrese el siguiente código: ".$codigo."<br><br>Si no solicitó una nueva contraseña, háganoslo saber a través de nuestro Centro de Ayuda: <a href='https://www.themeduniverse.com/cayuda'>https://www.themeduniverse.com/cayuda</a></p>
                </body>
                </html>
                ";
                // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    
                // Cabeceras adicionales
                $cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
                if(mail($correo1, $titulo, $mensaje, $cabeceras)){
                    $subircon = mysqli_query($conexion, "UPDATE usuariospro SET tokenpro = '$token', codigopro = '$codigo' WHERE correopro = '$correo1'");
                }
                $respuesta+=['idpro'=>$id1];
                $respuesta+=['tokenpro'=>$token];
            }
        }else{
            $respuesta+=['correo'=>'Este correo no existe'];
        }
    }
}
echo json_encode($respuesta);
?>