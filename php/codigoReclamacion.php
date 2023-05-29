<?php
include 'conexion_paciente.php';

$respuesta=[];
 $sql = "SELECT * FROM lreclamos WHERE codigo = '".$_POST["codigo"]."'";
 if($stmt = mysqli_prepare($conexion, $sql)){
     if(mysqli_stmt_execute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) == 1){
            $respuesta+=['codigo'=>$_POST["codigo"]];
         }else{
            $respuesta+=['codigo'=>'Este codigo no existe'];
         }
     }
 }
echo json_encode($respuesta);
?>