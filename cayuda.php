<?php
include './php/footer.php';
include './configuracion.php';
include './seguridad.php';

$urlactual = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($urlactual == 'https://themeduniverse.com/cayuda') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "cayuda'</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Centro de Ayuda - The Med Universe</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/cayuda.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formAyuda = document.getElementById("nueva-contra");

            formAyuda.addEventListener("submit", async function(e) {
                e.preventDefault();
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Consulta',
                    text: "¿Estás seguro de enviar tu consulta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00d418',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'No'
                });

                if (isConfirmed) {
                    const formData = new FormData(this);
                    if ($("#correo").val() != '') {
                        const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/enviarAyuda.php", {
                            method: "post",
                            body: formData
                        });
                        const json = await response.json();

                        const [primerCorreo] = json;
                        await enviarCorreo(primerCorreo);
                        const text = await Swal.fire({
                            title: 'Consulta enviada',
                            text: 'Atenderemos tu consulta mediante mensajes a cualquiera de los medios proporcionados.',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            window.location.reload();
                        });
                    };
                };
            });
        });
    </script>
    <main>
        <div id="img-cayuda">
            <img src="<?php echo $_ENV['APP_URL']; ?>images/med-isfrgb.png">
        </div>
        <div class="ctn-contra">
            <form id="nueva-contra" method="POST" class="form-contra">
                <h2>CENTRO DE AYUDA</h2>
                <input type="text" placeholder="Nombres" name="nombres" id="nombres" required>
                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required><br>
                <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required>
                <input type="text" placeholder="N° de celular" name="telefono" id="telefono" required><br>
                <select name="pais" id="pais" required>
                    <option class="select-opt" value="">País</option>
                    <?php

                    include './php/conexion_paciente.php';

                    $selectm = "SELECT * FROM paises";
                    $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                    ?>

                    <?php foreach ($ejecutar as $opciones) : ?>

                        <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>

                    <?php endforeach ?>
                </select>
                <input type="text" placeholder="Ciudad" name="ciudad" id="ciudad" required><br>
                <textarea id="cuenta" name="cuenta" onkeypress="return validarn(event)" placeholder='Cuéntanos, ¿cómo te podemos ayudar?' class="txtcuenta" rows="5" required></textarea>
                <input type='submit' value="Enviar" id="caenviar" name="caenviar"><br>
                <hr id="hr-login">
                <a href="https://wa.me/51986206045?text=Hola%2C+tengo+una+consulta+%C2%BFpueden+ayudarme%3F%F0%9F%98%80" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br>
                <a id="enlacemail" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a>
            </form>
        </div>
    </main>
</body>
<?php echo footermed(); ?>

</html>