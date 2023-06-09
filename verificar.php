<?php
include './php/conexion_paciente.php';
include './configuracion.php';
include './php/verificar.php';
include './php/footer.php';
include './seguridad.php';

$seguridad = new Seguridad($conexion, "");
$seguridad->verificarSiYaEstoyLogeado();

$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/verificar') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "verificar'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Verificar Correo - The Med Universe | Paciente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/404.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body>
    <main>
      <div class="ctn-error">
        <div id="img-cayuda">
            <img src="<?php echo $_ENV['APP_URL'];?>images/med-isfrgb.png">
        </div>
        <div class="globoerror">
          <div class="boxerror">
            <?php echo verificacion();?>
          </div>
          <a id="avolver" href='<?php echo $_ENV['APP_URL'];?>'>Iniciar sesión</a>
        </div>
      </div>
    </main>
</body>
<?php echo footermed();?>
</html>