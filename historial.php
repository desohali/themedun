<?php
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navbarhtml.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    if(!isset($_SESSION["loggedin"]))
    {
        /* header("Location: login"); */
    }
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_SESSION['id']) && @$_GET['id'] == @$_SESSION['id']){
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
            if (@$estadoPaciente == 2) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
            }
include './php/historial.php';
        }
    }
}else{
    if ($seguridad->verificarInicioDeSesionPaciente()) {
        //header("Location: ".$_ENV['APP_URL']."historial/".$_SESSION['id']);
        echo "<script>window.location.href='" . $_ENV['APP_URL'] . "historial/" . $_SESSION['id'] . "'</script>";
    }
}
?>