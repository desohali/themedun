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

    include './php/navbarhtmlpro.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: loginpro"); */
    }
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_GET['id'] == @$_SESSION['idpro']){
    $consulta = "SELECT * FROM usuariospro WHERE idpro = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $idpro = $row['idpro'];
            $nombrespro = $row['nombrespro'];
            $apellidospro = $row['apellidospro'];
            $nacimientopro = $row['nacimientopro'];
            $sexopro = $row['sexopro'];
            $paispro = $row['paispro'];
            $ciudadpro = $row['ciudadpro'];
            $idiomapro = $row['idiomapro'];
            $enmu = $row['enmu'];
            $colegiatura = $row['colegiatura'];
            $especialidad = $row['especialidad'];
            $precio = $row['precio'];
            $estadoMedico = $row['estado'];
            $fotoperfilpro = $row['fotoperfilpro']; 
            if($sexopro == "Femenino"){
                $doctor = "Dra.";
            }else{
                $doctor = "Dr.";
            }
            if (@$estadoMedico != 1) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfilpro/" . $_SESSION['idpro'] . "'</script>";
            }
include './php/historialpro.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."historialpro/".$_SESSION['idpro']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "historialpro/" . $_SESSION['idpro'] . "'</script>";
}
?>