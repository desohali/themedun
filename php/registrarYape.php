<?php
include 'conexion_paciente.php';
$idpro = $_POST["idpro"];
$nombres = $_POST["nombres"];
$nombresyape = $apellidosyape = $yape = "";

$nombresyape = ucwords(trim($_POST["nombresyape"]));
$apellidosyape = ucwords(trim($_POST["apellidosyape"]));
$yape = trim($_POST["yape"]);

if($nombres!=''){
    $sql = "UPDATE cuentabancaria SET nombresyape='$nombresyape', apellidosyape='$apellidosyape', yape='$yape' WHERE idpro = '".$idpro."'";
}else{
    $sql = "INSERT INTO cuentabancaria (idpro, nombresyape, apellidosyape, yape) VALUES ('$idpro', '$nombresyape', '$apellidosyape', '$yape')";
}

$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 