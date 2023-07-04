<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();

$pacOpro='paciente';

include './php/conexion_paciente.php';
include './php/inicio.php';
include './php/footer.php';
include './configuracion.php';
include './seguridad.php';

$seguridad = new Seguridad($conexion, "");
$seguridad->verificarSiYaEstoyLogeado();

$urlactual='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($urlactual=='https://themeduniverse.com/') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Med Universe | Paciente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/inicio.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formLogin = document.getElementById("formLogin");

            formLogin.addEventListener("submit", async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                if ($("#correo").val() != '' && $("#contraseña").val() != '') {
                    let peticion = {
                        method: "post",
                        body: formData,
                    }
                    fetch("<?php echo $_ENV['APP_URL']; ?>php/validarLogin.php", peticion)
                        .then(respuesta => respuesta.json())
                        .then(respuesta => {
                            if (respuesta["correo"] == "Este correo no existe") {
                                Swal.fire({
                                    title: 'Correo incorrecto',
                                    text: 'No se encontró ninguna cuenta con ese correo.',
                                    icon: 'error',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                });
                            } else {
                                if (respuesta["contraseña"] == "Contraseña incorrecta") {
                                    Swal.fire({
                                        title: 'Contraseña incorrecta',
                                        text: 'La contraseña ingresada no corresponde al correo.',
                                        icon: 'error',
                                        confirmButtonColor: '#0052d4',
                                        confirmButtonText: 'Ok',
                                    });
                                } else {
                                    Swal.fire({
                                        title: '¡Bienvenido a The Med Universe!',
                                        text: 'Cuidar tu salud nunca fue tan fácil...',
                                        imageUrl: "<?php echo $_ENV['APP_URL']; ?>images/med-isfrgb.png",
                                        imageWidth: 150,
                                        imageHeight: 150,
                                        imageAlt: "The Med Universe",
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true,
                                    }).then(() => {
                                        // cambiar la url a donde quieres redigirig
                                        if (respuesta["estado"] == "1") {
                                            window.location.replace("<?php echo $_ENV['APP_URL']; ?>home");
                                        } else {
                                            window.location.replace("<?php echo $_ENV['APP_URL']; ?>perfil/" + respuesta["id"]);
                                        }
                                    });
                                }
                            }
                        })
                }
            });
        });
    </script>
    <main>
        <div class="titulo__frase">
            <h1 id="frasecompleta">
                <pre><h1 id="mu">The Med Universe |</h1> <h1 id="px">Paciente</h1></pre>
            </h1>
            <p>The Med Universe es la nueva app que conecta médicos y pacientes de diferentes partes del mundo.</p>
            <a href="<?php echo $_ENV['APP_URL']; ?>loginpro">The Med Universe | Profesional</a>
        </div>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Regístrate para iniciar sesión</p>
                <a href="<?php echo $_ENV['APP_URL']; ?>register"><button id="btn__registrarse">Registrarse</button></a>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">

                <!--Login-->
                <form id="formLogin" action="" method="POST" class="formulario__login">
                    <h2>INICIA SESIÓN</h2>
                    <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required>
                    <span class="icon-eye eye1" id="icon-eye-login"><i class="fa-solid fa-eye-slash"></i></span>
                    <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" minlength="6" required>
                    <input type='submit' value="Iniciar sesión" name="iniciar_sesion"><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>recuperarc">¿Olvidaste tu contraseña?</a>
                    <hr id="hr-login">
                    <div class="med-logos">
                        <p id="fraselogin">ATIÉNDETE DESDE CASA</p>
                    </div>
                </form>
            </div>
        </div>
        <?php echo iniciomed($pacOpro); ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed(); ?>

</html>