<?php
if (isset(explode("/", $_GET['view'])[1]) && isset(explode("/", $_GET['view'])[2]) && isset(explode("/", $_GET['view'])[3]) && isset(explode("/", $_GET['view'])[4])) {
	$_GET['idpro'] = explode("/", $_GET['view'])[1];
	$_GET['tokenpro'] = explode("/", $_GET['view'])[2];
	$_GET['codigopro'] = explode("/", $_GET['view'])[3];
	$_GET['tiempopro'] = explode("/", $_GET['view'])[4];

} else{
    echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "loginpro');</script>";
}

$currentDateVerify = new DateTime();
$currentDateVerify = (strtotime($currentDateVerify->format('Y-m-d H:i:s')) * 1000);

$diferenciaDeMilisegundos = ($currentDateVerify - $_GET['tiempopro']);
$segundosTrans = ($diferenciaDeMilisegundos / 1000);
$minutosTrans = ($segundosTrans / 60);
$horasTrans = ($minutosTrans / 60);

    $consulta = "SELECT * FROM usuariospro WHERE idpro = '" . $_GET['idpro'] . "' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()) {
            $sexopro = $row['sexopro'];
            if($sexopro == "Femenino"){
                $elOlaMed = "de la Dra.";
            }else{
                $elOlaMed = "del Dr.";
            }
            $nombrespro = $row['nombrespro'];
            $apellidospro = $row['apellidospro'];
            $tokenpro = $row['tokenpro'];
            $codigopro = $row['codigopro'];
            $estado = $row['estado'];
            $correopro = $row['correopro'];
            
            $sql4 = mysqli_query($conexion, "DELETE FROM usuariospro WHERE correopro = '" . $correopro . "' AND idpro <> '" . $_GET['idpro'] . "' ");
        }
    } else{
        echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "loginpro');</script>";
    }
    
if($estado=='V' || $estado=='1' || $estado=='0' || $estado=='2'){
if ( $horasTrans >= 24 && $estado=='V') {
  $sql3 = mysqli_query($conexion, "DELETE FROM usuariospro WHERE idpro = '" . $_GET['idpro'] . "' ");
  function verificacion(){
    ?>
        <h1>Verificación Fallida</h1>
        <p>El enlace de verificación ha vencido. Regístrese nuevamente para iniciar sesión.</p>
    <?php
  }
}else if ( $horasTrans >= 24 && $estado!='V') {
  function verificacion(){
    ?>
    <h1>Verificación Exitosa</h1>
    <p>Su correo fue verificado exitosamente. Inicie sesión para ingresar.</p>
    <?php
    }
}else{
    if ($estado=='V'){
        if($tokenpro == $_GET['tokenpro'] && $codigopro == $_GET['codigopro']){
            $newtoken = bin2hex(random_bytes(10));
            $newcodigo = rand(100000,999999);
    
            $sql = "UPDATE usuariospro SET estado='0', tokenpro= '".$newtoken."', codigopro= '".$newcodigo."' WHERE idpro = '".$_GET['idpro']."'";
            $stmt = mysqli_query($conexion, $sql);
            
$titulo = "CUENTA PROFESIONAL POR REVISAR";
$mensaje = "
<html>
<head>
    <title>CUENTA PROFESIONAL POR REVISAR</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>Estimado, Gerente General Leandro Santiago Bernal Saavedra:<br><br>Tenemos una cuenta profesional pendiente por revisar " . $elOlaMed . " " . $nombrespro . " " . $apellidospro . ". Asegúrese de revisar que los datos personales sean exactos, actuales y veraces a través del siguiente enlace: <a href='https://themeduniverse.com/inactivos'>https://themeduniverse.com/inactivos</a></p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
mail('leandrobernal@themeduniverse.com', $titulo, $mensaje, $cabeceras);
            
            function verificacion(){
            ?>
            <h1>Verificación Exitosa</h1>
            <p>Su correo fue verificado exitosamente. Inicie sesión para ingresar.</p>
            <?php
            }
        }else{
            function verificacion(){
            ?>
                <h1>Verificación Fallida</h1>
                <p>El enlace de verificación es incorrecto. Asegúrese de ingresar al enlace que llegó a su correo.</p>
            <?php
            }
        }
    }else{
            function verificacion(){
            ?>
            <h1>Verificación Exitosa</h1>
            <p>Su correo fue verificado exitosamente. Inicie sesión para ingresar.</p>
            <?php
            }
    }
}
}else{
    function verificacion(){
    ?>
        <h1>Verificación Fallida</h1>
        <p>El enlace de verificación es incorrecto. Regístrese nuevamente para iniciar sesión.</p>
    <?php
    }
}
?>