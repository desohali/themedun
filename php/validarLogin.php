<?php
include 'conexion_paciente.php';
$respuesta=[];
 $sql = "SELECT id, contraseña, estado FROM usuarios WHERE correo = '".$_POST['correo']."' AND estado <> 'V' ";
 if($stmt = mysqli_prepare($conexion, $sql)){
     if(mysqli_stmt_execute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) >= 1){
            mysqli_stmt_bind_result($stmt, $id, $hashed_contraseña, $estado);
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($_POST['contraseña'], $hashed_contraseña)){
                    //session_set_cookie_params(60 * 60 * 24 * 365);
                    ini_set("session.gc_maxlifetime", 60*60*24*365);
                    ini_set("session.cookie_lifetime", 60*60*24*365);
                    session_start();
                        //ALMACENAR DATOS EN VARIABLES DE SESIÓN
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $respuesta+=['estado'=>$estado];
                        $respuesta+=['id'=>$id];
                }else{
                    $respuesta+=['contraseña'=>'Contraseña incorrecta'];
                }
            }
         }else{
            $respuesta+=['correo'=>'Este correo no existe'];
         }
     }
 }
echo json_encode($respuesta);
?>
