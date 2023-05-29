<?php
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navAdmin.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
    include './php/perfiladmin.php';
    if(!isset($_SESSION["loggedin"]))
    {
        header("Location: loginadmin");
    }
?>
