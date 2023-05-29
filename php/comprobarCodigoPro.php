<?php
include 'conexion_paciente.php';
$respuesta=[];

$idprocon = $_POST['idpro'];
$tokenprocon = $_POST['token'];

$codigoprocon = trim($_POST["codigo"]);
//VALIDAR CREDENCIALES
$sql = "SELECT * FROM usuariospro WHERE idpro = '$idprocon' and tokenpro = '$tokenprocon' and codigopro = '$codigoprocon'";
if($stmt = mysqli_prepare($conexion, $sql)){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) > 0){
            $respuesta+=['idpro'=>$idprocon];
            $respuesta+=['tokenpro'=>$tokenprocon];
            $respuesta+=['codigo'=>$codigoprocon];
        }else{
            $respuesta+=['codigo'=>'Este codigo no existe'];
        }
    }
}else{
    header("location: ".$_ENV['APP_URL']."loginpro");
}

echo json_encode($respuesta);
?>