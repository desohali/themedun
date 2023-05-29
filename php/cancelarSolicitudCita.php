
<?php
include 'conexion_paciente.php';

$idcita = $_POST["idcita"];

$query = "UPDATE citas SET estado = 'CANCELADA', leido='NO', leidopro='NO', fechanoti=now() WHERE idcita='". $idcita . "'";
$result = mysqli_query($conexion, $query);

echo "Se eliminó con éxito";

?> 
