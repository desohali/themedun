<?php
include 'conexion_paciente.php';

$nombres = $apellidos = $documento = $numdoc = $domicilio = $telefono = $correo = $nombrestut = $apellidostut = $documentotut = $numdoctut = $domiciliotut = $telefonotut = $correotut = $tipobien = $monto = $numcita = $descripcion = $reclamo = $evidencia = $detalle = $pedido = $fecha = $acciones = "";
$nombres = ucwords(trim($_POST["nombres"]));
$apellidos = ucwords(trim($_POST["apellidos"]));
$documento = trim($_POST["documento"]);
$numdoc = ucfirst(trim($_POST["numdoc"]));
$domicilio = ucwords(trim($_POST["domicilio"]));
$telefono = ucfirst(trim($_POST["telefono"]));
$correo = trim($_POST["correo"]);
$nombrestut = ucwords(trim($_POST["nombrestut"]));
$apellidostut = ucwords(trim($_POST["apellidostut"]));
$documentotut = trim($_POST["documentotut"]);
$numdoctut = ucfirst(trim($_POST["numdoctut"]));
$domiciliotut = ucwords(trim($_POST["domiciliotut"]));
$telefonotut = ucfirst(trim($_POST["telefonotut"]));
$correotut = trim($_POST["correotut"]);
$tipobien = trim($_POST["tipobien"]);
$monto = ucfirst(trim($_POST["monto"]));
$numcita = ucfirst(trim($_POST["numcita"]));
$descripcion = nl2br(ucfirst(trim($_POST["descripcion"])));
$reclamo = trim($_POST["reclamo"]);
$detalle = nl2br(ucfirst(trim($_POST["detalle"])));
$pedido = nl2br(ucfirst(trim($_POST["pedido"])));
$acciones = "Aún no hay observaciones ni acciones.";
$codigonew = rand(100000, 999999);
$codigofin = $codigonew . '' . $numdoc;
date_default_timezone_set("America/Lima");
$fecha = date('d/m/Y');
$nombrefoto1 = $_FILES['evidencia']['name'];
$ruta1 = $_FILES['evidencia']['tmp_name'];
if ($nombrefoto1 != '' && $ruta1 != '') {
    $evidencia = $codigofin . $nombrefoto1;
    $destino1 = "../evidencias/" . $evidencia;
}

$titulo = "CONSTANCIA DE RECLAMACIÓN";
$mensaje = "
<html>
<head>
    <title>CONSTANCIA DE RECLAMACIÓN</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>Estimado(a), " . $nombres . " " . $apellidos . ":<br><br>Hemos registrado su hoja de reclamación en nuestro Libro de Reclamaciones - The Med Universe. Para revisar el estado de su reclamación, ingrese el siguiente código: " . $codigofin . "<br><br>The Med Universe dará respuesta a la reclamación en un plazo no mayor a quince (15) días hábiles.</p>
</body>
</html>
";

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: reclamos@themeduniverse.com' . "\r\n";
$sql = "INSERT INTO lreclamos (codigo, nombres, apellidos, documento, numdoc, domicilio, telefono, correo, nombrestut, apellidostut, documentotut, numdoctut, domiciliotut, telefonotut, correotut, tipobien, monto, numcita, descripcion, reclamo, evidencia, detalle, pedido, fecha, acciones) VALUES ('$codigofin', '$nombres', '$apellidos', '$documento', '$numdoc', '$domicilio', '$telefono', '$correo', '$nombrestut', '$apellidostut', '$documentotut', '$numdoctut', '$domiciliotut', '$telefonotut', '$correotut', '$tipobien', '$monto', '$numcita', '$descripcion', '$reclamo', '$evidencia', '$detalle', '$pedido', '$fecha', '$acciones')";
    if(is_uploaded_file($ruta1)){
        copy($ruta1, $destino1);
    }
    $stmt = mysqli_query($conexion, $sql);

echo json_encode(array(
    array('correo' => $correo, 'titulo' => $titulo,  'mensaje' => $mensaje, 'cabeceras' => $cabeceras)
));
