<?php

$smtpServer = 'smtp-relay.sendinblue.com';
$smtpPort = 587;
$smtpUsername = 'hameralbarran@gmail.com';
$smtpPassword = 'Izc7QKXsM2rH5CxW';
$senderEmail = 'hameralbarran@gmail.com';
$recipientEmail = 'syshoteles@gmail.com';
$subject = 'Asunto del correo';
$message = 'Contenido del correo';

// Configuración de los encabezados del correo
$headers = "From: $senderEmail\r\n";
$headers .= "Reply-To: $senderEmail\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";

// Configuración de la autenticación SMTP
$smtpAuth = base64_encode("$smtpUsername:$smtpPassword");

// Configuración de las opciones del envío SMTP
$smtpOptions = "-f$senderEmail -t$recipientEmail -oi -v";

// Configuración de los parámetros SMTP
ini_set('SMTP', $smtpServer);
ini_set('smtp_port', $smtpPort);
ini_set('username', $smtpUsername);
ini_set('password', $smtpPassword);
ini_set('auth_username', $smtpUsername);
ini_set('auth_password', $smtpPassword);

// Configuración de la autenticación SMTP para la función mail()
stream_context_set_option(
    stream_context_get_default(),
    'ssl',
    'verify_peer',
    false
);

// Configuración del servidor SMTP y envío del correo
if (mail($recipientEmail, $subject, $message, $headers, $smtpOptions)) {
  echo "Correo enviado con éxito.";
  # code...
} else {
  echo "Error.";
  # code...
}






/* $titulo = "VERIFICACION DE CUENTA";
$mensaje = "
<html>
<head>
  <title>VERIFICACION DE CUENTA</title>
</head>
<body>
  <h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
</body>
</html>
";
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: syshoteles@gmail.com' . "\r\n";

if (mail("hameralbarran@gmail.com", $titulo, $mensaje, $cabeceras)) {
  echo "success";
} else {
  echo "error";
} */
