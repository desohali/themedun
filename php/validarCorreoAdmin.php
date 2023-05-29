<?php
include 'conexion_paciente.php';
$respuesta=[];
 $sql = "SELECT idAdmin FROM administradores WHERE correoAdmin = '".$_POST['correo']."'";
 if($stmt = mysqli_prepare($conexion, $sql)){
     if(mysqli_stmt_execute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) == 1){
            $respuesta+=['correo'=>'Este correo ya está en uso'];
         }else{
            $respuesta+=['correo'=> trim($_POST["correo"])];
         }
     }
 }
echo json_encode($respuesta);
?>