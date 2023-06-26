<?php
include 'conexion_paciente.php';
include '../configuracion.php';
$ID_PROFESIONAL = $_POST["idpro"];
$id = $_POST["id"];
$start = $_POST['fullDate'];
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

$consultapro = "SELECT * FROM usuariospro WHERE idpro = '".$ID_PROFESIONAL."' ";
$resultadopro = mysqli_query($conexion, $consultapro);
if ($resultadopro) {
  while ($rowpro = $resultadopro->fetch_array()){
    $idpro = $rowpro['idpro'];
    $nombrespro = $rowpro['nombrespro'];
    $apellidospro = $rowpro['apellidospro'];
    $correopro = $rowpro['correopro'];
    $sexopro = $rowpro['sexopro'];
    $especialidad = $rowpro['especialidad'];
    $precio = $rowpro['precio'];
    $fotoperfilpro = $rowpro['fotoperfilpro'];
    if($sexopro == "Femenino"){
        $estimado = "Estimada, Dra.";
    }else{
        $estimado = "Estimado, Dr.";
    }
  }
}

$consultapac = "SELECT * FROM usuarios WHERE id = '".$id."' ";
$resultadopac = mysqli_query($conexion, $consultapac);
if ($resultadopac) {
  while ($rowpac = $resultadopac->fetch_array()){
    $nombrespac = $rowpac['nombres'];
    $apellidospac = $rowpac['apellidos'];
    $sexopac = $rowpac['sexo'];
    if($sexopac == "Femenino"){
        $del = "de la";
    }else{
        $del = "del";
    }
  }
}

$query = "INSERT INTO citas (id, idupro, title, localizacion, color, textColor, start, ubicacion, fechanoti) ";
$query .= "VALUES ('$id', '$idpro', 'Enviada... Espera la confirmación de tu solicitud de cita.', '$precio', '#FFC107', 'white', '$start', '', now())";
$sql6 = mysqli_query($conexion, $query);

$titulo = "SOLICITUD DE CITA RECIBIDA";
$mensaje = "
<html>
<head>
    <title>SOLICITUD DE CITA RECIBIDA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimado." ".$nombrespro." ".$apellidospro.":<br><br>Ha recibido una solicitud de cita ".$del." paciente ".$nombrespac." ".$apellidospac." para el ".$tiempoFinal.". Para confirmar la solicitud de cita, ingrese a <a href='".$_ENV['APP_URL']."horario/".$idpro."'>".$_ENV['APP_URL']."horario/".$idpro."</a>.</p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: citas@themeduniverse.com' . "\r\n";
// mail($correopro, $titulo, $mensaje, $cabeceras);
echo json_encode(array(
  array('correo' => $correopro, 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));

?> 
