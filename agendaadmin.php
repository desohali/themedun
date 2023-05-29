<?php
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navAdmin.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    if(!isset($_SESSION["loggedin"]))
    {
        header("Location: loginadmin");
    }
?>
<?php
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_SESSION['idAdmin']) && @$_GET['id'] == @$_SESSION['idAdmin']){
    $consulta = "SELECT * FROM administradores WHERE idAdmin = '".$_SESSION['idAdmin']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $id = $row['idAdmin'];
            $nombres = $row['nombresAdmin'];
            $apellidos = $row['apellidosAdmin'];
            $nacimiento = $row['nacimientoAdmin'];
            $sexo = $row['sexoAdmin'];
            $pais = $row['paisAdmin'];
            $ciudad = $row['ciudadAdmin'];
            $enmu = $row['enmuAdmin'];
            $estadoAdmin = $row['estadoAdmin'];
            $fotoperfil = $row['fotoperfilAdmin'];
            if (@$estadoAdmin == 2) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
            }?>
<?php
include './php/agendaadmin.php';
?>
<?php 
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."agendaadmin/".$_SESSION['idAdmin']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "agendaadmin/" . $_SESSION['idAdmin'] . "'</script>";
}
?>