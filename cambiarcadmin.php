<?php
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
include './php/conexion_paciente.php';
include './configuracion.php';

include './php/footer.php';
include './seguridad.php';

$seguridad = new Seguridad($conexion, "");
$seguridad->verificarSiYaEstoyLogeado();

$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/cambiarcadmin') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "cambiarcadmin'</script>";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Recuperar Cuenta - The Med Universe | Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/recuperarc.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener("DOMContentLoaded", function(){
        const nueva_contra = document.getElementById("nueva-contra");

        nueva_contra.addEventListener("submit", async function(e){
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("id", <?php echo explode("/", $_GET['view'])[1]?>);
            formData.append("token", "<?php echo explode("/", $_GET['view'])[2];?>");
            formData.append("codigo", "<?php echo explode("/", $_GET['view'])[3];?>");
            if($("#contraseña").val()!='' && $("#contraseñac").val()!=''){
                if($("#contraseña").val()!=$("#contraseñac").val()){
                    Swal.fire({
                        title: 'Contraseñas no coinciden',
                        text: 'Las contraseñas ingresadas deben ser iguales.',
                        icon: 'error',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    });
                } else{
                    const response = fetch("<?php echo $_ENV['APP_URL'];?>php/cambiarContraseñaAdmin.php", {
                        method: "post",
                        body: formData,
                    })
                    Swal.fire({
                        title: 'Contraseña guardada',
                        text: 'Inicie sesión para ingresar.',
                        icon: 'success',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    }).then(() => {
                            // cambiar la url a donde quieres redigirig
                            window.location.replace("<?php echo $_ENV['APP_URL'];?>loginadmin");
                        });
                }
            }
        });
    });
</script>
    <main>
        <div class="ctn-contra">
            <form id="nueva-contra" method="POST" class="form-contra">
                <h2>RECUPERE SU CUENTA</h2>
                <span class="icon-eye" id="icon-eye-login1"><i class="fa-solid fa-eye-slash"></i></span>
                <input type="password" placeholder="Nueva contraseña" name="contraseña" id="contraseña" minlength="6" maxlength="75" required><br>
                <span class="icon-eye" id="icon-eye-login2"><i class="fa-solid fa-eye-slash"></i></span>
                <input type="password" placeholder="Confirmar nueva contraseña" name="contraseñac" id="contraseñac" minlength="6" maxlength="75" required><br>
                <input type='submit' value="Guardar" id="ccambiar" name="iniciar_sesion"><br>
                <hr id="hr-login">
                <div class="med-logos">
                    <img src="<?php echo $_ENV['APP_URL'];?>images/med-asfrgb.png" class="med-login">
                    <img src="<?php echo $_ENV['APP_URL'];?>images/med-rsfrgb.png" class="med-login">
                </div>
            </form>
        </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL'];?>js/script2.js"></script>
</body>
<?php echo footermed();?>
</html>