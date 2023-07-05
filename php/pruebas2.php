<?php
/* $currentDateUrl = new DateTime();
$currentDateUrl->setTimezone(new DateTimeZone('America/Lima'));

$currentDateUrl = (strtotime($currentDateUrl->format('Y-m-d H:i:s')) * 1000);
// pasamos la fecha actual al link atraves de la url
// https://link/link/$currentDate


$currentDateVerify = new DateTime();
$currentDateVerify->setTimezone(new DateTimeZone('America/Lima'));

$currentDateVerify = (strtotime($currentDateVerify->format('Y-m-d H:i:s')) * 1000);

$diferenciaDeMilisegundos = ($currentDateVerify - $currentDateUrl);// currentDateUrl GET

$segundosTrans = ($diferenciaDeMilisegundos / 1000);
$minutosTrans = ($segundosTrans / 60);

if ( $minutosTrans >= 1) {
  // SQL
  // ECHO "ESTE LINK A VENCIDO !!"
} */
include 'conexion_paciente.php';

try {
  $sql = "INSERT INTO test(nombre) VALUES('themedun')";
  $result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

  echo "success";
} catch (\Throwable $th) {
  echo "error";
}
/* try {
  $idupro = 1;
$estadoLeido = "SI";

$query = "UPDATE citas SET leidopro='" . $estadoLeido . "' ";
$query .= "WHERE idupro=" . $idupro;

$result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

// TAMBIEN ACTUALIZAMOS LAS VALORACIONES LEIDAS
$queryValoraciones = "UPDATE valoraciones SET leido='" . $estadoLeido . "' ";
$queryValoraciones .= "WHERE idupro=" . $idupro;
$result = mysqli_query($conexion, $queryValoraciones) or die(mysqli_error($conexion));

// ACTUALIZAMOS LOS ABONOS(PAGOS) LEIDOS DEL MEDICO
$updateAbonos = "UPDATE citas SET leidoabono='" . $estadoLeido . "' ";
$updateAbonos .= "WHERE idupro=" . $idupro;
$result = mysqli_query($conexion, $updateAbonos) or die(mysqli_error($conexion));

// ACTUALIZAMOS LOS COMENTARIOS LEIDOS
$query = "SELECT * FROM valoraciones WHERE idupro=" . $idupro . " AND comentarios REGEXP '[(leido)\\\S{1,}:\\\S{1,}NO]'";
$result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

$comentariosAActualizar = [];

$arrayJson = [];
while ($obj = $result->fetch_object()) {

  $obj->comentarios = json_decode($obj->comentarios, false, 512, JSON_UNESCAPED_UNICODE);

  for ($i = 0; $i < count($obj->comentarios); $i++) {
    $comentario = json_encode(preg_replace('/(leido)\S{1,}(NO)/', "leido\":\"SI", $obj->comentarios[$i]), JSON_UNESCAPED_UNICODE);
    if ($i == 0) {
      array_push($comentariosAActualizar, "UPDATE valoraciones set comentarios=JSON_INSERT('[]', '$[0]', $comentario ) WHERE id=" . $obj->id);
    } else {
      array_push($comentariosAActualizar, "UPDATE valoraciones set comentarios=JSON_ARRAY_INSERT(comentarios, '$[$i]', $comentario ) WHERE id=" . $obj->id);
    }
  }
}

for ($i = 0; $i < count($comentariosAActualizar); $i++) {
  $result = mysqli_query($conexion, $comentariosAActualizar[$i]);
}

echo "Actualizaciones :" . count($comentariosAActualizar).$result->num_rows;
} catch (\Throwable $th) {
  //throw $th;

  echo "error";
} */
