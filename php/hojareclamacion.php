<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Med Universe S.A.C.S."/>
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hoja de Reclamación - The Med Universe | Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/lreclamos.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historialadmin.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body id="body">
<?php echo headernav();include './php/navbarAdmin.php';?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/buscadorAdmin.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
        <div class="ctn-contra ctn-contra2">
            <form action="" method="POST" class="form-contra">
                <h2 id="tithoja">HOJA DE RECLAMACIÓN N°<?php echo substr(str_repeat(0, 5).$idrec, - 5)?></h2>
                <p id="fecharec3"><?php echo $fecha;?></p>
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
                        <div class="divhisto" id="idcon">
                            <p><span>Documento de identidad:</span><br><?php echo $documento;?></p>
                            <p><span>N° de documento:</span><br><?php echo $numdoc;?></p>
                        </div>
                    </div>
                    <div class="sobrehisto">
                        <div class="divhisto" id="idcon2">
                            <p><span>Domicilio:</span><br><?php echo $domicilio;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p><span>N° de teléfono:</span><br><?php echo $telefono;?></p>
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
                            <p><span>N° de teléfono:</span><br><?php echo $telefonotut;?></p>
                        </div>
                        <div class="divhisto" id="idcon2">
                            <p><span>Correo electrónico:</span><br><?php echo $correotut;?></p>
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
                            <p><span>Monto reclamado:</span><br><?php echo $monto;?></p>
                            <p><span>N° de cita (opcional):</span><br><?php echo $numcita;?></p>
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
                            <p id="pevidencia"><span>Documento o imagen evidencial (opcional):</span><br>
                                <a href="../evidencias/<?php echo $evidencia;?>" download="../evidencias/<?php echo $evidencia;?>"><?php echo 'Descargar evidencia';?></a>
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
                    <?php
                    if($acciones==''){
                    ?>
                    <form action="" method="post">
                        <div class="divinper">
                            <h2 style="margin-bottom:20px">VI. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h2>
                            <div class="ctn-guardarip" id="ctn-editip">
                                <input type="submit" name="editip" id="guardaraccion" value="Guardar">
                            </div>
                        </div>
                        <div class="divhisto" id="idbien2">
                            <textarea name="observaciones" onkeypress="return validarn(event)" placeholder='Observaciones y acciones a considerar por The Med Universe S.A.C.S.' rows="5" required></textarea>
                        </div>
                    </form>
                    <?php
                    } else{
                    ?>
                    <div id="perfil1">
                        <div class="divinper">
                            <h2>VI. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h2>
                            <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                        </div>
                        <div class="divhisto" id="idbien2">
                            <p><span>Observaciones y Acciones:</span><br><?php echo $acciones;?></p>
                        </div>
                    </div>
                    <div id="perfil2" style="display:none">
                        <form action="" method="post">
                            <div class="divinper">
                                <h2 style="margin-bottom:20px">VI. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h2>
                                <div class="ctn-guardarip" id="ctn-editip">
                                    <input style="margin:-5px 0px 0px 0px" type="submit" name="editip2" id="editip" value="Guardar">
                                </div>
                            </div>
                            <div class="divhisto" id="idbien2">
                                <textarea name="observaciones2" onkeypress="return validarn(event)" placeholder='Observaciones y acciones a considerar por The Med Universe S.A.C.S.' rows="5" required><?php echo $acci;?></textarea>
                            </div>
                        </form>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
        <?php
        if(isset($_POST['editip'])){
            $observaciones = nl2br(ucfirst($_POST['observaciones']));

            $sql2 = mysqli_query($conexion, "UPDATE lreclamos SET acciones = '$observaciones' WHERE idrec = '".$idrec."' ");
            
            if ($sql2){
                echo "<script>window.location.href='" . $_ENV['APP_URL'] . "hojareclamacion/".$idrec."'</script>";
            }
            
        }

        if(isset($_POST['editip2'])){
            $observaciones2 = nl2br(ucfirst($_POST['observaciones2']));

            $sql4 = mysqli_query($conexion, "UPDATE lreclamos SET acciones = '$observaciones2' WHERE idrec = '".$idrec."' ");
            if ($sql4){
                echo "<script>window.location.href='" . $_ENV['APP_URL'] . "hojareclamacion/".$idrec."'</script>";
            }
        }
        ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL'];?>js/previewobservaciones.js"></script>
</body>
<?php echo footermed();?>
</html>