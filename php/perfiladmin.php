<?php
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_SESSION['idAdmin'] == @$_GET['id']){
    $consulta = "SELECT * FROM administradores WHERE idAdmin = '".$_GET['id']."' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()){
            $nombres = $row['nombresAdmin'];
            $apellidos = $row['apellidosAdmin'];
            $nacimiento = $row['nacimientoAdmin'];
            $sexo = $row['sexoAdmin'];
            $pais = $row['paisAdmin'];
            $ciudad = $row['ciudadAdmin'];
            $enmu = $row['enmuAdmin'];
            $fotoperfil = $row['fotoperfilAdmin'];
            $estado = $row['estadoAdmin'];
            $indicaciones = $row['indicacionesAdmin'];
            //CAMBIAR FORMATO NACIMIENTO YYYY-mm-dd
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
            $timestampEnmu = strtotime($enmu); 
            $newDateEnmu = date("d/m/Y", $timestampEnmu );
        }
    }
    $consulta2 = "SELECT COUNT(title) FROM citas WHERE idadmin = '".$_GET['id']."' AND idpay <> '0' ";
    $resultado2 = mysqli_query($conexion, $consulta2);
    if ($resultado2) {
        while ($row2 = $resultado2->fetch_array()){
            $nrocitas = $row2['COUNT(title)'];
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."perfiladmin/".$_SESSION['idAdmin']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfiladmin/" . $_SESSION['idAdmin'] . "'</script>";
}
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombres.' '.$apellidos?> - The Med Universe | Administrador</title>
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfiladmin.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfil.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<?php echo headernav();include './php/navbarAdmin.php';?>
<body id="body">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/buscadorAdmin.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formRegistrarAdministrador = document.getElementById("formRegistrarAdministrador");

            formRegistrarAdministrador.addEventListener("submit", async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                if ($("#nombres").val() != '' && $("#apellidos").val() != '' && $("#correo").val() != '' && $("#contrasenar").val() != '' && $("#contrasenarcon").val() != '' && $("#nacimiento").val() != '' && $("#sexo").val() != '' && $("#pais").val() != '' && $("#ciudad").val() != '') {
                    let peticion = {
                        method: "post",
                        body: formData,
                    }
                    fetch("<?php echo $_ENV['APP_URL']; ?>php/validarCorreoAdmin.php", peticion)
                        .then(respuesta => respuesta.json())
                        .then(respuesta => {
                            if (respuesta["correo"] == "Este correo ya está en uso") {
                                Swal.fire({
                                    title: 'Correo no disponible',
                                    text: 'El correo ingresado ya está en uso.',
                                    icon: 'error',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                });
                            } else {
                                if ($("#contrasenar").val() != $("#contrasenarcon").val()) {
                                    Swal.fire({
                                        title: 'Contraseñas no coinciden',
                                        text: 'Las contraseñas ingresadas deben ser iguales.',
                                        icon: 'error',
                                        confirmButtonColor: '#0052d4',
                                        confirmButtonText: 'Ok',
                                    });
                                } else {
                                    const response = fetch("<?php echo $_ENV['APP_URL']; ?>php/crearCuentaAdmin.php", {
                                        method: "post",
                                        body: formData,
                                    })
                                    Swal.fire({
                                        title: 'Cuenta registrada',
                                        text: 'Inicie sesión para ingresar.',
                                        icon: 'success',
                                        confirmButtonColor: '#0052d4',
                                        confirmButtonText: 'Ok',
                                    }).then(() => {
                                        // cambiar la url a donde quieres redigirig
                                        window.location.reload();
                                    });
                                }
                            }
                        })
                }
            });
        });
    </script>
    <main>
    <div class="filauno">
        <div class="ctn-sideperfil" id="sideperfil">
            <form id="formFoto" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'].'fotoperfiladmin/mini_'.$fotoperfil. "?v=". rand()?>" id="fppro" alt="Foto de perfil">
                </div>
                <div class="ctn-previeimage" id="previewperfil">
                    <!-- <input type="range" id="zoomPerfil" name="zoomPerfil" value="0" step="2" min="0" max="500" style="width: 200px!important;"> -->
                    <canvas id="canvasPerfil" style="display:none"></canvas>
                </div>
                <div class="ctn-editarfp " id="labelfoto">
                    <input type="file" name="bbfile2" id="bbfile2" accept="image/*">
                    <label class="labelbbfile" for="bbfile2" name="bbfile" id="bbfile">Editar</label>
                </div>
                <div class="ctn-guardarfp" id="ctn-editfoto">
                    <input class="labeleditfoto" type="submit" name="editfoto" id="editfoto" value="Guardar"><br>
                </div>
            </form>
        </div>
        
        <?php
        if(isset($_POST['editfoto'])){

            $tips = 'jpg';
            $type = array('image/jpeg' => 'jpg');

            $nombrefoto1 = $_FILES['bbfile2']['name'];
            $ruta1 = $_FILES['bbfile2']['tmp_name'];
            $name = $_SESSION["idAdmin"].'.'.$tips;
            $destino1 = "fotoperfiladmin/".$name;
            $destinoMini = "fotoperfiladmin/mini_".$name;

            file_put_contents($destinoMini, base64_decode($_POST['fotoMini']));

            if(is_uploaded_file($ruta1)){
                copy($ruta1, $destino1);
            }
            $sql = mysqli_query($conexion, "UPDATE administradores SET fotoperfilAdmin = '$name' WHERE idAdmin = '" . $_SESSION["idAdmin"] . "' ");
            if ($sql){header("location: perfiladmin/".$_SESSION["idAdmin"]."");}
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
                ?>
                <p id="nacimientoperfil"><span>Fecha de nacimiento (Edad):</span> <?php echo $newDateNac?> (<?php echo $edad?> años)</p>
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
                    <h2 id="nombreperfil"><input type="text" placeholder="Nombres" value="<?php echo $nombres?>" name="nombres" id="nombres"><input type="text" placeholder="Apellidos" value="<?php echo $apellidos?>" name="apellidos" id="apellidos"></h2>
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
                    <p id="ciudadperfil2"><span>Ciudad:</span><input type="text" placeholder="Ciudad" name="ciudad" id="ciudad" value="<?php echo $ciudad?>"></p><br>
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

            $sql2 = mysqli_query($conexion, "UPDATE administradores SET nombresAdmin = '$nombresnew', apellidosAdmin = '$apellidosnew', nacimientoAdmin = '$nacimientonew', sexoAdmin = '$sexonew', paisAdmin = '$paisnew', ciudadAdmin = '$ciudadnew' WHERE idAdmin = '".$_SESSION["idAdmin"]."' ");
            /* if ($sql2){header("location: perfil/".$id."");} */
        }
        ?>
        <?php
        if($estado=='2'){
        ?>
        <div class="revision" style="margin-bottom:0px">
            <h2>CUENTA BLOQUEADA...</h2>
            <p>The Med Universe ha bloqueado su cuenta, por cuestiones de seguridad y/o alguna infracción de los Términos y Condiciones de uso de la plataforma y/o acuerdos consignados en su contratación. Revise las observaciones de su cuenta y haga las correcciones necesarias.</p>
        </div>
        <div class="filatres" style="padding-bottom:0px;margin-bottom:25px">
            <div class="ctn-perfil observaciones" id="perfil1">
                <div class="ctn-editarp">
                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                </div>
                <hr id="edit-infb">
                <ul><li><?php echo $indicaciones; ?></li></ul>
                    <p style="width:100%">Para recibir mayor orientación sobre cómo resolver las observaciones de su cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
            </div>
        </div>
        <?php
        }else{
        ?>
        <div class="ctn-herramientasperfil" style="margin-bottom:25px">
            <a href="<?php echo $_ENV['APP_URL'].'agendaadmin/'.$_SESSION["idAdmin"]?>" id="bcfiled1">Agenda</a>
            <a href="<?php echo $_ENV['APP_URL'].'libroreclamaciones'?>" id="alibror">Libro de Reclamaciones</a>
            <a href="<?php echo $_ENV['APP_URL'].'historialadmin/'.$_SESSION["idAdmin"]?>" id="bcfiled4">Historial de Pagos</a>
        </div>
        <div class="ctn-herramientasperfil" style="margin-bottom:25px">
            <a href="<?php echo $_ENV['APP_URL'].'pacientes'?>" id="alistapac">Lista de Pacientes</a>
            <a href="<?php echo $_ENV['APP_URL'].'administradores'?>" id="alistaad">Lista de Administradores</a>
        </div>
        <div class="ctn-herramientasperfil" style="margin-bottom:25px">
            <?php
            if($_SESSION['idAdmin']=='1'){
            ?>
            <a href="<?php echo $_ENV['APP_URL'].'pagospro'?>" id="pagopro">Pago a Profesionales</a>
            <a href="<?php echo $_ENV['APP_URL'].'pagosadmin'?>" id="pagoadmin">Pago a Administradores</a>
            <?php
            }
            ?>
        </div>
        <?php
            if($_SESSION['idAdmin']=='1'){
            ?>
            <div id="mainadmin">
                <div class="contenedor__todo">
                    <div class="caja__trasera" style="background:transparent">
                    </div>
        
                    <!--Formulario de Login y registro-->
                    <div class="contenedor__login-register">
        
                        <!--Register-->
                        <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                        <form id="formRegistrarAdministrador" method="POST" class="formulario__register">
                            <h2>REGISTRA UN ADMINISTRADOR</h2>
                            <div class="filaregister">
                                <input type="text" placeholder="Nombres" name="nombres" id="nombres" required>
                                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required><br>
                            </div>
                            <div class="filaregister">
                                <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required>
                            </div>
                            <div class="filaregister">
                                <span class="icon-eye eye1"><i class="fa-solid fa-eye-slash"></i></span>
                                <input type="password" placeholder="Contraseña" name="contraseña" id="contrasenar" minlength="6" required>
                                <span class="icon-eye eye2"><i class="fa-solid fa-eye-slash"></i></span>
                                <input type="password" placeholder="Confirmar" name="contraseñacon" id="contrasenarcon" minlength="6" required>
                            </div>
                            <div class="filaregister">
                                <input type="date" name="nacimiento" id="nacimiento" min="1905-01-01" required>
                                <select name="sexo" id="sexo" required>
                                    <option class="select-opt" value="">Género</option>
                                    <option class="select-opt" value="Masculino">Masculino</option>
                                    <option class="select-opt" value="Femenino">Femenino</option>
                                    <option class="select-opt" value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="filaregister">
                                <select name="pais" id="pais" required>
                                    <option class="select-opt" value="">País</option>
                                    <?php
        
                                    include './php/conexion_paciente.php';
        
                                    $selectm = "SELECT * FROM paises";
                                    $ejecutar = mysqli_query($conexion, $selectm);
        
                                    ?>
        
                                    <?php foreach ($ejecutar as $opciones) : ?>
        
                                        <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>
        
                                    <?php endforeach ?>
                                </select>
                                <input type="text" placeholder="Ciudad" name="ciudad" id="ciudad" required><br>
                            </div>
                            <hr id="hr-register">
                            <p>Al hacer clic en "Registrar" y usar la cuenta creada, el nuevo administrador acepta nuestros <a href="<?php echo $_ENV['APP_URL']; ?>terycon">Términos y Condiciones</a>, la
                                <a href="<?php echo $_ENV['APP_URL']; ?>privacidad">Política de Privacidad</a> y la <a href="<?php echo $_ENV['APP_URL']; ?>cookies">Política de Cookies</a>.
                            </p>
                            <input type='submit' value="Registrar" name="registrarse">
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        <?php
        }
        ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/previewperfil.js?v=<?php echo rand();?>"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/guardar.js"></script>
</body>
<?php echo footermed();?>
</html>