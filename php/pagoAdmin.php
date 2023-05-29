<?php
include 'conexion_paciente.php';

$idpago = $_POST["numbercita"];
$query = "UPDATE pagosadmin SET abonado = 'SI' WHERE idpago='" . $idpago . "'";
$result = mysqli_query($conexion, $query);

echo "Se aceptó con éxito";
?> 
