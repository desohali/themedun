<?php

    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();

    include './php/navAdmin.php';
    include './php/conexion_paciente.php';
    include './php/footer.php';
    include './configuracion.php';
if (isset($_SESSION['idAdmin'])) {
    $consultaAdmin ="SELECT * FROM administradores WHERE idAdmin = '".$_SESSION['idAdmin']."'";
    $consultaAd=mysqli_query($conexion, $consultaAdmin);
    while ($listaAdmin=mysqli_fetch_array($consultaAd)) {
        $estadoAdmin = $listaAdmin['estadoAdmin'];
    }
}
if (@$estadoAdmin == 2) {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicos Inactivos - The Med Universe | Administrador</title>
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/i-fav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/home.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
</head>
<?php echo headernav();include './php/navbarAdmin.php';?>
<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <script src="<?php echo $_ENV['APP_URL'];?>js/buscadorAdmin.js"></script>
        <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
        <?php
            $where = "";

            if (isset($_POST['buscar'])){
                echo "<script>history.pushState({}, '', window.location.href)</script>";
                if (empty($_POST['ssexo'])){
                    if (empty($_POST['sespecialidad'])){
                        if (empty($_POST['spais'])){
                            if (empty($_POST['sidioma'])){
                                $where = "";
                            }
                            else{
                                $where = "where idiomapro='".$_POST['sidioma']."'";
                            }
                        }
                        else if(empty($_POST['sidioma'])){
                            $where = "where paispro='".$_POST['spais']."'";
                        }
                        else{
                            $where = "where paispro='".$_POST['spais']."' and idiomapro='".$_POST['sidioma']."'";
                        }
                    }
                    else if (empty($_POST['spais'])){
                        if (empty($_POST['sidioma'])){
                            $where = "where especialidad='".$_POST['sespecialidad']."'";
                        }
                        else{
                            $where = "where especialidad='".$_POST['sespecialidad']."' and idiomapro='".$_POST['sidioma']."'";
                        }
                    }
                    else if (empty($_POST['sidioma'])){
                        $where = "where especialidad='".$_POST['sespecialidad']."' and paispro='".$_POST['spais']."'";
                    }
                    else{
                        $where = "where especialidad='".$_POST['sespecialidad']."' and paispro='".$_POST['spais']."' and idiomapro='".$_POST['sidioma']."'";
                    }
                }
                else if (empty($_POST['sespecialidad'])){
                    if (empty($_POST['spais'])){
                        if (empty($_POST['sidioma'])){
                            $where = "where sexopro='".$_POST['ssexo']."'";
                        }
                        else{
                            $where = "where sexopro='".$_POST['ssexo']."' and idiomapro='".$_POST['sidioma']."'";
                        }
                    }
                    else if (empty($_POST['sidioma'])){
                        $where = "where sexopro='".$_POST['ssexo']."' and paispro='".$_POST['spais']."'";
                    }
                    else{
                        $where = "where sexopro='".$_POST['ssexo']."' and paispro='".$_POST['spais']."' and idiomapro='".$_POST['sidioma']."'";
                    }
                }
                else if (empty($_POST['spais'])){
                    if (empty($_POST['sidioma'])){
                        $where = "where sexopro='".$_POST['ssexo']."' and especialidad='".$_POST['sespecialidad']."'";
                    }
                    else{
                        $where = "where sexopro='".$_POST['ssexo']."' and especialidad='".$_POST['sespecialidad']."' and idiomapro='".$_POST['sidioma']."'";
                    }
                }
                else if (empty($_POST['sidioma'])){
                    $where = "where sexopro='".$_POST['ssexo']."' and especialidad='".$_POST['sespecialidad']."' and paispro='".$_POST['spais']."'";
                }
                else{
                    $where = "where sexopro='".$_POST['ssexo']."' and especialidad='".$_POST['sespecialidad']."' and paispro='".$_POST['spais']."' and idiomapro='".$_POST['sidioma']."'";
                }

                # SI NO SE HAY ALGUN FILTRO SE BUSCA POR RANGO DE 0 AL PRECIO MAXIMO
                if (empty($where)) {
                    $where .= " where precio between ". @$_POST['rangeStart'] . " and " . @$_POST['rangeEnd'] . " and  ";
                }else{
                    # SOLO CONCATENAMOS LA CONSULTA
                    $where .= " and precio between ". @$_POST['rangeStart'] . " and " . @$_POST['rangeEnd'] . " and  ";
                }
            }else{
                $where = " where ";
            }
        ?>
    <main>
        <div class="ctn-home" id="ctn-home">
                <?php
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
	            $TotalReg       =mysqli_query($conexion, "SELECT * FROM usuariospro");
	            $totalr = mysqli_num_rows($TotalReg);
	            //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
	            $TotalRegistro  =ceil($totalr/$CantidadMostrar);
	            //Operacion matematica para mostrar los siquientes datos.
	            $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
	            //Consulta SQL
	            $consultavistas ="SELECT * FROM usuariospro $where estado='0' ORDER BY idpro ASC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
	            $consulta=mysqli_query($conexion, $consultavistas);
	            while ($lista=mysqli_fetch_array($consulta)) {
	                $profesion = "Medicina";
                    if ($lista['especialidad'] == "Psicología") {
                        $profesion = "Psicología";
                    }
	                if($lista['sexopro'] == "Femenino"){
	                    $doctor = "Dra.";
	                }else{
	                    $doctor = "Dr.";
	                }
                    $timestampNac = strtotime($lista['nacimientopro']); 
                    $newDateNac = date("d/m/Y", $timestampNac );

                    $consultavistas3 ='SELECT round(AVG(valoracion),1) as promedioStar FROM valoraciones WHERE idupro = "'.$lista["idpro"].'" AND valoracion != "0"';
	                $consulta3=mysqli_query($conexion, $consultavistas3);
	                while ($lista3=mysqli_fetch_array($consulta3)) {
                        $promedio=$lista3['promedioStar'];
                        if($promedio==''){
                            $promedio='0.0';
                        }
                    }
	            ?>
            <div class="box<?php echo $lista["idpro"]; ?>" id="boxfull0">
            <div class="box-full">
                <div class="stars" id="stars"><p><?php echo $promedio?></p></div>
                <div class="rateYo" style="position:absolute"></div>
                <script>
                    $(document).ready(async function(){
                        $(".rateYo").rateYo({
                            starWidth: "40px",
                            normalFill: "#e5e5e5",
                            ratedFill: "#fff600",
                            readOnly: true,
                            numStars: 1,
                            rating: 5,
                        });
                    });
                </script>
                <h2 id="nombreperfil"><a href='<?php echo $_ENV['APP_URL'];?>perfilrevision/<?php echo $lista["idpro"]; ?>' class="titulomedico"><?php echo $doctor.' '.$lista['nombrespro'].' '.$lista['apellidospro']?></a></h2>
                <div class="box-bodyper">
                    <?php 
                    if($lista['fotoperfilpro'] != '')
                    {
                    ?>
                        <div class="ctn-imagepub">
                            <img src="<?php echo $_ENV['APP_URL'].'fotoperfilpro/mini_'.$lista['fotoperfilpro']. '?v=' . rand();?>">
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    $fecha = time() - strtotime($lista['nacimientopro']);
                    $edad = floor($fecha / 31556926);
                    ?>
                    <p id="nacimientoperfil"><span>F. Nacimiento:</span> <?php echo $newDateNac. ' ('.$edad.' años)'?></p>
                    <p id="sexoperfil"><span>Género:</span> <?php echo $lista['sexopro']?></p>
                    <p id="paisperfil"><span>País:</span> <?php echo $lista['paispro']?></p>
                    <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $lista['ciudadpro']?></p>
                    <p id="idiomaperfil"><span>Idioma:</span> <?php echo $lista['idiomapro']?></p>
                    <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $lista['especialidad']?></p>
                </div>
                <div class="box-bodypro">
                    <div class="box-pro" id="box-admin">
                <?php
                $CantidadMostrar2=100;
                // Validado  la variable GET
                $compag2         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
	            $TotalReg2       =mysqli_query($conexion, "SELECT * FROM publicaciones");
	            $totalr2 = mysqli_num_rows($TotalReg2);
	            //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
	            $TotalRegistro2  =ceil($totalr2/$CantidadMostrar2);
	            //Operacion matematica para mostrar los siquientes datos.
	            $IncrimentNum2 =(($compag2 +1)<=$TotalRegistro2)?($compag2 +1):0;
	            //Consulta SQL
	            $consultavistas2 ="SELECT * FROM publicaciones WHERE usuario = '".$lista['idpro']."' ORDER BY idpub ASC LIMIT ".(($compag2-1)*$CantidadMostrar2)." , ".$CantidadMostrar2;
	            $consulta2=mysqli_query($conexion, $consultavistas2);
	            while ($lista2=mysqli_fetch_array($consulta2)) {
	            ?>
                    <li><?php echo $lista2['contenido'];?></li>
                <?php
                }
                ?>
                    </div>
                    <p id="precioperfil"><span>Precio de cita:</span> S/ <?php echo $lista['precio']?></p>
                    <div class="underpro" style="display:flex;align-items:center;justify-content:center">
                        <a href='<?php echo $_ENV['APP_URL'];?>perfilrevision/<?php echo $lista["idpro"]; ?>' class="verperfil" id="verperfil"><button>Ver perfil</button></a>
                    </div>
                </div>
            </div>
            </div>
                <?php
                }
                ?>
        </div>
    </main>
</body>
<?php echo footermed();?>
</html>