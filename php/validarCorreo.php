<?php
include 'conexion_paciente.php';
$respuesta=[];
 $sql = "SELECT id FROM usuarios WHERE correo = '".$_POST['correo']."' AND estado <> 'V'";
 if($stmt = mysqli_prepare($conexion, $sql)){
     if(mysqli_stmt_execute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) > 0){
            $respuesta+=['correo'=>'Este correo ya está en uso'];
         }else{
            $respuesta+=['correo'=> trim($_POST["correo"])];
         }
     }
 }
echo json_encode($respuesta);
?>