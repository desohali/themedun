<?php
include 'conexion_paciente.php';
$id = $_POST["id"];
$idadmin = $_POST["idadmin"];
$indicaciones = nl2br(ucfirst($_POST["observaciones"]));
date_default_timezone_set("America/Lima");
$fechaHoy = date('Y-m-d');

$sql = "UPDATE usuarios SET estado='2', admin='$idadmin', indicaciones='$indicaciones' WHERE id = '".$id."'";
$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 