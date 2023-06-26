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

$urlactual = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($urlactual == 'https://themeduniverse.com/recuperarcadmin') {
    //echo "<script>window.location.href='" . $_ENV['APP_URL'] . "recuperarcadmin'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Cuenta - The Med Universe | Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/recuperarc.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formEnviarCodigo = document.getElementById("formEnviarCodigo");

            formEnviarCodigo.addEventListener("submit", async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                if ($("#correo").val() != '') {
                    let peticion = {
                        method: "post",
                        body: formData,
                    }
                    fetch("<?php echo $_ENV['APP_URL']; ?>php/enviarCodigoAdmin.php", peticion)
                        .then(respuesta => respuesta.json())
                        .then(async (respuesta) => {
                            if (respuesta["correo"] == "Este correo no existe") {
                                Swal.fire({
                                    title: 'Correo incorrecto',
                                    text: 'No se encontró ninguna cuenta con ese correo.',
                                    icon: 'error',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                });
                            } else {


                                await enviarCorreo(respuesta["correo"]);

                                const formData2 = new FormData();
                                formData2.append("token", respuesta["token"]);
                                formData2.append("correo1", formData.get("correo"));

                                fetch("<?php echo $_ENV['APP_URL']; ?>crudDespuesDeEnviarCorreo/actualizarAdministradores.php", {
                                        method: "post",
                                        body: formData2,
                                    })
                                    .then(respuesta => respuesta.text())
                                    .then(() => {
                                        Swal.fire({
                                            title: 'Código enviado',
                                            text: 'Ingrese el código que hemos enviado a su correo.',
                                            icon: 'success',
                                            confirmButtonColor: '#0052d4',
                                            confirmButtonText: 'Ok',
                                        }).then(() => {
                                            // cambiar la url a donde quieres redigirig
                                            window.location.replace("<?php echo $_ENV['APP_URL']; ?>restablecercadmin/" + respuesta["id"] + "/" + respuesta["token"]);
                                        });
                                    })


                            }
                        })
                }
            });
        });
    </script>
    <main>
        <div class="ctn-contra">
            <form id="formEnviarCodigo" method="POST" class="form-contra">
                <h2>RECUPERE SU CUENTA</h2>
                <p>Ingrese su correo electrónico y le enviaremos un código para restablecer su contraseña.</p>
                <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required><br>
                <input type='submit' value="Enviar" name="iniciar_sesion"><br>
                <hr id="hr-login">
                <div class="med-logos">
                    <img src="<?php echo $_ENV['APP_URL']; ?>images/med-asfrgb.png" class="med-login">
                    <img src="<?php echo $_ENV['APP_URL']; ?>images/med-rsfrgb.png" class="med-login">
                </div>
            </form>
        </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed(); ?>

</html>