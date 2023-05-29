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
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: loginpro"); */
    }
?>
<?php
if (explode("/", $_GET['view'])[1]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "activos'</script>";
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
            $profesion = "Medicina";
            $boton = "https://www.cmp.org.pe/conoce-a-tu-medico/";
            if ($especialidad == "Psicología") {
                $profesion = "Psicología";
                $boton = "https://cpsp.pe/colegiados/";
                $verificar = "Verificar Psicólogo";
            }
            $precio = $row['precio'];
            $fotoperfilpro = $row['fotoperfilpro'];
            $estado = $row['estado'];
            $indicaciones = $row['indicaciones'];
            $indica = preg_replace("/<br \/>/" , "" , $indicaciones);
            $fototitulo = $row['fototitulo'];
            $fotocolegiatura = $row['fotocolegiatura'];
            $fotodocumento = $row['fotodocumento'];
            if($sexopro == "Femenino"){
	           $verificar = "Verificar Médica";
	           $doctor = "Dra.";
	           if ($especialidad == "Psicología") {
                $verificar = "Verificar Psicóloga";
               }
	       }else{
	           $verificar = "Verificar Médico";
	           $doctor = "Dr.";
	           if ($especialidad == "Psicología") {
                $verificar = "Verificar Psicólogo";
               }
	       }
            $timestampNac = strtotime($nacimientopro); 
            $newDateNac = date("d/m/Y", $timestampNac );
            $timestampEnmu = strtotime($enmu); 
            $newDateEnmu = date("d/m/Y", $timestampEnmu );
        }
    }
    $consulta2 = "SELECT COUNT(title) FROM citas WHERE idupro = '".$_GET['id']."' AND idpay <> '0' ";
    $resultado2 = mysqli_query($conexion, $consulta2);
    if ($resultado2) {
        while ($row2 = $resultado2->fetch_array()){
            $nrocitas = $row2['COUNT(title)'];
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."activos");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "activos'</script>";
}
?>
<?php
include './php/perfilrevision.php';
?>