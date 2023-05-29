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
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: loginpro"); */
    }
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_SESSION['idAdmin'] == @$_GET['id']){
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
            $enmu = $row['enmuAdmin'];
            $estadoAdmin = $row['estadoAdmin'];
            $fotoperfilpro = $row['fotoperfilAdmin'];
            if (@$estadoAdmin == 2) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
            }
include './php/historialadmin.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."historialadmin/".$_SESSION['idAdmin']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "historialadmin/" . $_SESSION['idAdmin'] . "'</script>";
}
?>