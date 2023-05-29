<?php
include 'conexion_paciente.php';
$id = $_POST["id"];
$idadmin = $_POST["idadmin"];
date_default_timezone_set("America/Lima");
$fechaHoy = date('Y-m-d');

$sql = "UPDATE usuarios SET estado='1', admin='$idadmin' WHERE id = '".$id."'";
$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 