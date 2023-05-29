<?php
include 'conexion_paciente.php';

$idcita = $_POST["idcita"];
$idadmin = $_POST["idadmin"];
$idPro = $_POST["idPro"];
$idPac = $_POST["idPac"];

$query = "UPDATE citas SET idadmin = '$idadmin'";
$query .= "WHERE idcita='" . $idcita . "'";
$result = mysqli_query($conexion, $query);

$sql17 = mysqli_query($conexion, "INSERT INTO pagosadmin (idAdmin, idCita) VALUES ('$idadmin', '$idcita')");

echo "Se aceptó con éxito";
?> 
