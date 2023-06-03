<?php
//include './php/lreclamos.php';
include './php/footer.php';
include './configuracion.php';
include './seguridad.php';

$urlactual = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($urlactual == 'https://themeduniverse.com/lreclamos') {
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "lreclamos'</script>";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Libro de Reclamaciones - The Med Universe</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/lreclamos.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formReclamaciones = document.getElementById("formReclamaciones");

            formReclamaciones.addEventListener("submit", async function(e) {
                e.preventDefault();
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Hoja de reclamación',
                    text: "¿Está seguro de enviar la hoja de reclamación? Ya no la podrá modificar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00d418',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'No'
                });

                if (isConfirmed) {
                    const formData = new FormData(this);
                    if ($("#tipobien").val() != '') {
                        const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/guardarReclamo.php", {
                            method: "post",
                            body: formData
                        });

                        const json = await response.json();

                        const [primerCorreo] = json;
                        await enviarCorreo(primerCorreo);

                        const text = await Swal.fire({
                                    title: 'Hoja de reclamación enviada',
                                    text: 'Para revisar el estado de su reclamación, ingrese el código que hemos enviado a su correo.',
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
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formli = document.getElementById("formli");

            formli.addEventListener("submit", async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                if ($("#codigot").val() != '') {
                    let peticion = {
                        method: "post",
                        body: formData,
                    }
                    fetch("<?php echo $_ENV['APP_URL']; ?>php/codigoReclamacion.php", peticion)
                        .then(respuesta => respuesta.json())
                        .then(respuesta => {
                            if (respuesta["codigo"] == "Este codigo no existe") {
                                Swal.fire({
                                    title: 'Código incorrecto',
                                    text: 'No se encontró ninguna reclamación con ese código.',
                                    icon: 'error',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                });
                            } else {
                                window.location.replace("<?php echo $_ENV['APP_URL']; ?>hreclamos/" + respuesta['codigo']);
                            }
                        })
                }
            });
        });
    </script>
    <main>
        <div class="ctn-contra" id="ctn-li">
            <form id="formli" method="POST" class="form-contra">
                <h2>LIBRO DE RECLAMACIONES</h2>
                <span class="icon-eye eye1" id="icon-eye-reclamos"><i class="fa-solid fa-eye-slash"></i></span>
                <input style="margin-top:0px;" type="password" placeholder="Código de reclamación" name="codigo" id="codigot" autocomplete="off" minlength="6" required><br>
                <input type='submit' value="Buscar" id="caenviar" name="caenviar"><br>
                <hr id="hr-login">
                <div class="med-logos reclamos">
                    <p id="fraselogin">TU SALUD IMPORTA</p>
                </div>
            </form>
        </div>
        <?php
        date_default_timezone_set("America/Lima");
        $fecha = date('d/m/Y');
        ?>
        <div class="ctn-contra" id='ctn-dos'>
            <form id="formReclamaciones" method="POST" class="form-contra" enctype="multipart/form-data">
                <h2 id="tithoja">HOJA DE RECLAMACIÓN</h2>
                <p id="fecharec"><?php echo $fecha; ?></p>
                <div class="boxhc">
                    <h2>I. IDENTIFICACIÓN DE LA EMPRESA</h2>
                    <div class="divhisto" id="empre2">
                        <p><span>Razón social:</span><br>The Med Universe S.A.C.S.</p>
                        <p><span>N° de RUC:</span><br>20610383506</p>
                    </div>
                    <p id="direcor"><span>Dirección corporativa:</span><br>Calle Ceferino Ramirez N° 265 (Lima - Huaura - Santa María)</p>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>II. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon">
                            <p><input type="text" placeholder="Nombres" name="nombres" id="nombres" required></p>
                            <p class="espacio"><input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required></p>
                        </div>
                        <div class="divhisto" id="idcon">
                            <p><select name="documento" id="documento" required>
                                    <option class="select-opt" value="">Documento de identidad</option>
                                    <option value="DNI">DNI</option>
                                    <option value="Carnet de extranjería">Carnet de extranjería</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="Permiso temporal de permanencia">Permiso temporal de permanencia</option>
                                </select></p>
                            <p class="ultimo"><input type="text" placeholder="N° de documento" name="numdoc" id="numdoc" min="0" required></p>
                        </div>
                    </div>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p class="espacio" id="pdomi"><input type="text" placeholder="Domicilio" name="domicilio" id="domicilio" required></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p class="espacio"><input type="text" placeholder="N° de celular" name="telefono" id="telefono" min="0" required></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p class="ultimo"><input type="email" placeholder="Correo electrónico" name="correo" id="correo" required></p>
                        </div>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>III. IDENTIFICACIÓN DEL PADRE, MADRE O TUTOR (SI EL CONSUMIDOR RECLAMANTE ES MENOR DE EDAD)</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon">
                            <p><input type="text" placeholder="Nombres" name="nombrestut"></p>
                            <p class="espacio"><input type="text" placeholder="Apellidos" name="apellidostut"></p>
                        </div>
                        <div class="divhisto" id="idcon">
                            <p><select name="documentotut">
                                    <option class="select-opt" value="">Documento de identidad</option>
                                    <option value="DNI">DNI</option>
                                    <option value="Carnet de extranjería">Carnet de extranjería</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="Permiso temporal de permanencia">Permiso temporal de permanencia</option>
                                </select></p>
                            <p class="ultimo"><input type="text" placeholder="N° de documento" name="numdoctut" min="0"></p>
                        </div>
                    </div>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p class="espacio"><input type="text" placeholder="Domicilio" name="domiciliotut"></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p class="espacio"><input type="text" placeholder="N° de celular" name="telefonotut" min="0"></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p class="ultimo"><input type="email" placeholder="Correo electrónico" name="correotut"></p>
                        </div>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>IV. IDENTIFICACIÓN DEL BIEN CONTRATADO</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idbien2">
                            <p><select name="tipobien" id="tipobien" required>
                                    <option class="select-opt" value="">Tipo de bien</option>
                                    <option value="Producto">Producto</option>
                                    <option value="Servicio">Servicio</option>
                                </select></p>
                        </div>
                        <div class="divhisto idbienclass">
                            <p><input type="text" placeholder="Monto reclamado" name="monto" id="monto" min="0" required></p>
                            <p class="ultimo"><input type="number" placeholder="N° de cita (opcional)" name="numcita" id="numcita" min="0"></p>
                        </div>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p id="pdescri"><textarea name="descripcion" id="descripcion" onkeypress="return validarn(event)" placeholder='Descripción' class="txtdes" rows="5" required></textarea></p>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>V. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p class="espacio" id="preclamo"><select name="reclamo" id="reclamo" required>
                                    <option class="select-opt" value="">Tipo de solicitud</option>
                                    <option value="Queja">Queja</option>
                                    <option value="Reclamo">Reclamo</option>
                                </select></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <label id="labelevi" for="evidencia">Documento o imagen evidencial (opcional)</label>
                            <input onchange="evilabel(this.value)" type="file" name="evidencia" id="evidencia" data-multiple-caption="{count} files selected">
                            <script>
                                function evilabel(valor) {
                                    document.querySelector('#labelevi').innerText = valor;
                                    document.querySelector('#labelevi').style.color = 'black';
                                    if (valor == "") {
                                        document.querySelector('#labelevi').innerText = 'Documento o imagen evidencial (opcional)';
                                        document.querySelector('#labelevi').style.color = '#777777';
                                    }
                                }
                            </script>
                        </div>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p id="pdet"><textarea name="detalle" id="detalle" onkeypress="return validarn(event)" placeholder='Detalle' class="txtdeta" rows="5" required></textarea></p>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p id="pped"><textarea name="pedido" id="pedido" onkeypress="return validarn(event)" placeholder='Pedido' class="txtpedi" rows="5" required></textarea></p>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <div class="divhisto" id="idbien2">
                        <p id="ultimop">The Med Universe dará respuesta a la reclamación en un plazo no mayor a quince (15) días hábiles.<br><br>Al hacer clic en "Enviar", declaro ser el titular del contenido del presente formulario, manifestando bajo declaración jurada los hechos descritos en él. Al enviar mis datos personales, acepto la <a href="<?php echo $_ENV['APP_URL']; ?>privacidad">Política de privacidad</a> de The Med Universe.</p>
                    </div>
                </div>
                <input type='submit' value="Enviar" id="recenviar" name="recenviar">
            </form>
        </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed(); ?>

</html>