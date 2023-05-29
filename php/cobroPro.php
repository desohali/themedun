<?php
include 'conexion_paciente.php';

$idcita = $_POST["numbercita"];
$idPro = $_POST["idPro"];

$query = "UPDATE citas SET abonado = 'P', leidoabono='NO', fechaabono=NOW() WHERE idcita='" . $idcita . "'";
$result = mysqli_query($conexion, $query);

$query2 = "SELECT COUNT(*) as conteo FROM citas WHERE idupro='" . $idPro . "' AND abonado='F' ";
$result2 = mysqli_query($conexion, $query2);
while ($lista2=mysqli_fetch_array($result2)) {
    $conteo = $lista2['conteo'];
}

if($conteo<'2'){
    $query3 = "UPDATE usuariospro SET estado = '1', admin = '0' WHERE idpro='" . $idPro . "'";
    $result3 = mysqli_query($conexion, $query3);
}

echo "Se aceptó con éxito";
?> 
