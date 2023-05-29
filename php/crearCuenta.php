<?php
    
include 'conexion_paciente.php';

$nombres = $apellidos = $correo = $contraseña = $nacimiento = $sexo = $pais = $ciudad = $enmu = $fotoperfil = $estimado = "";
$token = bin2hex(random_bytes(10));
$codigo = rand(100000,999999);
date_default_timezone_set("America/Lima");
$fecha = date('Y-m-d');
$currentDateUrl = new DateTime();
$currentDateUrl->setTimezone(new DateTimeZone('America/Lima'));
$currentDateUrl = (strtotime($currentDateUrl->format('Y-m-d H:i:s')) * 1000);

$nombres = ucwords(trim($_POST["nombres"]));
$apellidos = ucwords(trim($_POST["apellidos"]));
$correo = trim($_POST["correo"]);
$contraseña = trim($_POST["contraseña"]);
$contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
$nacimiento = trim($_POST["nacimiento"]);
$sexo = trim($_POST["sexo"]);
$pais = trim($_POST["pais"]);
$ciudad = ucwords(trim($_POST["ciudad"]));
if($sexo == "Femenino"){
    $estimado = "Estimada";
}else{
    $estimado = "Estimado";
}

//COMPROBANDO LOS ERRORES DE INPUT ANTES DE GUARDARLOS EN LA BASE DE DATOS
$sql = "INSERT INTO usuarios (nombres, apellidos, correo, contraseña, token, codigo, nacimiento, sexo, pais, ciudad, enmu, fotoperfil) VALUES ('$nombres', '$apellidos', '$correo', '$contraseña', '$token', '$codigo', '$nacimiento', '$sexo', '$pais', '$ciudad', '$fecha', 'defect.jpg')";
$stmt = mysqli_query($conexion, $sql);


$consulta = "SELECT id FROM usuarios WHERE correo = '" . $correo . "' ";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    while ($row = $resultado->fetch_array()) {
        $id = $row['id'];
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
    <p>".$estimado.", ".$nombres." ".$apellidos.":<br><br>Hemos recibido una solicitud para registrar una cuenta The Med Universe | Paciente con esta dirección de correo electrónico. Para completar la creación de tu cuenta, ingresa al siguiente enlace de verificación: <a href='https://www.themeduniverse.com/verificar/".$id."/".$token."/".$codigo."/".$currentDateUrl."'>https://www.themeduniverse.com/verificar/".$id."/".$token."/".$codigo."/".$currentDateUrl."</a><br><br>El enlace de verificación expirará en 24 horas. Si no solicitaste una cuenta nueva, háznoslo saber a través de nuestro centro de ayuda: <a href='https://www.themeduniverse.com/cayuda'>https://www.themeduniverse.com/cayuda</a>.</p>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: seguridad@themeduniverse.com' . "\r\n";
mail($correo, $titulo, $mensaje, $cabeceras);
        
?>
