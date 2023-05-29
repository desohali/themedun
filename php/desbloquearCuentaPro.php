<?php
include 'conexion_paciente.php';
$idpro = $_POST["idpro"];
$idadmin = $_POST["idadmin"];
date_default_timezone_set("America/Lima");
$fechaHoy = date('Y-m-d');

$sql = "UPDATE usuariospro SET estado='1', admin='$idadmin' WHERE idpro = '".$idpro."'";
$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 