<?php

    include 'conexion_paciente.php';
    
    /* if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["idpro"])){
            header("location: perfilpro/".$_SESSION["idpro"]."");
        }else{
            header("location: home");
        }
    exit;
    } */
    
$correo = $contraseña = $correo_err = $contraseña_err = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $correo = trim($_POST["correo"]);
    $contraseña = trim($_POST["contraseña"]);
    //VALIDAR CREDENCIALES
    if(empty($correo_err) && empty($contraseña_err)){
        $sql = "SELECT idAdmin, nombresAdmin, apellidosAdmin, correoAdmin, contraseñaAdmin, nacimientoAdmin, sexoAdmin, paisAdmin, ciudadAdmin, enmuAdmin, fotoperfilAdmin FROM administradores WHERE correoAdmin = ?";
        if($stmt = mysqli_prepare($conexion, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_correo);
            $param_correo = $correo;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);}
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $nombres, $apellidos, $correo, $hashed_contraseña, $nacimiento, $sexo, $pais, $ciudad, $enmu, $fotoperfil);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($contraseña, $hashed_contraseña)){
                        //session_set_cookie_params(60 * 60 * 24 * 365);
                        ini_set("session.gc_maxlifetime", 60*60*24*365);
                        ini_set("session.cookie_lifetime", 60*60*24*365);
                        session_start();
                        //ALMACENAR DATOS EN VARIABLES DE SESIÓN
                        $_SESSION["loggedin"] = true;
                        $_SESSION["idAdmin"] = $id;
                        $_SESSION["nombresAdmin"] = $nombres;
                        $_SESSION["apellidosAdmin"] = $apellidos;
                        $_SESSION["correoAdmin"] = $correo;
                        $_SESSION["contraseñaAdmin"] = $contraseña;
                        $_SESSION["nacimientoAdmin"] = $nacimiento;
                        $_SESSION["sexoAdmin"] = $sexo;
                        $_SESSION["paisAdmin"] = $pais;
                        $_SESSION["ciudadAdmin"] = $ciudad;
                        $_SESSION["enmuAdmin"] = $enmu;
                        $_SESSION["fotoperfilAdmin"] = $fotoperfil;
                        header("location: activos");
                    }else{
                        $contraseña_err = "La contraseña es incorrecta";
                    }
                }
            }else{
                $correo_err = "No se encontró ninguna cuenta con ese correo";
            }
        }else{
            echo "UPS! algo salió mal, inténtalo más tarde";
        }
    }
    mysqli_close($conexion);
}
?>