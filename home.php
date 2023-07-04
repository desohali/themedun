<?php

if (session_status() === PHP_SESSION_NONE) {
    //session_set_cookie_params(60 * 60 * 24 * 365);
    ini_set("session.gc_maxlifetime", 60*60*24*365);
    ini_set("session.cookie_lifetime", 60*60*24*365);
    session_start();
}

include './php/navbarhtml.php';
include './php/conexion_paciente.php';
include './php/footer.php';
include './configuracion.php';
if (isset($_SESSION['id'])) {
    $consultaPaciente ="SELECT * FROM usuarios WHERE id = '".$_SESSION['id']."'";
    $consultaPac=mysqli_query($conexion, $consultaPaciente);
    while ($listaPaciente=mysqli_fetch_array($consultaPac)) {
        $estadoPaciente = $listaPaciente['estado'];
    }
}
if (@$estadoPaciente == 2) {
    $url = "<script>window.location.href='" . $_ENV['APP_URL'];
    echo $url . "perfil/" . $_SESSION['id'] . "'</script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Inicio - The Med Universe | Paciente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/i-home.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/home.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>
<?php echo headernav();
include './php/navbar.php'; ?>

<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/buscador.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&ob.js"></script>
    <script type="text/javascript" src="<?php echo $_ENV['APP_URL']; ?>js/fav.js"></script>
    <?php
    $where = "";

    if (isset($_POST['buscar'])) {

        echo "<script>history.pushState({}, '', window.location.href)</script>";
        if (empty($_POST['ssexo'])) {
            if (empty($_POST['sespecialidad'])) {
                if (empty($_POST['spais'])) {
                    if (empty($_POST['sidioma'])) {
                        $where = "";
                    } else {
                        $where = "where idiomapro='" . $_POST['sidioma'] . "'";
                    }
                } else if (empty($_POST['sidioma'])) {
                    $where = "where paispro='" . $_POST['spais'] . "'";
                } else {
                    $where = "where paispro='" . $_POST['spais'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
                }
            } else if (empty($_POST['spais'])) {
                if (empty($_POST['sidioma'])) {
                    $where = "where especialidad='" . $_POST['sespecialidad'] . "'";
                } else {
                    $where = "where especialidad='" . $_POST['sespecialidad'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
                }
            } else if (empty($_POST['sidioma'])) {
                $where = "where especialidad='" . $_POST['sespecialidad'] . "' and paispro='" . $_POST['spais'] . "'";
            } else {
                $where = "where especialidad='" . $_POST['sespecialidad'] . "' and paispro='" . $_POST['spais'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
            }
        } else if (empty($_POST['sespecialidad'])) {
            if (empty($_POST['spais'])) {
                if (empty($_POST['sidioma'])) {
                    $where = "where sexopro='" . $_POST['ssexo'] . "'";
                } else {
                    $where = "where sexopro='" . $_POST['ssexo'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
                }
            } else if (empty($_POST['sidioma'])) {
                $where = "where sexopro='" . $_POST['ssexo'] . "' and paispro='" . $_POST['spais'] . "'";
            } else {
                $where = "where sexopro='" . $_POST['ssexo'] . "' and paispro='" . $_POST['spais'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
            }
        } else if (empty($_POST['spais'])) {
            if (empty($_POST['sidioma'])) {
                $where = "where sexopro='" . $_POST['ssexo'] . "' and especialidad='" . $_POST['sespecialidad'] . "'";
            } else {
                $where = "where sexopro='" . $_POST['ssexo'] . "' and especialidad='" . $_POST['sespecialidad'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
            }
        } else if (empty($_POST['sidioma'])) {
            $where = "where sexopro='" . $_POST['ssexo'] . "' and especialidad='" . $_POST['sespecialidad'] . "' and paispro='" . $_POST['spais'] . "'";
        } else {
            $where = "where sexopro='" . $_POST['ssexo'] . "' and especialidad='" . $_POST['sespecialidad'] . "' and paispro='" . $_POST['spais'] . "' and idiomapro='" . $_POST['sidioma'] . "'";
        }

        # SI NO SE HAY ALGUN FILTRO SE BUSCA POR RANGO DE 0 AL PRECIO MAXIMO
        if (empty($where)) {
            $where .= " where precio between " . @$_POST['rangeStart'] . " and " . @$_POST['rangeEnd'] . " and  ";
        } else {
            # SOLO CONCATENAMOS LA CONSULTA
            $where .= " and precio between " . @$_POST['rangeStart'] . " and " . @$_POST['rangeEnd'] . " and  ";
        }
    } else {
        $where = " where ";
    }
    ?>
    <main>
        <div class="ctn-home" id="ctn-home">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="15300">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
        <video id="panelUno" class="d-block" src="<?php echo $_ENV['APP_URL'] . 'images/Panel Bienvenido (2).mp4'; ?>" alt="Primer slide" autoplay loop muted ></video>
        <video id="panelDos" class="d-block" src="<?php echo $_ENV['APP_URL'] . 'images/Panel Bienvenido Celular.mp4'; ?>" alt="Primer slide" autoplay loop muted ></video>
    </div>
    <div class="carousel-item">
        <img id="panelCelUno" class="d-block" src="<?php echo $_ENV['APP_URL'] . 'images/Panel 2 (2).png'; ?>" alt="Segundo slide">
        <img id="panelCelDos" class="d-block" src="<?php echo $_ENV['APP_URL'] . 'images/PanelCelular.png'; ?>" alt="Segundo slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
            <?php
            $CantidadMostrar = 10000;
            // Validado  la variable GET
            $compag         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag'];
            $TotalReg       = mysqli_query($conexion, "SELECT * FROM usuariospro");
            $totalr = mysqli_num_rows($TotalReg);
            //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
            $TotalRegistro  = ceil($totalr / $CantidadMostrar);
            //Operacion matematica para mostrar los siquientes datos.
            $IncrimentNum = (($compag + 1) <= $TotalRegistro) ? ($compag + 1) : 0;
            //Consulta SQL
            $consultavistas = "SELECT * FROM usuariospro $where estado='1' ORDER BY RAND() LIMIT " . (($compag - 1) * $CantidadMostrar) . " , " . $CantidadMostrar;
            $consulta = mysqli_query($conexion, $consultavistas);
            while ($lista = mysqli_fetch_array($consulta)) {
                $profesion = "Medicina";
                if ($lista['especialidad'] == "Psicología") {
                    $profesion = "Psicología";
                }
                if ($lista['sexopro'] == "Femenino") {
                    $doctor = "Dra.";
                } else {
                    $doctor = "Dr.";
                }
                $timestampNac = strtotime($lista['nacimientopro']);
                $newDateNac = date("d/m/Y", $timestampNac);

                $consultavistas3 = 'SELECT round(AVG(valoracion),1) as promedioStar FROM valoraciones WHERE idupro = "' . $lista["idpro"] . '" AND valoracion != "0"';
                $consulta3 = mysqli_query($conexion, $consultavistas3);
                while ($lista3 = mysqli_fetch_array($consulta3)) {
                    $promedio = $lista3['promedioStar'];
                    if ($promedio == '') {
                        $promedio = '0.0';
                    }
                }
            ?>
                <div class="box-full">
                    <div class="stars" id="stars">
                        <p><?php echo $promedio ?></p>
                    </div>
                    <div class="rateYo" style="position:absolute"></div>
                    <script>
                        $(document).ready(async function() {
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
                    <h2 id="nombreperfil"><a href='<?php echo $_ENV['APP_URL']; ?>perfilproo/<?php echo $lista["idpro"]; ?>' class="titulomedico"><?php echo $doctor . ' ' . $lista['nombrespro'] . ' ' . $lista['apellidospro'] ?></a></h2>
                    <div class="box-bodyper">
                        <?php
                        if ($lista['fotoperfilpro'] != '') {
                        ?>
                            <div class="ctn-imagepub">
                                <img src="<?php echo $_ENV['APP_URL'] . 'fotoperfilpro/mini_' . $lista['fotoperfilpro']. '?v=' . rand();?>">
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        $fecha = time() - strtotime($lista['nacimientopro']);
                        $edad = floor($fecha / 31556926);
                        ?>
                        <p id="nacimientoperfil"><span>F. Nacimiento:</span> <?php echo $newDateNac;?> <span id="spanedad"><?php echo '('.$edad.' años)'; ?></span></p>
                        <p id="edadperfil"><span>Edad:</span> <?php echo $edad.' años'; ?></p>
                        <p id="sexoperfil"><span>Género:</span> <?php echo $lista['sexopro'] ?></p>
                        <div class="divbox">
                        <p id="paisperfil"><span>País:</span> <?php echo $lista['paispro'] ?></p>
                        <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $lista['ciudadpro'] ?></p>
                        </div>
                        <p id="idiomaperfil"><span>Idioma:</span> <?php echo $lista['idiomapro'] ?></p>
                        <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $lista['especialidad'] ?></p>
                    </div>
                    <div class="box-bodypro">
                        <div class="box-pro">
                            <?php
                            $CantidadMostrar2 = 100;
                            // Validado  la variable GET
                            $compag2         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag'];
                            $TotalReg2       = mysqli_query($conexion, "SELECT * FROM publicaciones");
                            $totalr2 = mysqli_num_rows($TotalReg2);
                            //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                            $TotalRegistro2  = ceil($totalr2 / $CantidadMostrar2);
                            //Operacion matematica para mostrar los siquientes datos.
                            $IncrimentNum2 = (($compag2 + 1) <= $TotalRegistro2) ? ($compag2 + 1) : 0;
                            //Consulta SQL
                            $consultavistas2 = "SELECT * FROM publicaciones WHERE usuario = '" . $lista['idpro'] . "' ORDER BY idpub ASC LIMIT " . (($compag2 - 1) * $CantidadMostrar2) . " , " . $CantidadMostrar2;
                            $consulta2 = mysqli_query($conexion, $consultavistas2);
                            while ($lista2 = mysqli_fetch_array($consulta2)) {
                            ?>
                                <li><?php echo $lista2['contenido']; ?></li>
                            <?php
                            }
                            ?>
                        </div>
                        <p id="precioperfil"><span>Precio de cita:</span> S/ <?php echo $lista['precio'] ?></p>
                        <div class="underpro">
                            <?php
                            $idfavpro = "";
                            $consultavistas5 = "SELECT * FROM favoritos WHERE usuario = '" . $_SESSION['id'] . "' AND idfav = '" . $lista["idpro"] . "'";
                            $consulta5 = mysqli_query($conexion, $consultavistas5);
                            while ($lista5 = mysqli_fetch_array($consulta5)) {
                                $idfavpro = $lista5["idfav"];
                            }
                            ?>
                            <div class="heartfav marks marcado<?php echo $lista["idpro"]; ?>" id="<?php echo $lista["idpro"]; ?>" style="<?php if ($idfavpro == $lista["idpro"]) { ?>display:inline-block<?php } ?>"><i class="fa-solid fa-heart-pulse" id="heartperfil"></i></div>
                            <div class="heartfav desmarks desmarcado<?php echo $lista["idpro"]; ?>" id="<?php echo $lista["idpro"]; ?>" style="<?php if ($idfavpro == "") { ?>display:inline-block<?php } ?>"><i class="fa-solid fa-heart-pulse" id="heartperfil"></i></div>
                            <a href='<?php echo $_ENV['APP_URL']; ?>perfilproo/<?php echo $lista["idpro"]; ?>' class="verperfil" id="verperfil"><button>Ver perfil</button></a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <script src="<?php echo $_ENV['APP_URL']; ?>js/bfav.js"></script>
    </main>
</body>
<?php echo footermed(); ?>

</html>