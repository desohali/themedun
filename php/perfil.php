<?php
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_GET['id'] == @$_SESSION['id']){
    $consulta = "SELECT * FROM usuarios WHERE id = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $id = $row['id'];
            $nombres = $row['nombres'];
            $apellidos = $row['apellidos'];
            $nacimiento = $row['nacimiento'];
            $sexo = $row['sexo'];
            $pais = $row['pais'];
            $ciudad = $row['ciudad'];
            $enmu = $row['enmu'];
            $fotoperfil = $row['fotoperfil'];
            $estado = $row['estado'];
            $indicaciones = $row['indicaciones'];
            //CAMBIAR FORMATO NACIMIENTO YYYY-mm-dd
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
            $timestampEnmu = strtotime($enmu); 
            $newDateEnmu = date("d/m/Y", $timestampEnmu );
        }
    }
    $consulta2 = "SELECT COUNT(title) FROM citas WHERE id = '".$_GET['id']."' AND idpay <> '0' AND asistencia <> 'No asistió' AND asistenciapac <> 'No asistió' ";
    $resultado2 = mysqli_query($conexion, $consulta2);
    if ($resultado2) {
        while ($row2 = $resultado2->fetch_array()){
            $nrocitas = $row2['COUNT(title)'];
        }
    }
}else{
    if ($seguridad->verificarInicioDeSesionPaciente()) {
        //header("Location: ".$_ENV['APP_URL']."perfil/".$_SESSION['id']);
        echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfil/" . $_SESSION['id'] . "'</script>";
    }
}
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombres.' '.$apellidos?> - The Med Universe | Paciente</title>
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfil.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<?php echo headernav();include './php/navbar.php';?>
<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/buscador.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="filauno">
        <div class="ctn-sideperfil" id="sideperfil">
            <form id="formFoto" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'].'fotoperfil/mini_'.$fotoperfil. "?v=". rand()?>" class="zoom-effect" id="fppro" alt="Foto de perfil" data-toggle="modal" data-target="#modalFotoPerfil">
                </div>
                <div class="ctn-previeimage" id="previewperfil">
                    <!-- <input type="range" id="zoomPerfil" name="zoomPerfil" value="0" step="2" min="0" max="500" style="width: 200px!important;"> -->
                    <canvas id="canvasPerfil" style="display:none"></canvas>
                </div>
                <div class="ctn-editarfp" id="labelfoto">
                    <input type="file" name="bbfile2" id="bbfile2" accept="image/*">
                    <label class="labelbbfile" for="bbfile2" name="bbfile" id="bbfile">Editar</label>
                </div>
                <div class="ctn-guardarfp" id="ctn-editfoto">
                    <input class="labeleditfoto" type="submit" name="editfoto" id="editfoto" value="Guardar"><br>
                </div>
            </form>
        </div>

<!-- Modal -->
<div class="modal fade" id="modalFotoPerfil" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL'] . "fotoperfil/" . $fotoperfil . "?v=" . rand()?>" alt="Foto de perfil agrandada" id="modalFotoAgrandada">
            </div>
        </div>
    </div>
