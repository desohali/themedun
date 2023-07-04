<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Libro de Reclamaciones - The Med Universe | Administrador</title>
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
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
<?php echo headernav();include './php/navbarAdmin.php';?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/buscadorAdmin.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="boxhistorial">
        <div class="ctn-hpacientes">
            <h2 class="titulolr">LIBRO DE RECLAMACIONES</h2>
			<div class="ctn-editarpc">
                <h2 style="color:#FFC107">POR REVISAR</h2>
            </div>
            <div class="ctn-infpagos">
                <?php
                include './php/conexion_paciente.php';
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM lreclamos");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT * FROM lreclamos WHERE acciones='Aún no hay observaciones ni acciones.' ORDER BY idrec ASC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                ?>
                <hr>
                <div class="box-body" style="align-items:center">
                    <div class="historia1" id="parte1">
                        <p><?php echo $lista['nombres']. ' ' . $lista['apellidos']?></p>
                    </div>
                    <div class="historia2" id="parte2">
                        <p id="p2pais"><span><?php echo $lista['documento']?>:</span> <?php echo $lista['numdoc']?></p>
                        <p id="p2ciudad"><span>Fecha de registro:</span> <?php echo $lista['fecha']?></p>
                    </div>
                    <div class="historia3" id="parte3">
                        <a href="<?php echo $_ENV['APP_URL'];?>hojareclamacion/<?php echo $lista['idrec']?>" id="bcfiled2">Hoja de Reclamación</a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="ctn-editarpc">
                <h2 style="color:#00D418">REVISADO</h2>
            </div>
            <div class="ctn-infpagos">
                <?php
                include './php/conexion_paciente.php';
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM lreclamos");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT * FROM lreclamos WHERE acciones<>'Aún no hay observaciones ni acciones.' ORDER BY idrec ASC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                ?>
                <hr>
                <div class="box-body" style="align-items:center">
                    <div class="historia1" id="parte1">
                        <p><?php echo $lista['nombres']. ' ' . $lista['apellidos']?></p>
                    </div>
                    <div class="historia2" id="parte2">
                        <p id="p2pais"><span><?php echo $lista['documento']?>:</span> <?php echo $lista['numdoc']?></p>
                        <p id="p2ciudad"><span>Fecha de registro:</span> <?php echo $lista['fecha']?></p>
                    </div>
                    <div class="historia3" id="parte3">
                        <a href="<?php echo $_ENV['APP_URL'];?>hojareclamacion/<?php echo $lista['idrec']?>" id="bcfiled2">Hoja de Reclamación</a>
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