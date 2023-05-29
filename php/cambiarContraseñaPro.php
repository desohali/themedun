<?php
include 'conexion_paciente.php';

$idprocon = $_POST['idpro'];
$tokenprocon = $_POST['token'];
$codigoprocon = $_POST['codigo'];
$newtoken = bin2hex(random_bytes(10));
$newcodigo = rand(100000,999999);

$contraprocon = trim($_POST["contraseña"]);
$contraprocon = password_hash($contraprocon, PASSWORD_DEFAULT);
//VALIDAR CREDENCIALES
$sql = mysqli_query($conexion, "UPDATE usuariospro SET contraseñapro = '$contraprocon', tokenpro = '$newtoken', codigopro = '$newcodigo' WHERE idpro = '$idprocon' and tokenpro = '$tokenprocon' and codigopro = '$codigoprocon'");
?>