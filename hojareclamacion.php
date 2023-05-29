<?php 
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
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

if (explode("/", $_GET['view'])[1]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "libroreclamaciones'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$reclamosRegistrados='';
$consultavistas ="SELECT idrec FROM lreclamos WHERE idrec = '".$_GET['id']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $reclamosRegistrados = $lista['idrec'];
}
if (isset($_GET['id']) && @$_GET['id']==@$reclamosRegistrados){
    $consulta = "SELECT * FROM lreclamos WHERE idrec = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
        $idrec = $row["idrec"];
        $codigo = $row["codigo"];
        $nombres = $row["nombres"];
        $apellidos = $row["apellidos"];
        $documento = $row["documento"];
        $numdoc =  $row["numdoc"];
        $domicilio = $row["domicilio"];
        $telefono = $row["telefono"];
        $correo = $row["correo"];
        $nombrestut = $row["nombrestut"];
        $apellidostut = $row["apellidostut"];
        $documentotut = $row["documentotut"];
        $numdoctut = $row["numdoctut"];
        $domiciliotut = $row["domiciliotut"];
        $telefonotut = $row["telefonotut"];
        $correotut = $row["correotut"];
        $tipobien = $row["tipobien"];
        $monto = $row["monto"];
        $numcita = $row["numcita"];
        $descripcion = $row["descripcion"];
        $reclamo = $row["reclamo"];
        $evidencia = $row["evidencia"];
        $detalle = $row["detalle"];
        $pedido = $row["pedido"];
        $fecha = $row["fecha"];
        $acciones = $row["acciones"];
        $acci = preg_replace("/<br \/>/" , "" , $acciones);
include './php/hojareclamacion.php';
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."libroreclamaciones");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "libroreclamaciones'</script>";
}
?>