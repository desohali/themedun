<?php
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navbarhtml.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
if (isset($_SESSION['id'])) {
    $consultaPaciente ="SELECT * FROM usuarios WHERE id = '".$_SESSION['id']."'";
    $consultaPac=mysqli_query($conexion, $consultaPaciente);
    while ($listaPaciente=mysqli_fetch_array($consultaPac)) {
        $estadoPaciente = $listaPaciente['estado'];
    }
}
if (@$estadoPaciente == 2) {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
}
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: loginpro"); */
    }
?>
<?php
if (explode("/", $_GET['view'])[1]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "home'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$medicosRegistrados='';
$consultavistas ="SELECT idpro FROM usuariospro WHERE idpro = '".$_GET['id']."' AND estado='1'";
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
            $profesion = "Médico";
            $boton = "https://www.cmp.org.pe/conoce-a-tu-medico/";
            if ($especialidad == "Psicología") {
                $profesion = "Psicólogo";
                $boton = "https://cpsp.pe/colegiados/";
                $verificar = "Comprobar Psicólogo";
            }
            $precio = $row['precio'];
            $fotoperfilpro = $row['fotoperfilpro'];
            if($sexopro == "Femenino"){
               $verificar = "Comprobar Médico";
	           $doctor = "Dra.";
	           if ($especialidad == "Psicología") {
                $verificar = "Comprobar Psicólogo";
               }
	       }else{
	           $verificar = "Comprobar Médico";
	           $doctor = "Dr.";
	           if ($especialidad == "Psicología") {
                $verificar = "Comprobar Psicólogo";
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
    //header("Location: ".$_ENV['APP_URL']."home");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "home'</script>";
}
?>
<?php
include './php/perfilpro-.php';
?>