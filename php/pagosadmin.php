<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Abono a Administradores - The Med Universe | Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historial.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hpacientes.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historialadmin.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body id="body">
<?php echo headernav();include './php/navbarAdmin.php'?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="boxhistorial">
        <div class="ctn-hpacientes">
			<div class="ctn-editarpc">
                <h2>ADMINISTRADORES A PAGAR</h2>
            </div>
            <div class="ctn-infpagos">
                <?php
                include './php/conexion_paciente.php';
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM pagosadmin");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT distinct idAdmin, idAdmin as idadmin,(select nombresAdmin from administradores where idAdmin=idadmin limit 1) as nombresAdministrador, (select apellidosAdmin from administradores where idAdmin=idadmin limit 1) as apellidosAdministrador FROM pagosadmin WHERE abonado = 'NO' ORDER BY idpago ASC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                    $consultacita = "SELECT * FROM administradores WHERE idAdmin = '".$lista['idAdmin']."' ";
                    $resultadocita = mysqli_query($conexion, $consultacita);
                    if ($resultadocita) {
                        while ($rowcita = $resultadocita->fetch_array()){
                            $idpro = $rowcita['idAdmin'];
                            $nombrespro = $rowcita['nombresAdmin'];
                            $apellidospro = $rowcita['apellidosAdmin'];
                            $paispro = $rowcita['paisAdmin'];
                            $ciudadpro = $rowcita['ciudadAdmin'];
                        }
                    }
                ?>
                <hr>
                <div class="box-body" style="align-items:center">
                    <div class="historia1" id="parte1">
                        <p><?php echo $nombrespro. ' ' . $apellidospro?></p>
                    </div>
                    <div class="historia2" id="parte2">
                        <p id="p2pais"><span>País:</span> <?php echo $paispro?></p>
                        <p id="p2ciudad"><span>Ciudad:</span> <?php echo $ciudadpro?></p>
                    </div>
                    <div class="historia3" id="parte3">
                        <a href="<?php echo $_ENV['APP_URL'];?>abonosadmin/<?php echo $idpro?>" id="bcfiled2">Pagos Pendientes</a>
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