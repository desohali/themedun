<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hoja de Reclamación - The Med Universe</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/lreclamos.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener("DOMContentLoaded", function(){
        const formli = document.getElementById("formli");

        formli.addEventListener("submit", async function(e){
            e.preventDefault();

            const formData = new FormData(this);
            if($("#codigot").val()!=''){
                let peticion = {
                    method: "post",
                    body: formData,
                }
                fetch("<?php echo $_ENV['APP_URL'];?>php/codigoReclamacion.php", peticion)
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    if(respuesta["codigo"]=="Este codigo no existe"){
                        Swal.fire({
                            title: 'Código incorrecto',
                            text: 'No se encontró ninguna reclamación con ese código. Revisa el código en tu correo e inténtalo de nuevo.',
                            icon: 'error',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        });
                    } else{
                        window.location.replace("<?php echo $_ENV['APP_URL'];?>hreclamos/"+respuesta['codigo']);
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
                    <p id="fraselogin">TU SALUD EN BUENAS MANOS</p>
                    
                </div>
            </form>
        </div>
        <div class="ctn-contra" id='ctn-dos'>
            <form id="formReclamaciones" action="" method="POST" class="form-contra">
                <h2 id="tithoja">HOJA DE RECLAMACIÓN N°<?php echo substr(str_repeat(0, 5).$idrec, - 5)?></h2>
                <p id="fecharec2"><?php echo $fecha;?></p>
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
                            <p><span>Nombres:</span><br><?php echo $nombres;?></p>
                            <p><span>Apellidos:</span><br><?php echo $apellidos;?></p>
                        </div>
                        <div class="divhisto"  id="idcon">
                            <p><span>Documento de identidad:</span><br><?php echo $documento;?></p>
                            <p><span>N° de documento:</span><br><?php echo $numdoc;?></p>
                        </div>
                    </div>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p><span>Domicilio:</span><br><?php echo $domicilio;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p><span>N° de celular:</span><br><?php echo $telefono;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p><span>Correo electrónico:</span><br><?php echo $correo;?></p>
                        </div>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>III. IDENTIFICACIÓN DEL PADRE, MADRE O TUTOR (SI EL CONSUMIDOR RECLAMANTE ES MENOR DE EDAD)</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon">
                            <p><span>Nombres:</span><br><?php echo $nombrestut;?></p>
                            <p><span>Apellidos:</span><br><?php echo $apellidostut;?></p>
                        </div>
                        <div class="divhisto" id="idcon">
                            <p><span>Documento de identidad:</span><br><?php echo $documentotut;?></p>
                            <p><span>N° de documento:</span><br><?php echo $numdoctut;?></p>
                        </div>
                    </div>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p><span>Domicilio:</span><br><?php echo $domiciliotut;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p><span>N° de celular:</span><br><?php echo $telefonotut;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p class="ultimo"><span>Correo electrónico:</span><br><?php echo $correotut;?></p>
                        </div>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>IV. IDENTIFICACIÓN DEL BIEN CONTRATADO</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idbien2">
                            <p><span>Tipo de bien:</span><br><?php echo $tipobien;?></p>
                        </div>
                        <div class="divhisto" id="idbien">
                            <p><span>Monto reclamado:</span><br><?php echo 'S/ '.$monto;?></p>
                            <p><span>N° de cita:</span><br><?php echo $numcita;?></p>
                        </div>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p><span>Descripción:</span><br><?php echo $descripcion;?></p>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>V. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h2>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p><span>Tipo de solicitud:</span><br><?php echo $reclamo;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p id="pevidencia"><span>Documento o imagen evidencial:</span><br>
                                <a href="../evidencias/<?php echo $evidencia;?>" download><?php echo 'Descargar evidencia';?></a>
                            </p>
                        </div>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p><span>Detalle:</span><br><?php echo $detalle;?></p>
                    </div>
                    <div class="divhisto" id="idbien2">
                        <p><span>Pedido:</span><br><?php echo $pedido;?></p>
                    </div>
                </div>
                <hr class="hrlr">
                <div class="boxhc">
                    <h2>VI. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h2>
                    <div class="divhisto" id="idbien2">
                        <p><span>Observaciones y acciones:</span><br><?php echo $acciones;?></p>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/script.js"></script>
</body>
<?php echo footermed();?>
</html>