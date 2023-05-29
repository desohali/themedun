<?php
include 'conexion_paciente.php';
$idadmin = $_POST["idadmin"];
$nombres = $apellidos = $documento = $numdoc = $nacimiento = $domicilio = $nombrebanco = $tipocuenta = $codigocuenta = "";
$nombres = ucwords(trim($_POST["nombres"]));
$apellidos = ucwords(trim($_POST["apellidos"]));
$documento = trim($_POST["documento"]);
$numdoc = trim($_POST["numdoc"]);
$nacimiento = trim($_POST["nacimiento"]);
$domicilio = ucwords(trim($_POST["domicilio"]));
$nombrebanco = trim($_POST["nombrebanco"]);
$tipocuenta = trim($_POST["tipocuenta"]);
$codigocuenta = trim($_POST["codigocuenta"]);

$sql = "INSERT INTO cuentabancariaadmin (idadmin, nombrestitular, apellidostitular, tipodoctitular, numdoctitular, nacimientotitular, direcciontitular, nombrebanco, tipocuenta, codigocuentainterbancaria) VALUES ('$idadmin', '$nombres', '$apellidos', '$documento', '$numdoc', '$nacimiento', '$domicilio', '$nombrebanco', '$tipocuenta', '$codigocuenta')";
$stmt = mysqli_query($conexion, $sql);
echo "Se registro con exito";
?> 
