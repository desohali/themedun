<?php

$_ENV['APP_URL'] = $_SERVER['SERVER_NAME'] == "localhost" ?
  "http://localhost/themeduni/" :
  "http://129.151.118.100/";

// ESTADOS CITAS
$_ENV['CITA_ENVIADA'] = "Enviada... Espera la confirmación de tu solicitud de cita.";
$_ENV['CITA_CONFIRMADA'] = "Confirmada... Realiza el pago de tu cita lo antes posible.";
$_ENV['CITA_PROGRAMADA'] = "Programada... Únete con el link en la fecha y hora correspondientes.";
$_ENV['CITA_VENCIDA'] = "Vencida... La fecha de tu cita ha expirado.";

?>