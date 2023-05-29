<?php
    
    include 'conexion_paciente.php';

    $fototitulo = $fotocolegiatura = $fotodocumento = $fotoperfilpro = "";
    $tokenpro = bin2hex(random_bytes(10));
    $codigopro = rand(100000,999999);
    date_default_timezone_set("America/Lima");
    $fecha = date('Y-m-d');
    $currentDateUrl = new DateTime();
    $currentDateUrl->setTimezone(new DateTimeZone('America/Lima'));
    $currentDateUrl = (strtotime($currentDateUrl->format('Y-m-d H:i:s')) * 1000);

        $nombrespro = ucwords(trim($_POST["nombres"]));
        $apellidospro = ucwords(trim($_POST["apellidos"]));
        $correopro = trim($_POST["correo"]);
        $contraseñapro = trim($_POST["contraseña"]);
        $contraseñapro = password_hash($contraseñapro, PASSWORD_DEFAULT);
        $nacimientopro = trim($_POST["nacimiento"]);
        $sexopro = trim($_POST["sexo"]);
        $paispro = trim($_POST["pais"]);
        $ciudadpro = ucwords(trim($_POST["ciudad"]));
        $idiomapro = trim($_POST["idioma"]);
        $especialidad = trim($_POST["especialidad"]);
        $colegiatura = trim($_POST["colegiatura"]);
        $precio = trim($_POST["precio"]);
        $indicaciones = "Aún no hay observaciones.";
        $estado = "V";
        if($sexopro == "Femenino"){
            $estimado = "Estimada, Dra.";
        }else{
            $estimado = "Estimado, Dr.";
        }
        //VALIDANDO INPUT DE TITULO
        $nombrefoto1 = $_FILES['fototitulo']['name'];
        $ruta1 = $_FILES['fototitulo']['tmp_name'];
        if($nombrefoto1!='' && $ruta1!=''){
            $fototitulo=$correopro.''.$nombrefoto1;
            $destino1 = "../titulos/".$fototitulo;
        }
        //VALIDANDO INPUT DE COLEGIATURA
        $nombrefoto2 = $_FILES['fotocolegiatura']['name'];
        $ruta2 = $_FILES['fotocolegiatura']['tmp_name'];
        if($nombrefoto2!='' && $ruta2!=''){
            $fotocolegiatura=$correopro.''.$nombrefoto2;
            $destino2 = "../colegiaturas/".$fotocolegiatura;
        }
        //VALIDANDO INPUT DE DOCUMENTO
        $nombrefoto3 = $_FILES['fotodocumento']['name'];
        $ruta3 = $_FILES['fotodocumento']['tmp_name'];
        if($nombrefoto3!='' && $ruta3!=''){
            $fotodocumento=$correopro.''.$nombrefoto3;
            $destino3 = "../documentos/".$fotodocumento;
        }
        //COMPROBANDO LOS ERRORES DE INPUT ANTES DE GUARDARLOS EN LA BASE DE DATOS
        $sql = "INSERT INTO usuariospro (nombrespro, apellidospro, correopro, contraseñapro, tokenpro, codigopro, nacimientopro, sexopro, especialidad, paispro, ciudadpro, idiomapro, colegiatura, enmu, precio, fototitulo, fotocolegiatura, fotodocumento, fotoperfilpro, estado, indicaciones) VALUES ('$nombrespro', '$apellidospro', '$correopro', '$contraseñapro', '$tokenpro', '$codigopro', '$nacimientopro', '$sexopro', '$especialidad', '$paispro', '$ciudadpro', '$idiomapro', '$colegiatura', '$fecha', '$precio', '$fototitulo', '$fotocolegiatura', '$fotodocumento', 'defect.jpg', '$estado', '$indicaciones')";
        if(is_uploaded_file($ruta1)){
            copy($ruta1, $destino1);
        }
        if(is_uploaded_file($ruta2)){
            copy($ruta2, $destino2);
        }
        if(is_uploaded_file($ruta3)){
            copy($ruta3, $destino3);
        }
        $stmt = mysqli_query($conexion, $sql);

$consulta = "SELECT idpro FROM usuariospro WHERE correopro = '" . $correopro . "' ";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    while ($row = $resultado->fetch_array()) {
        $idpro = $row['idpro'];
    }
}
            
$titulo = "VERIFICACION DE CUENTA";
$mensaje = "
<html>
<head>
    <title>VERIFICACION DE CUENTA</title>
</head>
<body>
    <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
    <p>".$estimado." ".$nombrespro." ".$apellidospro.":<br><br>Hemos recibido una solicitud para registrar una cuenta The Med Universe | Profesional con esta dirección de correo electrónico. Para completar la creación de su cuenta, ingrese al siguiente enlace de verificación: <a href='https://www.themeduniverse.com/verificarpro/".$idpro."/".$tokenpro."/".$codigopro."/".$currentDateUrl."'>https://www.themeduniverse.com/verificar/".$idpro."/".$tokenpro."/".$codigopro."/".$currentDateUrl."</a><br><br>El enlace de verificación expirará en 24 horas. Si no solicitó una cuenta nueva, háganoslo saber a través de nuestro centro de ayuda: <a href='https://www.themeduniverse.com/cayuda'>https://www.themeduniverse.com/cayuda</a></p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
mail($correopro, $titulo, $mensaje, $cabeceras);
        
?>
