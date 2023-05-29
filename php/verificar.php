<?php
if (isset(explode("/", $_GET['view'])[1]) && isset(explode("/", $_GET['view'])[2]) && isset(explode("/", $_GET['view'])[3]) && isset(explode("/", $_GET['view'])[4])) {
	$_GET['id'] = explode("/", $_GET['view'])[1];
	$_GET['token'] = explode("/", $_GET['view'])[2];
	$_GET['codigo'] = explode("/", $_GET['view'])[3];
	$_GET['tiempo'] = explode("/", $_GET['view'])[4];
} else{
    echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "');</script>";
}

$currentDateVerify = new DateTime();
$currentDateVerify = (strtotime($currentDateVerify->format('Y-m-d H:i:s')) * 1000);

$diferenciaDeMilisegundos = ($currentDateVerify - $_GET['tiempo']);
$segundosTrans = ($diferenciaDeMilisegundos / 1000);
$minutosTrans = ($segundosTrans / 60);
$horasTrans = ($minutosTrans / 60);

    $consulta = "SELECT * FROM usuarios WHERE id = '" . $_GET['id'] . "' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()) {
            $token = $row['token'];
            $codigo = $row['codigo'];
            $estado = $row['estado'];
            $correo = $row['correo'];
            
            $sql1 = mysqli_query($conexion, "DELETE FROM usuarios WHERE correo = '" . $correo . "' AND id <> '" . $_GET['id'] . "' ");
        }
    } else{
        echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "');</script>";
    }
    
if($estado=='V' || $estado=='1' || $estado=='2'){
if ( $horasTrans >= 24 && $estado=='V') {
  $sql3 = mysqli_query($conexion, "DELETE FROM usuarios WHERE id = '" . $_GET['id'] . "' ");
  function verificacion(){
    ?>
        <h1>Verificación fallida</h1>
        <p>El enlace de verificación ha vencido. Regístrate nuevamente para iniciar sesión.</p>
    <?php
  }
}else if ( $horasTrans >= 24 && $estado!='V') {
  function verificacion(){
    ?>
    <h1>Verificación exitosa</h1>
    <p>Tu correo fue verificado exitosamente. Inicia sesión para ingresar.</p>
    <?php
    }
}else{
    if ($estado=='V'){
        if($token == $_GET['token'] && $codigo == $_GET['codigo']){
            $newtoken = bin2hex(random_bytes(10));
            $newcodigo = rand(100000,999999);
    
            $sql = "UPDATE usuarios SET estado='1', token= '".$newtoken."', codigo= '".$newcodigo."' WHERE id = '".$_GET['id']."'";
            $stmt = mysqli_query($conexion, $sql);
            function verificacion(){
            ?>
            <h1>Verificación exitosa</h1>
            <p>Tu correo fue verificado exitosamente. Inicia sesión para ingresar.</p>
            <?php
            }
        }else{
            function verificacion(){
            ?>
                <h1>Verificación fallida</h1>
                <p>El enlace de verificación es incorrecto. Asegúrate de ingresar al enlace que llegó a tu correo.</p>
            <?php
            }
        }
    }else{
            function verificacion(){
            ?>
            <h1>Verificación exitosa</h1>
            <p>Tu correo fue verificado exitosamente. Inicia sesión para ingresar.</p>
            <?php
            }
    }
}
}else{
    function verificacion(){
    ?>
        <h1>Verificación Fallida</h1>
        <p>El enlace de verificación es incorrecto. Regístrate nuevamente para iniciar sesión.</p>
    <?php
    }
}
?>