<?php

include '../conexion_paciente.php';
$token = $_POST['token'];
$codigo = rand(100000, 999999);
$correo1 = $_POST['correo1'];
$subircon = mysqli_query($conexion, "UPDATE usuarios SET token = '$token', codigo = '$codigo' WHERE correo = '$correo1'");

echo "se actualizó usuarios";
