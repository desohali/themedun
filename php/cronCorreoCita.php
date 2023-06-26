<?php
include 'conexion_paciente.php';

$query = "SELECT *, id as idu,";
$query .= "(select idpro from usuariospro where idpro=idupro) as idMed,";
$query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
$query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
$query .= "(select correopro from usuariospro where idpro=idupro) as correoMedico,";
$query .= "(select sexopro from usuariospro where idpro=idupro) as sexopro,";
$query .= "(select estado from usuariospro where idpro=idupro) as estadopro,";
$query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
$query .= "(select id from usuarios where id=idu) as idPaciente,";
$query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
$query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente,";
$query .= "(select sexo from usuarios where id=idu) as sexoPaciente,";
$query .= "(select correo from usuarios where id=idu) as correoPaciente ";
$query .= "FROM citas WHERE ";
$query .= "estado='ACTIVO' ";
$query .= "and title='Programada... Únete con el link en la fecha y hora correspondientes.' ";
$query .= "and now() BETWEEN (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -11 MINUTE)) ";
$query .= "AND (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -9 MINUTE))";

$result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

$arrayJson = [];
while ($obj = $result->fetch_object()) {
        $idPac = $obj->idPaciente;
        $nombres = $obj->nombresPaciente;
        $apellidos = $obj->apellidosPaciente;
        $sexo = $obj->sexoPaciente;
        $estimado = '';
        if($sexo == "Femenino"){
            $estimado = "Estimada";
            $elola = "la paciente";
        }else{
            $estimado = "Estimado";
            $elola = "el paciente";
        }
        $idMed = $obj->idMed;
        $nombrespro = $obj->nombresMedico;
        $apellidospro = $obj->apellidosMedico;
        $sexopro = $obj->sexoMedico;
        $estimadopro = '';
        if($sexopro == "Femenino"){
            $estimadopro = "Estimada, Dra.";
            $elolapro = "la Dra.";
            $lopro = "la";
            $acompañar = "acompañarla";
        }else{
            $estimadopro = "Estimado, Dr.";
            $elolapro = "el Dr.";
            $acompañar = "acompañarlo";
        }
        $cita = $obj->start;
        $link = $obj->ubicacion;

        $fechapago = $cita;
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


//
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: citas@themeduniverse.com' . "\r\n";


// titulos
$tituloMedico = "SU CITA INICIARA EN 10 MINUTOS";
$tituloPaciente = "TU CITA INICIARA EN 10 MINUTOS";

// mensajes
$mensajeMedico = "
<html>
<head>
    <title>SU CITA INICIARA EN 10 MINUTOS</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimadopro." ".$nombrespro." ".$apellidospro.":<br><br>Le recordamos que tiene una cita programada con ".$elola." ".$nombres." ".$apellidos." para el ".$tiempoFinal.". Puede ir ingresando con este link <a href='".$link."'>".$link."</a>, uno de nuestros asistentes ".$lopro." estará esperando para ".$acompañar.".<br><br>Encontrará mayor información de su cita en <a href='https://www.themeduniverse.com/horario/".$idMed."'>https://www.themeduniverse.com/horario/".$idMed."</a>.</p>
</body>
</html>
";
$mensajePaciente = "
<html>
<head>
    <title>TU CITA INICIARA EN 10 MINUTOS</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimado.", ".$nombres." ".$apellidos.":<br><br>Te recordamos que tienes una cita programada con ".$elolapro." ".$nombrespro." ".$apellidospro." para el ".$tiempoFinal.". Puedes ir ingresando con este link <a href='".$link."'>".$link."</a>, uno de nuestros asistentes te estará esperando para acompañarte.<br><br>Encontrarás mayor información de tu cita en <a href='https://www.themeduniverse.com/agenda/".$idPac."'>https://www.themeduniverse.com/agenda/".$idPac."</a>.</p>
</body>
</html>
";

  // mail medico
  mail($obj->correoMedico, $tituloMedico, $mensajeMedico, $cabeceras);
  // mail paciente
  mail($obj->correoPaciente, $tituloPaciente, $mensajePaciente, $cabeceras);
}
?>