</div>
        
        <?php
        if(isset($_POST['editfoto'])){

            $tips = 'jpg';
            $type = array('image/jpeg' => 'jpg');

            $nombrefoto1 = $_FILES['bbfile2']['name'];
            $ruta1 = $_FILES['bbfile2']['tmp_name'];
            $name = $_SESSION["id"].'.'.$tips;
            $destino1 = "fotoperfil/".$name;
            $destinoMini = "fotoperfil/mini_".$name;

            file_put_contents($destinoMini, base64_decode($_POST['fotoMini']));

            if(is_uploaded_file($ruta1)){
                copy($ruta1, $destino1);
            }
            if($fotoperfil=='defect.jpg'){
                $sql = mysqli_query($conexion, "UPDATE usuarios SET fotoperfil = '$name' WHERE id = '".$id."' ");
            }
            header("location: perfil/".$id."");
        }
        ?>
        <div class="ctn-perfil primerperfil" id="perfil1">
            <div class="ctn-editarp">
                <h2>INFORMACIÓN PERSONAL</h2>
                <div class="divinper">
                    <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                </div>
            </div>
            <hr id="edit-infb">
            <div class="ctn-infbasica">
                <h2 id="nombreperfil"><?php echo $nombres.' '.$apellidos?></h2>
                <hr>
                <?php
                $fecha = time() - strtotime($nacimiento);
                $edad = floor($fecha / 31556926);
                if($edad=='1'){
                    $año="año";
                }else{
                    $año="años";
                }
                ?>
                <p id="nacimientoperfil"><span>Fecha de nacimiento<span class="spanedad"> (Edad)</span>:</span> <?php echo $newDateNac?><span class="spanedad" id="idedad"> (<?php echo $edad." ".$año?>)</span></p>
                <p id="edadperfil"><span>Edad:</span> <?php echo $edad?> años</p>
                <p id="sexoperfil"><span>Género:</span> <?php echo $sexo?></p><br>
                <p id="paisperfil"><span>País:</span> <?php echo $pais?></p>
                <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $ciudad?></p><br>
                <hr>
                <p id="enmudesde"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu?></p>
                <p id="consultasperfil"><span>Citas en The Med Universe:</span> <?php echo $nrocitas?></p><br>
            </div>
        </div>
        <div class="ctn-perfil2 segundoperfil" id="perfil2">
            <form action="" method="post" name="form2" id="form2">
                <div class="ctn-editarp">
                    <h2>INFORMACIÓN PERSONAL</h2>
                    <div class="divinper">
                        <div class="ctn-guardarip" id="ctn-editip">
                            <input type="submit" name="editip" id="editip" value="Guardar">
                        </div>
                    </div>
                </div>
                <hr id="edit-infb">
                <div class="ctn-infbasica">
                    <h2 id="nombreperfil"><input type="text" placeholder="Nombres" value="<?php echo $nombres?>" name="nombres" id="nombres" maxlength="50"><input type="text" placeholder="Apellidos" value="<?php echo $apellidos?>" name="apellidos" id="apellidos" maxlength="50"></h2>
                    <hr>
                    <p id="nacimientoperfil"><span>Fecha de nacimiento:</span><input type="date" name="nacimiento" id="nacimiento" min="1905-01-01" value="<?php echo $nacimiento?>"></p>
                    <p id="sexoperfil"><span>Género:</span><select name="sexo" id="sexo"><option class="select-opt" selected><?php echo $sexo?></option><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option><option value="Otro">Otro</option></select></p><br>
                    <p id="paisperfil2"><span>País:</span><select class="paisperfil" name="pais" id="pais">
                        <option class="select-opt" selected><?php echo $pais?></option>
                    <?php 

                        include 'conexion_paciente.php';

                        $selectm = "SELECT * FROM paises";
                        $ejecutar = mysqli_query($conexion,$selectm) or die(mysqli_error($conexion));

                    ?>

                    <?php foreach ($ejecutar as $opciones): ?>

                        <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>

                    <?php endforeach?>
                    </select></p>
                    <p id="ciudadperfil2"><span>Ciudad:</span><input type="text" placeholder="Ciudad" name="ciudad" id="ciudad" value="<?php echo $ciudad?>" maxlength="50"></p><br>
                    <hr>
                    <p id="enmudesde"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu?></p>
                    <p id="consultasperfil"><span>Citas en The Med Universe:</span> <?php echo $nrocitas?></p><br>
                </div>
            </form>
        </div>
    </div>
        <?php
        if(isset($_POST['editip'])){
            if($_POST['nombres'] != ''){
                $nombresnew = ucwords($_POST['nombres']);
            }else{
                $nombresnew = $nombres;
            };
            if($_POST['apellidos'] != ''){
                $apellidosnew = ucwords($_POST['apellidos']);
            }else{
                $apellidosnew = $apellidos;
            }
            if($_POST['nacimiento'] != ''){
                $nacimientonew = $_POST['nacimiento'];
            }else{
                $nacimientonew = $nacimiento;
            }
            if($_POST['sexo'] != ''){
                $sexonew = $_POST['sexo'];
            }else{
                $sexonew = $sexo;
            }
            if($_POST['pais'] != ''){
                $paisnew = $_POST['pais'];
            }else{
                $paisnew = $pais;
            }
            if($_POST['ciudad'] != ''){
                $ciudadnew = ucwords($_POST['ciudad']);
            }else{
                $ciudadnew = $ciudad;
            }

            include './php/conexion_paciente.php';

            $sql2 = mysqli_query($conexion, "UPDATE usuarios SET nombres = '$nombresnew', apellidos = '$apellidosnew', nacimiento = '$nacimientonew', sexo = '$sexonew', pais = '$paisnew', ciudad = '$ciudadnew' WHERE id = '".$id."' ");
            /* if ($sql2){header("location: perfil/".$id."");} */
        }
        ?>
        <?php
        if($estado=='2'){
        ?>
        <div class="revision" style="margin-bottom:0px">
            <h2>CUENTA BLOQUEADA...</h2>
            <p>The Med Universe ha bloqueado tu cuenta, por cuestiones de seguridad y/o alguna infracción de los Términos y Condiciones de uso de la plataforma. Revisa las observaciones de tu cuenta y haz las correcciones necesarias.</p>
        </div>
        <div class="filatres" style="padding-bottom:0px;margin-bottom:25px">
            <div class="ctn-perfil observaciones" id="perfil1">
                <div class="ctn-editarp">
                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                </div>
                <hr id="edit-infb">
                <ul><li><?php echo $indicaciones; ?></li></ul>
                    <p style="width:100%">Para recibir mayor orientación sobre cómo resolver las observaciones de tu cuenta, puedes contactarnos por correo o WhatsApp.<br><br><a id="awsp" href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
            </div>
        </div>
        <?php
        }else{
            $consultacita = "SELECT idpay FROM citas WHERE idpay <> '0' AND start=(SELECT MAX(start) FROM citas WHERE id='".$id."' AND idpay <> '0' AND asistenciapac <> 'No Asistió' AND asistencia <> 'No Asistió')";
            $resultadocita = mysqli_query($conexion, $consultacita);
            if ($resultadocita) {
                while ($rowcita = $resultadocita->fetch_array()){
                    $idHistoria = $rowcita['idpay'];
                }
            }
        ?>
        <div class="ctn-herramientasperfil">
            <a href="<?php echo $_ENV['APP_URL'].'agenda/'.$id?>" id="bcfiled1">Agenda</a>
            <a href="<?php echo $_ENV['APP_URL'].'hclinica/'.$id.'/'.$idHistoria;?>" id="bcfiled2">Historia Clínica</a>
            <a href="<?php echo $_ENV['APP_URL'].'historial/'.$id?>" id="bcfiled4">Historial de Pagos</a>
        </div>
        <?php
        }
        ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL'];?>js/previewperfil.js?v=<?php echo rand();?>"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/guardar.js"></script>
</body>
<?php echo footermed();?>
</html>