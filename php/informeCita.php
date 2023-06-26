<?php
include 'conexion_paciente.php';

$idcita = $_POST["idcita"];
$idPro = $_POST["idPro"];
$idadmin = $_POST["idadmin"];
$indicaciones = $_POST["indicaciones"];
$asistencia = $_POST["asistencia"];
$abonado = "";
if($asistencia == "No asistió"){
    $abonado = "F";
    $notificacion = "NO";
}else{
    $abonado = "NO";
    $notificacion = "SI";
}
$asistenciapac = ucfirst($_POST["asistenciapac"]);

$query = "UPDATE citas SET asistencia = '$asistencia', asistenciapac = '$asistenciapac', abonado = '$abonado', leidoabono = '$notificacion', fechaabono = NOW() WHERE idcita='" . $idcita . "'";
$result = mysqli_query($conexion, $query);

$query2 = "SELECT COUNT(*) as conteo FROM citas WHERE idupro='" . $idPro . "' AND abonado='F' ";
$result2 = mysqli_query($conexion, $query2);
while ($lista2=mysqli_fetch_array($result2)) {
    $conteo = $lista2['conteo'];
}

if($conteo>='2'){
    $query3 = "UPDATE usuariospro SET estado = '2', admin = '0', indicaciones = '$indicaciones' WHERE idpro='" . $idPro . "'";
    $result3 = mysqli_query($conexion, $query3);
}

echo "Se aceptó con éxito";
?> 
