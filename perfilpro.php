<?php
if (session_status() === PHP_SESSION_NONE) {
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();
}
/*if(isset($_SESSION["id"])){
    header("Location: home");
}*/
?>
<?php
    //session_start();

    include './php/navbarhtmlpro.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    include './php/perfilpro.php';
    /*if(!isset($_SESSION["loggedin"])){
        header("Location: loginpro");
    }*/
    