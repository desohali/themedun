<?php
include 'conexion_paciente.php';
$idpro = $_POST["idpro"];
$nombresyape = $apellidosyape = $yape = "";

$nombresyape = ucwords(trim($_POST["nombresyape"]));
$apellidosyape = ucwords(trim($_POST["apellidosyape"]));
$yape = trim($_POST["yape"]);

$sql = "UPDATE cuentabancaria SET nombresyape='$nombresyape', apellidosyape='$apellidosyape', yape='$yape' WHERE idpro = '".$idpro."'";

$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 