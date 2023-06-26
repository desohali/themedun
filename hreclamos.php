<?php
    include './php/footer.php';
    include './php/conexion_paciente.php';
    include './configuracion.php';
    include './seguridad.php';
    
$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/hreclamos') {
    //echo "<script>window.location.href='" . $_ENV['APP_URL'] . "hreclamos'</script>";
}

$_GET['codigo'] = explode("/", $_GET['view'])[1];
$reclamosRegistrados='';
$consultavistas ="SELECT codigo FROM lreclamos WHERE codigo = '".$_GET['codigo']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $reclamosRegistrados = $lista['codigo'];
}
if (isset($_GET['codigo']) && @$_GET['codigo']==@$reclamosRegistrados){
    $consulta = "SELECT * FROM lreclamos WHERE codigo = '".$_GET['codigo']."' ";
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
include './php/hreclamos.php';
        }
    }
}else{
    header("Location: ".$_ENV['APP_URL']."lreclamos");
}
?>