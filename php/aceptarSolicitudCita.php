<?php
include 'conexion_paciente.php';
include '../configuracion.php';
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
        $del = "de la Dra.";
    }else{
        $del = "del Dr.";
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
        $estimado = "Estimada";
    }else{
        $estimado = "Estimado";
    }
  }
}

$query = "UPDATE citas SET title = 'Confirmada... Realiza el pago de tu cita lo antes posible.', ";
$query .= "leido='NO', leidopro='NO', color = '#00d418', fechanoti=now() WHERE idcita='" . $idcita . "'";
$result = mysqli_query($conexion, $query);

$titulo = "SOLICITUD DE CITA CONFIRMADA";
$mensaje = "
<html>
<head>
    <title>SOLICITUD DE CITA CONFIRMADA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimado.", ".$nombrespac." ".$apellidospac.":<br><br>Has recibido la confirmacion de tu solicitud de cita ".$del." ".$nombrespro." ".$apellidospro." para el ".$tiempoFinal.". Para pagar y programar la cita, ingresa a <a href='".$_ENV['APP_URL']."cita/".$idpro."'>".$_ENV['APP_URL']."cita/".$idpro."</a></p>
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
  array('correo' => $correopac, 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));


?> 
