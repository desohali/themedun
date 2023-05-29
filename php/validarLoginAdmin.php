<?php
include 'conexion_paciente.php';
$respuesta=[];
 $sql = "SELECT idAdmin, nombresAdmin, apellidosAdmin, correoAdmin, contraseñaAdmin, nacimientoAdmin, sexoAdmin, paisAdmin, ciudadAdmin, enmuAdmin, fotoperfilAdmin, estadoAdmin FROM administradores WHERE correoAdmin = '".$_POST['correo']."'";
 if($stmt = mysqli_prepare($conexion, $sql)){
     if(mysqli_stmt_execute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $id, $nombres, $apellidos, $correo, $hashed_contraseña, $nacimiento, $sexo, $pais, $ciudad, $enmu, $fotoperfil, $estado);
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($_POST['contraseña'], $hashed_contraseña)){
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
                        $_SESSION["contraseñaAdmin"] = $hashed_contraseña;
                        $_SESSION["nacimientoAdmin"] = $nacimiento;
                        $_SESSION["sexoAdmin"] = $sexo;
                        $_SESSION["paisAdmin"] = $pais;
                        $_SESSION["ciudadAdmin"] = $ciudad;
                        $_SESSION["enmuAdmin"] = $enmu;
                        $_SESSION["estadoAdmin"] = $estado;
                        $_SESSION["fotoperfilAdmin"] = $fotoperfil;
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
