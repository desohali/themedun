<?php
include 'conexion_paciente.php';

$idcita = $_POST["numbercita"];
$query = "UPDATE citas SET abonado = 'SI', leidoabono='NO', fechaabono=NOW() WHERE idcita='" . $idcita . "'";
$result = mysqli_query($conexion, $query);

echo "Se aceptó con éxito";
?> 
