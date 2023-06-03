<?php

include '../conexion_paciente.php';
$token = $_POST['token'];
$codigo = rand(100000, 999999);
$correo1 = $_POST['correo1'];
$subircon = mysqli_query($conexion, "UPDATE administradores SET tokenAdmin = '$token', codigoAdmin = '$codigo' WHERE correoAdmin = '$correo1'");

echo "se actualizó administradores";
