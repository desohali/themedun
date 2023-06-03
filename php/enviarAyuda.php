<?php
$nombres = ucfirst(trim($_POST["nombres"]));
$apellidos = ucfirst(trim($_POST["apellidos"]));
$correo = trim($_POST["correo"]);
$telefono = trim($_POST["telefono"]);
$pais = trim($_POST["pais"]);
$ciudad = ucwords(trim($_POST["ciudad"]));
$cuenta = nl2br(ucfirst(trim($_POST["cuenta"])));

$titulo = "CONSULTA DE AYUDA";
$mensaje = "
<html>
<head>
    <title>CONSULTA DE AYUDA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p><span style='font-weight:bolder'>Nombres y apellidos: </span>" . $nombres . " " . $apellidos . "<br><br><span style='font-weight:bolder'>Correo electrónico: </span>" . $correo . "<br><br><span style='font-weight:bolder'>N° de celular: </span>" . $telefono . "<br><br><span style='font-weight:bolder'>País, ciudad: </span>" . $pais . ", " . $ciudad . "<br><br><span style='font-weight:bolder'>Relato: </span>" . $cuenta . "</p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
// Cabeceras adicionales
$cabeceras .= 'From: ' . $correo . "\r\n";
$correofrom = 'ayuda@themeduniverse.com';
// mail($correofrom, $titulo, $mensaje, $cabeceras);

echo json_encode(array(
    array('correo' => 'themeduniverse@gmail.com', 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));
