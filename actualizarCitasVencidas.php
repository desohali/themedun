<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include './php/conexion_paciente.php';
include './configuracion.php';

date_default_timezone_set('America/Lima');
$date= date('Y-m-j H:i:s'); 
$newDate = strtotime ( '+1 hour' , strtotime ($date) ) ;
$newDate = date ( 'Y-m-j H:i:s' , $newDate); 
// VERIFICAR Y ACTUALIZAR CITAS VENCIDAS
$count = "SELECT * FROM citas WHERE ";
$count .=  "(SELECT STR_TO_DATE(start, '%Y-%m-%d %T') < '" . $newDate . "') AND title NOT IN ('" . $_ENV['CITA_PROGRAMADA'] . "', '" . $_ENV['CITA_VENCIDA'] . "') AND estado <> 'RECHAZADA' AND estado <> 'CANCELADA' AND estado <> 'ELIMINADA'";
$resultCitasVencidas = mysqli_query($conexion, $count) or die(mysqli_error($conexion));

if ($resultCitasVencidas->num_rows) {
  $query = "UPDATE citas SET color='#ff0000', leido='NO', leidopro='NO', fechanoti=now(), title='" . $_ENV['CITA_VENCIDA'] . "'";
  $query .= " WHERE (SELECT STR_TO_DATE(start, '%Y-%m-%d %T') < '" . $newDate . "') AND title NOT IN ('" . $_ENV['CITA_PROGRAMADA'] . "', '" . $_ENV['CITA_VENCIDA'] . "') AND estado <> 'RECHAZADA' AND estado <> 'CANCELADA' AND estado <> 'ELIMINADA'";
  $result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
}

/* // VERIFICAR Y NOTIFICAR CITAS PROGRAMADAS FALTANDO 10 MINUTOS
$query = "SELECT start FROM citas ";
$query .= "WHERE idupro=$idupro ";
$query .= "and estado='ACTIVO' ";
$query .= "and title='Programada... Únete con el link en la fecha y hora correspondientes.' ";
$query .= "and now() BETWEEN (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -11 MINUTE)) ";
$query .= "AND (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -9 MINUTE))";

$resultCitasDentroDe10minutos = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

$data = array(
  'citasVencidas'=>$resultCitasVencidas->num_rows,
  'citasDentroDe10Minutos'=>$resultCitasDentroDe10minutos->num_rows
);
$jsonString = json_encode($data); */

echo "data: {$resultCitasVencidas->num_rows}\n\n";
echo "retry: 60000\n"; // set time execute
flush();
