<?php
include 'conexion_paciente.php';
$idpro = $_POST["idpro"];
$idadmin = $_POST["idadmin"];
date_default_timezone_set("America/Lima");
$fechaHoy = date('Y-m-d');

$sql = "UPDATE usuariospro SET estado='1', admin='$idadmin', enmu = '$fechaHoy' WHERE idpro = '" . $idpro . "'";
$stmt = mysqli_query($conexion, $sql);

$consulta = "SELECT * FROM usuariospro WHERE idpro = '" . $idpro . "' ";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    while ($row = $resultado->fetch_array()) {
        $idpro = $row['idpro'];
        $nombrespro = $row['nombrespro'];
        $apellidospro = $row['apellidospro'];
        $correopro = $row['correopro'];
        $sexopro = $row['sexopro'];
        if ($sexopro == "Femenino") {
            $estimado = "Estimada, Dra.";
        } else {
            $estimado = "Estimado, Dr.";
        }
    }
}

$titulo = "CUENTA PROFESIONAL APROBADA";
$mensaje = "
<html>
<head>
    <title>CUENTA PROFESIONAL APROBADA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>" . $estimado . " " . $nombrespro . " " . $apellidospro . ":<br><br>Hemos aprobado la creación de su cuenta The Med Universe | Profesional tras verificar que sus datos personales son exactos, actuales y verdaderos.<br><br>Ya puede empezar a generar ingresos con citas en sus tiempos libres. Ingrese a través del siguiente enlace: <a href='https://themeduniverse.com/loginpro'>https://themeduniverse.com/loginpro</a></p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
// mail($correopro, $titulo, $mensaje, $cabeceras);
echo json_encode(array(
    array('correo' => $correopro, 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));
