<?php
if (explode("/", $_GET['view'])[1]==''){
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pacientes'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$pacientesRegistrados='';
$consultavistas ="SELECT id FROM usuarios WHERE id = '".$_GET['id']."'";
$consultares=mysqli_query($conexion, $consultavistas);
while ($lista=mysqli_fetch_array($consultares)) {
    $pacientesRegistrados = $lista['id'];
}
if (isset($_GET['id']) && @$_GET['id']==@$pacientesRegistrados){
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
            $indica = preg_replace("/<br \/>/" , "" , $indicaciones);
            //CAMBIAR FORMATO NACIMIENTO YYYY-mm-dd
            $timestampNac = strtotime($nacimiento); 
            $newDateNac = date("d/m/Y", $timestampNac );
            $timestampEnmu = strtotime($enmu); 
            $newDateEnmu = date("d/m/Y", $timestampEnmu );
        }
    }
    $consulta2 = "SELECT COUNT(title) FROM citas WHERE id = '".$_GET['id']."' AND idpay <> '0' ";
    $resultado2 = mysqli_query($conexion, $consulta2);
    if ($resultado2) {
        while ($row2 = $resultado2->fetch_array()){
            $nrocitas = $row2['COUNT(title)'];
        }
    }
}else{
    //header("Location: ".$_ENV['APP_URL']."pacientes");
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "pacientes'</script>";
}
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombres.' '.$apellidos?> - The Med Universe | Administrador</title>
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/perfil.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<?php echo headernav();include './php/navbarAdmin.php';?>
<body id="body">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/buscador.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function(){
            const formDesbloquear = document.getElementById("formDesbloquear");
    
            formDesbloquear.addEventListener("submit", async function(e){
                e.preventDefault();
                const {isConfirmed} = await Swal.fire({
                    title: 'Cuenta de usuario',
                    text: "¿Está seguro de desbloquear esta cuenta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00d418',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, desbloquear',
                    cancelButtonText: 'No'
                });
        
                if (isConfirmed) {
                    const formData = new FormData(this);
                    formData.append("id", <?php echo $id;?>);
                    formData.append("idadmin", <?php echo $_SESSION['idAdmin'];?>);
                    const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/desbloquearCuenta.php", {
                        method: "post",
                        body: formData
                    });
                        const text = await Swal.fire({
                            title: 'Cuenta de usuario desbloqueada',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            window.location.reload();
                            });
                };
            });
        });
        window.addEventListener("DOMContentLoaded", function(){
            const formBloquear = document.getElementById("formBloquear");
    
            formBloquear.addEventListener("submit", async function(e){
                e.preventDefault();
                const {isConfirmed} = await Swal.fire({
                    title: 'Cuenta',
                    text: "¿Está seguro de bloquear esta cuenta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, bloquear',
                    cancelButtonText: 'No'
                });
        
                if (isConfirmed) {
                    const formData = new FormData(this);
                    formData.append("id", <?php echo $id;?>);
                    formData.append("idadmin", <?php echo $_SESSION['idAdmin'];?>);
                    const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/bloquearCuenta.php", {
                        method: "post",
                        body: formData
                    });
                        const text = await Swal.fire({
                            title: 'Cuenta bloqueada',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            window.location.reload();
                            });
                };
            });
        });
    </script>
    <main>
    <div class="filauno" id="filapaciente">
        <?php
        if($estado == '1'){
        ?>
        <div class="ctn-sideperfil ctn-bloquear" id="sidepaciente">
        <?php
        }else{
        ?>
        <div class="ctn-sideperfil" id="sidepaciente">
        <?php
        }?>
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'].'fotoperfil/mini_'.$fotoperfil. "?v=". rand()?>" id="fppro" alt="Foto de perfil">
                </div>
                <?php
                if($estado == '2'){
                ?>
                <div class="ctn-guardarfp" id="ctn-editfoto" style="display:block;">
                <form id="formDesbloquear" method="post">
                    <br><input class="btndesbloquear" type="submit" name="desbloquearfoto" id="editfoto" value="Desbloquear" style="margin-top:0px"><br>
                </form>
                </div>
                <?php
                }else{
                ?>
                <div class="ctn-guardarfp" id="ctn-editfoto" style="display:block;">
                <form id="formBloquear" method="post">
                    <br><input class="btnbloquear" type="submit" name="bloquear" id="editfoto" value="Bloquear" style="margin-top:0px">
                    <hr id="edit-infb">
                    <textarea style="margin-bottom:0px" name="observaciones" placeholder='Observaciones a corregir por el usuario.' rows="5" required></textarea>
                </form>
                </div>
                <?php
                }
                ?>
        </div>
        <div class="ctn-perfil ctn-paciente" id="perfil1">
            <div class="ctn-editarp">
                <h2>INFORMACIÓN PERSONAL</h2>
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
    </div>
    <?php
    if($estado == '2'){
    ?>
    <div class="revision" id="revipac">
        <h2>CUENTA BLOQUEADA...</h2>
        <p>The Med Universe se reserva la posibilidad de bloquear al usuario, por cuestiones de seguridad y/o alguna infracción de los Términos y Condiciones de uso de la plataforma.</p>
    </div>
    <div class="filatres">
        <div class="ctn-perfil observaciones" id="perfil3">
            <div class="ctn-editarp">
                <h2>OBSERVACIONES DE LA CUENTA</h2>
                <div class="divinper">
                    <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                </div>
            </div>
            <hr id="edit-infb">
            <ul><li><?php echo $indicaciones; ?></li></ul>
                    <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
        </div>
            <div class="ctn-perfil2 observaciones" id="perfil4">
                <form action="" method="post">
                <div class="ctn-editarp">
                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                    <div class="divinper">
                        <div class="ctn-guardarip" id="ctn-editip">
                            <input type="submit" name="editip3" id="editip" value="Guardar">
                        </div>
                    </div>
                </div>
                <hr id="edit-infb">
                <textarea class="txtobserva3" name="observaciones3" id="txtobserva" rows="3" required><?php echo $indica?></textarea>
                    <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
                </form>
            </div>
            <?php
        if(isset($_POST['editip3'])){
            $observaciones3 = nl2br(ucfirst($_POST['observaciones3']));

            $sql9 = mysqli_query($conexion, "UPDATE usuarios SET indicaciones = '$observaciones3' WHERE id = '".$id."' ");
            if ($sql9) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfilpaciente/" . $id . "'</script>";
            }
        }
        ?>
    </div>
    <?php
    }
    ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/previewobservaciones2.js"></script>
</body>
<?php echo footermed();?>
</html>