<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historial de Pagos - The Med Universe | Paciente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historial.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historialpac.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
<?php echo headernav();include './php/navbar.php';?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="<?php echo $_ENV['APP_URL'];?>js/buscador.js"></script>
        <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="boxhistorial">
        <div class="ctn-historial">
			<div class="ctn-editarpc">
                <h2>HISTORIAL DE PAGOS</h2>
            </div>
            <div class="ctn-infpagos">
                <?php
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM pagos");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT *, idpago as idpagos, (select start from citas where idpay=idpagos) as startCitas FROM pagos WHERE usuario = '".$id."' ORDER BY startCitas DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                    $consultacita = "SELECT *, idupro as iduprofesional,(select nombrespro from usuariospro where idpro=iduprofesional) as nombresMedico, (select apellidospro from usuariospro where idpro=iduprofesional) as apellidosMedico,(select sexopro from usuariospro where idpro=iduprofesional) as sexoMedico FROM citas WHERE idpay = '".$lista['idpago']."' ";
                    $resultadocita = mysqli_query($conexion, $consultacita);
                    if ($resultadocita) {
                        while ($rowcita = $resultadocita->fetch_array()){
                            $idcita = $rowcita['idcita'];
                            $sexoMedico = $rowcita['sexoMedico'];
                            $costo = $rowcita['localizacion'];
                            $start = $rowcita['start'];
                            $asistenciapac = $rowcita['asistenciapac'];
                            $fechapago = $start;
                            list($fecha, $hora) = explode(" ", $fechapago);
                            $horafinal = explode(":00", $hora);
                            $timestamp = strtotime($fecha);
                            $newFecha = date("d/m/Y", $timestamp);
                            if($sexoMedico == "Femenino"){
                                $doctor = "Dra.";
                            }else{
                                $doctor = "Dr.";
                            }
                            $medico = $doctor.' '.$rowcita['nombresMedico'].' '.$rowcita['apellidosMedico'];
                            if($horafinal[0]=='01'){
                                $enlace=" a la ";
                            }else{
                                $enlace=" a las ";
                            }
                        }
                    }
                ?>
                <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span>N° de cita:</span><br><?php echo $idcita?></p>
                            <p><span>Fecha y hora de cita:</span><br><?php echo $newFecha . $enlace . $horafinal[0] . ":00";?></p>
                        </div>

                        <div class="historia2">
                            <p><span>Pagado por:</span><br><?php echo $nombres.' '.$apellidos?></p>
                            <p><span>Método de pago:</span><br><?php echo $lista['metodopago']?></p>
                        </div>
                    </div>
                    <div class="boxhisto2">
                        <div class="historia3">
                            <p><span>Pagado a:</span><br><?php echo $medico?></p>
                            <p><span>Asistencia:</span><br><?php echo $asistenciapac?></p>
                        </div>
                        <div class="historia4">
                            <p><span>Precio de cita:</span><br>S/ <?php echo $costo?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </main>
</body>
<?php echo footermed();?>
</html>