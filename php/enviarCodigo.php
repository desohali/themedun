<?php
include 'conexion_paciente.php';
$respuesta=[];
//VALIDAR CREDENCIALES
$sql = "SELECT id, nombres, apellidos, correo, contraseña, nacimiento, sexo, pais, ciudad, enmu, fotoperfil FROM usuarios WHERE correo = '".$_POST['correo']."' AND estado <> 'V'";
if($stmt = mysqli_prepare($conexion, $sql)){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $id, $nombres, $apellidos, $correo, $hashed_contraseña, $nacimiento, $sexo, $pais, $ciudad, $enmu, $fotoperfil);
            if(mysqli_stmt_fetch($stmt)){
                $id1 = $id;
                $nombres1 = $nombres;
                $apellidos1 = $apellidos;
                $correo1 = $correo;
                $token = bin2hex(random_bytes(10));
                $codigo = rand(100000,999999);
                if($sexo == "Femenino"){
                    $estimado = "Estimada";
                }else{
                    $estimado = "Estimado";
                }
                $titulo = "RECUPERAR CUENTA";
                $mensaje = "
                <html>
                <head>
                    <title>RECUPERAR</title>
                </head>
                <body>
                    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
                    <p>".$estimado.", ".$nombres." ".$apellidos.":<br><br>Hemos recibido una solicitud para restablecer tu contraseña de The Med Universe | Paciente. Para restablecer tu contraseña, ingresa el siguiente código: ".$codigo."<br><br>Si no solicitaste una nueva contraseña, háznoslo saber a través de nuestro Centro de Ayuda: <a href='https://www.themeduniverse.com/cayuda'>https://www.themeduniverse.com/cayuda</a></p>
                </body>
                </html>
                ";
                // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    
                // Cabeceras adicionales
                $cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
                if(mail($correo1, $titulo, $mensaje, $cabeceras)){
                    $subircon = mysqli_query($conexion, "UPDATE usuarios SET token = '$token', codigo = '$codigo' WHERE correo = '$correo1'");
                }
                $respuesta+=['id'=>$id1];
                $respuesta+=['token'=>$token];
            }
        }else{
            $respuesta+=['correo'=>'Este correo no existe'];
        }
    }
}
echo json_encode($respuesta);
?>