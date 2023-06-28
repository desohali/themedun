<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();

include './php/conexion_paciente.php';
include './seguridad.php';
include './php/footer.php';
include './configuracion.php';

$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/404') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "404'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Work Universe Platforms S.A.C."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Página No Encontrada - The Med Universe</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/404.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body>
<script>
  function isLogin() {
    window.history.back();
  }
</script>
    <main>
      <div class="ctn-error">
        <div id="img-cayuda">
            <img src="<?php echo $_ENV['APP_URL'];?>images/med-isfrgb.png">
        </div>
        <div class="globoerror">
          <div class="boxerror">
            <h1>PÁGINA NO ENCONTRADA</h1>
            <p>Parece que ha habido un error con la página que estabas buscando. Es posible que la entrada haya sido eliminada o que la dirección no exista.</p>
          </div>
          <a id="avolver" href='javascript:void();' onclick='isLogin()'>Volver</a>
        </div>
      </div>
    </main>
</body>
<?php echo footermed();?>
</html>