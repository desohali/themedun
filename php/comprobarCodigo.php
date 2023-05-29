<?php
include 'conexion_paciente.php';
$respuesta=[];

$idcon = $_POST['id'];
$tokencon = $_POST['token'];

$codigocon = trim($_POST["codigo"]);
//VALIDAR CREDENCIALES
$sql = "SELECT * FROM usuarios WHERE id = '$idcon' and token = '$tokencon' and codigo = '$codigocon'";
if($stmt = mysqli_prepare($conexion, $sql)){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) > 0){
            $respuesta+=['id'=>$idcon];
            $respuesta+=['token'=>$tokencon];
            $respuesta+=['codigo'=>$codigocon];
        }else{
            $respuesta+=['codigo'=>'Este codigo no existe'];
        }
    }
}else{
    header("location: ".$_ENV['APP_URL']."login");
}

echo json_encode($respuesta);
?>