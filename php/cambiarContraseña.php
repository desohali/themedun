<?php
include 'conexion_paciente.php';

$idcon = $_POST['id'];
$tokencon = $_POST['token'];
$codigocon = $_POST['codigo'];
$newtoken = bin2hex(random_bytes(10));
$newcodigo = rand(100000,999999);

$contracon = trim($_POST["contraseña"]);
$contracon = password_hash($contracon, PASSWORD_DEFAULT);
//VALIDAR CREDENCIALES
$sql = mysqli_query($conexion, "UPDATE usuarios SET contraseña = '$contracon', token = '$newtoken', codigo = '$newcodigo' WHERE id = '$idcon' and token = '$tokencon' and codigo = '$codigocon'");
?>