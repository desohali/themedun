<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
if(isset($_SESSION["id"])){
    /* header("Location: home"); */
}
?>
<?php

    //session_start();

    include './php/navAdmin.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: loginpro"); */
    }
if (isset($_SESSION['idAdmin']) && $_SESSION['idAdmin']!='1') {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
}
if (explode("/", $_GET['view'])[1]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pagosadmin'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$administradoresRegistrados='';
$consultavistas ="SELECT idAdmin FROM administradores WHERE idAdmin = '".$_GET['id']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $administradoresRegistrados = $lista['idAdmin'];
}
if (isset($_GET['id']) && @$_GET['id']==@$administradoresRegistrados){
    $consulta = "SELECT * FROM administradores WHERE idAdmin = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $idpro = $row['idAdmin'];
            $nombrespro = $row['nombresAdmin'];
            $apellidospro = $row['apellidosAdmin'];
            $nacimientopro = $row['nacimientoAdmin'];
            $sexopro = $row['sexoAdmin'];
            $paispro = $row['paisAdmin'];
            $ciudadpro = $row['ciudadAdmin'];
include './php/abonosadmin.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."pagosadmin");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pagosadmin'</script>";
}
?>