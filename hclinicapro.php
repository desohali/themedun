<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
?>
<?php

    include './php/navbarhtmlpro.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
if (isset($_SESSION['idpro'])) {
    $consultaMedico ="SELECT * FROM usuariospro WHERE idpro = '".$_SESSION['idpro']."'";
    $consultaMed=mysqli_query($conexion, $consultaMedico);
    while ($listaMedico=mysqli_fetch_array($consultaMed)) {
        $estadoMedico = $listaMedico['estado'];
    }
}
if (@$estadoMedico != 1) {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfilpro/" . $_SESSION['idpro'] . "'</script>";
}
include './php/conexion_paciente.php';
if (explode("/", $_GET['view'])[1]=='' || explode("/", $_GET['view'])[2]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "hpacientes/" . $_SESSION['idpro'] . "'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$_GET['idHistoria'] = explode("/", $_GET['view'])[2];
$hcpaciente='';
$consultavistas ="SELECT distinct idpx, (select idhc from hclinica where idhc='".$_GET['idHistoria']."') as idHistoria, (select idpay from citas where idpay='".$_GET['idHistoria']."' AND (asistenciapac = 'No Asistió' OR asistencia = 'No Asistió')) as idInasistencia FROM hclinica WHERE idmed = '".$_SESSION['idpro']."' AND idpx = '".$_GET['id']."' AND tiempoenf = ''";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $hcpaciente = $lista['idpx'];
    $idHistoria = $lista['idHistoria'];
    $idInasistencia = $lista['idInasistencia'];
    if (@$_GET['idHistoria'] == @$idInasistencia) {
        $url = "<script>window.location.href='" . $_ENV['APP_URL'];
        echo $url . "hpacientes/" . $_SESSION['idpro'] . "'</script>";
    }
}
if (isset($_GET['id']) && @$_GET['id']==@$hcpaciente && @$_GET['idHistoria']==@$idHistoria){
    $consulta = "SELECT * FROM usuarios WHERE id = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $id = $row['id'];
            $nombres = $row['nombres'];
            $apellidos = $row['apellidos'];
            $nacimiento = $row['nacimiento'];
            $sexo = $row['sexo'];
            $pais = $row['pais'];
            $ciudad = $row['ciudad'];
            $fotoperfil = $row['fotoperfil'];
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
include './php/hclinicapro.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."hpacientes/".$_SESSION['idpro']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "hpacientes/" . $_SESSION['idpro'] . "'</script>";
}
?>