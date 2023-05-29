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
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pagospro'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$medicosRegistrados='';
$consultavistas ="SELECT idpro FROM usuariospro WHERE idpro = '".$_GET['id']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $medicosRegistrados = $lista['idpro'];
}
if (isset($_GET['id']) && @$_GET['id']==@$medicosRegistrados){
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
            $fotoperfilpro = $row['fotoperfilpro']; 
            if($sexopro == "Femenino"){
                $doc = "a la Dra.";
                $doctor = "Dra.";
            }else{
                $doc = "al Dr.";
                $doctor = "Dr.";
            }
include './php/abonospro.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."pagospro");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pagospro'</script>";
}
?>