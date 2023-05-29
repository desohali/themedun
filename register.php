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

if ($urlactual=='https://themeduniverse.com/register') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "register'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>The Med Universe | Paciente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/stylesrpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/inicio.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formRegistrarPaciente = document.getElementById("formRegistrarPaciente");

            formRegistrarPaciente.addEventListener("submit", async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                if ($("#nacimiento").val() != '') {
                    let peticion = {
                        method: "post",
                        body: formData,
                    }
                    fetch("<?php echo $_ENV['APP_URL']; ?>php/validarCorreo.php", peticion)
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
                                    const response = fetch("<?php echo $_ENV['APP_URL']; ?>php/crearCuenta.php", {
                                        method: "post",
                                        body: formData,
                                    })
                                    Swal.fire({
                                        title: 'Verificación de cuenta',
                                        text: 'Para completar la creación de tu cuenta, ingresa al enlace de verificación que hemos enviado a tu correo.',
                                        icon: 'warning',
                                        confirmButtonColor: '#0052d4',
                                        confirmButtonText: 'Ok',
                                    }).then(() => {
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
        <div class="titulo__frase">
            <h1 id="frasecompleta">
                <pre><h1 id="mu">The Med Universe |</h1> <h1 id="px">Paciente</h1></pre>
            </h1>
            <p>The Med Universe es la nueva app que conecta médicos y pacientes de diferentes partes del mundo.</p>
            <a href="<?php echo $_ENV['APP_URL']; ?>loginpro">The Med Universe | Profesional</a>
        </div>
        <div class="contenedor__todo">
            <div class="caja__trasera caja_rgs">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para ingresar</p>
                <a href="<?php echo $_ENV['APP_URL']; ?>"><button id="btn__iniciar-sesion">Iniciar sesión</button></a>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">

                <!--Register-->
                <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                <form id="formRegistrarPaciente" method="POST" class="formulario__register">
                    <h2>REGÍSTRATE</h2>
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
                        <input type="text" name="nacimiento" placeholder="F. Nacimiento"
                    onfocus="(this.type='date')" onblur="(this.type='text')"  min="1905-01-01" id="nacimiento" required>
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
                    <p>Al hacer clic en "Registrarte", aceptas nuestros <a href="<?php echo $_ENV['APP_URL']; ?>terycon">Términos y Condiciones</a>, la
                        <a href="<?php echo $_ENV['APP_URL']; ?>privacidad">Política de Privacidad</a> y la <a href="<?php echo $_ENV['APP_URL']; ?>cookies">Política de Cookies</a>.
                    </p>
                    <input type='submit' value="Registrarte" name="registrarse">
                </form>
            </div>
        </div>
        <?php echo iniciomed($pacOpro); ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed(); ?>

</html>