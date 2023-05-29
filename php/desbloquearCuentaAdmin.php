<?php
include 'conexion_paciente.php';
$id = $_POST["id"];
$idadmin = $_POST["idadmin"];
date_default_timezone_set("America/Lima");
$fechaHoy = date('Y-m-d');

$sql = "UPDATE administradores SET estadoAdmin='1', adminAdmin='$idadmin' WHERE idAdmin = '".$id."'";
$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 