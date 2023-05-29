<?php
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navbarhtml.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
?>
<?php
$_GET['id'] = explode("/", $_GET['view'])[1];
$_GET['idHistoria'] = explode("/", $_GET['view'])[2];
if (@$_GET['idHistoria'] == '') {
    $consulta = "SELECT * FROM usuarios WHERE id = '".$_SESSION['id']."' ";
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
            $enmu = $row['enmu'];
            $estadoPaciente = $row['estado'];
            $fotoperfil = $row['fotoperfil'];
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
            if (@$estadoPaciente == 2) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
            }?>
<?php
include './php/hclinicados.php';
?>
<?php 
        }
    }
    exit;
}
            
$consultavistas ="SELECT idhc, (select idpay from citas where idpay='".$_GET['idHistoria']."' AND (asistenciapac = 'No Asistió' OR asistencia = 'No Asistió')) as idInasistencia FROM hclinica WHERE idhc='".$_GET['idHistoria']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $idHistoria = $lista['idhc'];
    $idInasistencia = $lista['idInasistencia'];
    if (@$_GET['idHistoria'] == @$idInasistencia) {
        $url = "<script>window.location.href='" . $_ENV['APP_URL'];
        echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
    }
}
if (isset($_GET['id']) && @$_GET['id'] == @$_SESSION['id'] && isset($_GET['idHistoria']) && @$_GET['idHistoria'] == @$idHistoria){
    $consulta = "SELECT * FROM usuarios WHERE id = '".$_SESSION['id']."' ";
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
            $enmu = $row['enmu'];
            $estadoPaciente = $row['estado'];
            $fotoperfil = $row['fotoperfil'];
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
            if (@$estadoPaciente == 2) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
            }?>
<?php
include './php/hclinica.php';
?>
<?php 
        }
    }
}else{
    if ($seguridad->verificarInicioDeSesionPaciente()) {
        //header("Location: ".$_ENV['APP_URL']."hclinica/".$_SESSION['id']);
        echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfil/" . $_SESSION['id'] . "'</script>";
    }
}
?>