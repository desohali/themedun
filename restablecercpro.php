<?php
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();
include './php/conexion_paciente.php';
include './configuracion.php';
//include './php/restablecercpro.php';
include './php/footer.php';
include './seguridad.php';

$seguridad = new Seguridad($conexion, "");
$seguridad->verificarSiYaEstoyLogeado();

$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/restablecercpro') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "restablecercpro'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Cuenta - The Med Universe | Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/recuperarc.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
</head>

<body>
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formComprobarCodigo = document.getElementById("formComprobarCodigo");

            formComprobarCodigo.addEventListener("submit", async function(e) {
                e.preventDefault();

            const formData = new FormData(this);
            formData.append("idpro", <?php echo explode("/", $_GET['view'])[1]?>);
            formData.append("token", "<?php echo explode("/", $_GET['view'])[2];?>");
            if($("#codigo").val()!=''){
                let peticion = {
                    method: "post",
                    body: formData,
                }
                fetch("<?php echo $_ENV['APP_URL'];?>php/comprobarCodigoPro.php", peticion)
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    if(respuesta["codigo"]=="Este codigo no existe"){
                        Swal.fire({
                            title: 'Código incorrecto',
                            text: 'No se encontró ninguna cuenta con ese código.',
                            icon: 'error',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        });
                    } else{
                        Swal.fire({
                            title: 'Código correcto',
                            text: 'Ingrese su nueva contraseña.',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then(() => {
                                // cambiar la url a donde quieres redigirig
                                window.location.replace("<?php echo $_ENV['APP_URL'];?>cambiarcpro/"+respuesta["idpro"]+"/"+respuesta["tokenpro"]+"/"+respuesta["codigo"]);
                            });
                    }
                })
            }
        });
    });
</script>
    <main>
        <div class="ctn-contra">
            <form id="formComprobarCodigo" method="POST" class="form-contra">
                <h2>RECUPERE SU CUENTA</h2>
                <p>Ingrese el código de seguridad que enviamos a su correo electrónico.</p>
                <input type="number" placeholder="Código de seguridad" name="codigo" id="codigo" min="0" required><br><br>
                <input type='submit' value="Comprobar" id="crestablecer" name="iniciar_sesion"><br>
                <hr id="hr-login">
                <div class="med-logos recuperar">
                    <p id="fraselogin">ATENCIÓN MÉDICA SIN FRONTERAS</p>
                </div>
            </form>
        </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed(); ?>

</html>