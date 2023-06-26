<?php
include 'conexion_paciente.php';

$idcita = $_POST["idcita"];

$consultacita = "SELECT * FROM citas WHERE idcita = '".$idcita."' ";
$resultadocita = mysqli_query($conexion, $consultacita);
if ($resultadocita) {
  while ($rowcita = $resultadocita->fetch_array()){
    $idpac = $rowcita['id'];
    $idpro = $rowcita['idupro'];
    $start = $rowcita['start'];
    $fechapago = $start;
    list($fecha, $hora) = explode(" ", $fechapago);
    $horafinal = explode(":00", $hora);
    $timestamp = strtotime($fecha);
    $newFecha = date("d/m/Y", $timestamp);
    if($horafinal[0]=='01'){
      $enlace=" a la ";
    }else{
      $enlace=" a las ";
    }
    $tiempoFinal=$newFecha . $enlace . $horafinal[0] . ":00";
  }
}

$consultapro = "SELECT * FROM usuariospro WHERE idpro = '".$idpro."' ";
$resultadopro = mysqli_query($conexion, $consultapro);
if ($resultadopro) {
  while ($rowpro = $resultadopro->fetch_array()){
    $nombrespro = $rowpro['nombrespro'];
    $apellidospro = $rowpro['apellidospro'];
    $correopro = $rowpro['correopro'];
    $sexopro = $rowpro['sexopro'];
    if($sexopro == "Femenino"){
        $estimado = "Estimada, Dra.";
    }else{
        $estimado = "Estimado, Dr.";
    }
  }
}

$consultapac = "SELECT * FROM usuarios WHERE id = '".$idpac."' ";
$resultadopac = mysqli_query($conexion, $consultapac);
if ($resultadopac) {
  while ($rowpac = $resultadopac->fetch_array()){
    $nombrespac = $rowpac['nombres'];
    $apellidospac = $rowpac['apellidos'];
    $correopac = $rowpac['correo'];
    $sexopac = $rowpac['sexo'];
    if($sexopac == "Femenino"){
        $del = "de la";
    }else{
        $del = "del";
    }
  }
}

$query = "UPDATE citas SET estado = 'CANCELADA', leido='NO', leidopro='NO', fechanoti=now() WHERE idcita='". $idcita . "'";
$result = mysqli_query($conexion, $query);

$titulo = "SOLICITUD DE CITA CANCELADA";
$mensaje = "
<html>
<head>
    <title>SOLICITUD DE CITA CANCELADA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimado." ".$nombrespro." ".$apellidospro.":<br><br>Ha recibido la cancelación de una solicitud de cita ".$del." paciente ".$nombrespac." ".$apellidospac." para el ".$tiempoFinal.".</p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: citas@themeduniverse.com' . "\r\n";
// mail($correopac, $titulo, $mensaje, $cabeceras);
echo json_encode(array(
  array('correo' => $correopro, 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));

?> 
