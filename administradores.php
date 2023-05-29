<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
if(isset($_SESSION["idAdmin"])){
    /* header("Location: home"); */
}
?>
<?php

    //session_start();

    include './php/navAdmin.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
if (isset($_SESSION['idAdmin'])) {
    $consultaAdmin ="SELECT * FROM administradores WHERE idAdmin = '".$_SESSION['idAdmin']."'";
    $consultaAd=mysqli_query($conexion, $consultaAdmin);
    while ($listaAdmin=mysqli_fetch_array($consultaAd)) {
        $estadoAdmin = $listaAdmin['estadoAdmin'];
    }
}
if (@$estadoAdmin == 2) {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
}
    include './php/administradores.php';
?>