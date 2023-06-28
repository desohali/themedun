<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Abono <?php echo $doc.' '.$nombrespro.' '.$apellidospro?> - The Med Universe | Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historial.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historialadmin.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>
<body id="body">
<?php echo headernav();include './php/navbarAdmin.php'?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
<script>
    const sendForm = async ($event, $this, idForm) => {
        
        $event.preventDefault();
        
        const form = document.getElementById(idForm);
        
        const {isConfirmed} = await Swal.fire({
            title: 'Abono de la ganancia',
            text: "¿Está seguro de haber realizado el abono de la ganancia? Ya no lo podrá modificar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00d418',
            cancelButtonColor: '#0052d4',
            confirmButtonText: 'Sí, realizado',
            cancelButtonText: 'No'
        });
        if (isConfirmed) {
            const formData = new FormData(form);
            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/pagoPro.php", {
                method: "post",
                body: formData
            });
            await response.text();
            const text = await Swal.fire({
                title: 'Abono de la ganancia realizado',
                text: '',
                icon: 'success',
                confirmButtonColor: '#0052d4',
                confirmButtonText: 'Ok',
            }).then((result) => {
                window.location.reload();
                });
        }
        
    }
    const sendFormEqual = async ($event, $this, idForm) => {
        
        $event.preventDefault();
        
        const form = document.getElementById(idForm);
        
        const {isConfirmed} = await Swal.fire({
            title: 'Deuda por Inasistencia',
            text: "¿Está seguro de generar una deuda por inasistencia? Ya no la podrá modificar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00d418',
            cancelButtonColor: '#0052d4',
            confirmButtonText: 'Sí, Generar',
            cancelButtonText: 'No'
        });
        if (isConfirmed) {
            const formData = new FormData(form);
            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/deudaPro.php", {
                method: "post",
                body: formData
            });
            await response.text();
            const text = await Swal.fire({
                title: 'Deuda por Inasistencia Generada',
                text: '',
                icon: 'success',
                confirmButtonColor: '#0052d4',
                confirmButtonText: 'Ok',
            }).then((result) => {
                window.location.reload();
                });
        }
    }
    const sendFormMinus = async ($event, $this, idForm) => {
        
        $event.preventDefault();
        
        const form = document.getElementById(idForm);
        
        const {isConfirmed} = await Swal.fire({
            title: 'Pago de la deuda',
            text: "¿Está seguro de haber recibido el pago de la deduda? Ya no lo podrá modificar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00d418',
            cancelButtonColor: '#0052d4',
            confirmButtonText: 'Sí, recibido',
            cancelButtonText: 'No'
        });
        if (isConfirmed) {
            const formData = new FormData(form);
            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/cobroPro.php", {
                method: "post",
                body: formData
            });
            await response.text();
            const text = await Swal.fire({
                title: 'Pago de la deuda recibido',
                text: '',
                icon: 'success',
                confirmButtonColor: '#0052d4',
                confirmButtonText: 'Ok',
            }).then((result) => {
                window.location.reload();
                });
        }
        
    }
</script>
    <main>
    <div class="boxhistorial">
        <div class="ctn-historial" style="min-height:auto;margin-bottom:25px">
        <?php
            include './php/conexion_paciente.php';
            $TotalPagosNoAbonados=$TotalPagosAbonados=$TotalPagosNoCobrados=$TotalPagosCobrados='0';
            $consultap="SELECT SUM(localizacion) as TotalPagosNoAbonados, COUNT(localizacion) as NumPagNoAbo FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'NO'";
            $resultadop=mysqli_query($conexion, $consultap);
            $filap=$resultadop->fetch_assoc();
            if(isset($filap['TotalPagosNoAbonados'])){
                $TotalPagosNoAbonados=$filap['TotalPagosNoAbonados'];
                $NumPagNoAbo=$filap['NumPagNoAbo'];
            }
            $consultap2="SELECT SUM(localizacion) as TotalPagosAbonados, COUNT(localizacion) as NumPagAbo FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'SI'";
            $resultadop2=mysqli_query($conexion, $consultap2);
            $filap2=$resultadop2->fetch_assoc();
            if(isset($filap2['TotalPagosAbonados'])){
                $TotalPagosAbonados=$filap2['TotalPagosAbonados'];
                $NumPagAbo=$filap2['NumPagAbo'];
            }
            $consultap3="SELECT SUM(localizacion) as TotalPagosNoCobrados, COUNT(localizacion) as NumPagNoCo FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'F'";
            $resultadop3=mysqli_query($conexion, $consultap3);
            $filap3=$resultadop3->fetch_assoc();
            if(isset($filap3['TotalPagosNoCobrados'])){
                $TotalPagosNoCobrados=$filap3['TotalPagosNoCobrados'];
                $NumPagNoCo=$filap3['NumPagNoCo'];
            }
            $consultap4="SELECT SUM(localizacion) as TotalPagosCobrados, COUNT(localizacion) as NumPagCo FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'P'";
            $resultadop4=mysqli_query($conexion, $consultap4);
            $filap4=$resultadop4->fetch_assoc();
            if(isset($filap4['TotalPagosCobrados'])){
                $TotalPagosCobrados=$filap4['TotalPagosCobrados'];
                $NumPagCo=$filap4['NumPagCo'];
            }
            $nombres=$apellidos=$tipodoc=$newDateNac=$timestampNac=$numdoc=$nacimiento=$direccion=$banco=$tipocuenta=$codigocuenta='';
            $consultacuenta = "SELECT * FROM cuentabancaria WHERE idpro = '".$idpro."' ";
            $resultadocuenta = mysqli_query($conexion, $consultacuenta);
            if (isset($resultadocuenta)) {
                while ($rowcuenta = $resultadocuenta->fetch_array()){
                    $nombres = $rowcuenta['nombrestitular'];
                    $apellidos = $rowcuenta['apellidostitular'];
                    $nombresyape = $rowcuenta['nombresyape'];
                    $apellidosyape = $rowcuenta['apellidosyape'];
                    $yape = $rowcuenta['yape'];
                    $tipodoc = $rowcuenta['tipodoctitular'];
                    $numdoc = $rowcuenta['numdoctitular'];
                    $nacimiento = $rowcuenta['nacimientotitular'];
                    $direccion = $rowcuenta['direcciontitular'];
                    $banco = $rowcuenta['nombrebanco'];
                    $tipocuenta = $rowcuenta['tipocuenta'];
                    $codigocuenta = $rowcuenta['codigocuentainterbancaria'];
                    if($nacimiento != ''){
                        $timestampNac = strtotime($nacimiento); 
                        $newDateNac = date("d-m-Y", $timestampNac );
                    }
                }
            }
        ?>
			<div class="ctn-editarpc" id="editarpc">
                <h2>SUS GANANCIAS</h2>
            </div>
            <div class="ctn-infpagos">
            <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span style="color:#00D418">Ganancia abonada:</span><br>S/ <?php echo round(82.01*$TotalPagosAbonados/100 - $NumPagAbo - 18*(17.99*$TotalPagosAbonados/100 + $NumPagAbo)/100, 1)?></p>
                            <p><span style="color:#FFC107">Ganancia por abonar:</span><br>S/ <?php echo round(82.01*$TotalPagosNoAbonados/100 - $NumPagNoAbo - 18*(17.99*$TotalPagosNoAbonados/100 + $NumPagNoAbo)/100, 1)?></p>
                        </div>
                        <div class="historia2">
                            <p><span style="color:#00D418">Deuda pagada (Inasistencia):</span><br>S/ <?php echo round(17.99*$TotalPagosCobrados/100 + $NumPagCo + 18*(17.99*$TotalPagosCobrados/100 + $NumPagCo)/100, 1)?></p>
                            <p><span style="color:#FF0000">Deuda por pagar (Inasistencia):</span><br>S/ <?php echo round(17.99*$TotalPagosNoCobrados/100 + $NumPagNoCo + 18*(17.99*$TotalPagosNoCobrados/100 + $NumPagNoCo)/100, 1)?></p>
                        </div>
                    </div>
                    <div class="boxhisto2" style="align-items:center;">
                        <div class="historia3">
                            <p style="text-align:center"><span>¿YA ABONÓ SUS PAGOS?</span><br>The Med Universe abona el dinero acumulado en pagos semanales.</p>
                        </div>
                        <div class="historia4" id="hbuttons">
                            <!-- Button trigger modal -->
								<button type="button" class="btn btn-primary" id="btncuenta" data-toggle="modal" data-target="#modalCuenta">
									Cuenta Bancaria
								</button>

								<!-- Modal -->
								<div class="modal fade modcuenta" id="modalCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modsegundo" role="document" id="msegundo">
										<div class="modal-content modtercero" id="mtercero">
											<div class="modal-header">
												<h5 class="modal-title" id="pagarTitle">Cuenta Bancaria</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
                                        <!--Register-->
                                            <div class="modal-body">
                                    <div class="contenedor__login-register">
                                        <!--Register-->
                                        <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                                        <form id="formCuenta2" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <p class="pcentral"><span>Nombres y apellidos:</span><br><?php echo $nombres.' '.$apellidos?></p>
                                            </div>
                                            <div class="filaregister">
                                                <p class="pmedio"><span>Documento de identidad:</span><br><?php echo $tipodoc?></p>
                                                <p class="pmedio"><span>N° de documento:</span><br><?php echo $numdoc?></p>
                                            </div>
                                            <div class="filaregister">
                                                <p class="pmedio"><span>Fecha de nacimiento:</span><br><?php echo $timestampNac?></p>
                                                <p class="pmedio"><span>Domicilio:</span><br><?php echo $direccion?></p>
                                            </div>
                                            <p class="pdatos" style="margin-top:5px"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <p class="pmedio"><span>Banco:</span><br><?php echo $banco?></p>
                                                <p class="pmedio"><span>Tipo de cuenta:</span><br><?php echo $tipocuenta?></p>
                                            </div>
                                            <div class="filaregister">
                                                <p class="pcentral"><span>Código de Cuenta Interbancario (CCI):</span><br><?php echo $codigocuenta?></p>
                                            </div>
                                        </form>
                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <!-- end modal -->
                            <button type="button" class="btn btn-primary" id="btnyape" data-toggle="modal" data-target="#modalYape">
									Cuenta de Yape
								</button>
								<!-- Modal -->
								<div class="modal fade modyape" id="modalYape" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modsegundo" role="document" id="msegundo">
										<div class="modal-content modtercero" id="mtercero">
											<div class="modal-header">
												<h5 class="modal-title" id="pagarTitle">Cuenta de Yape</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
                                        <!--Register-->
                                            <div class="modal-body">
                                    <div class="contenedor__login-register">
                                        <!--Register-->
                                        <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                                        <form id="formYape2" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <p class="pcentral"><span>Nombres y apellidos:</span><br><?php echo $nombresyape.' '.$apellidosyape?></p>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <p class="pcentral"><span>N° de Yape:</span><br><?php echo $yape?></p>
                                            </div>
                                        </form>
                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <!-- end modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ctn-historial">
			<div class="ctn-editarpc" id="editarpc2">
                <h2>HISTORIAL DE PAGOS</h2>
            </div>
            <div class="ctn-infpagos">
                <?php
                include './php/conexion_paciente.php';
                $CantidadMostrar=10000;
                // Validado  la variable GET
                $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM pagos");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT *, idpago as idpagos, (select start from citas where idpay=idpagos) as startCitas, (select tiempoenf from hclinica where idhc=idpagos) as llenadoHC FROM pagos WHERE usuariopro = '".$idpro."' ORDER BY startCitas DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                    $consultacita = "SELECT *, id as idu,(select nombres from usuarios where id=idu) as nombresPaciente, (select apellidos from usuarios where id=idu) as apellidosPaciente FROM citas WHERE idpay = '".$lista['idpago']."' ";
                    $resultadocita = mysqli_query($conexion, $consultacita);
                    if ($resultadocita) {
                        while ($rowcita = $resultadocita->fetch_array()){
                            $idcita = $rowcita['idcita'];
                            $paciente = $rowcita['nombresPaciente'].' '.$rowcita['apellidosPaciente'];
                            $costo = $rowcita['localizacion'];
                            $abonado = $rowcita['abonado'];
                            $asistencia = $rowcita['asistencia'];
                            $fechacitas = $rowcita['start'];
                            $fechapago = $fechacitas;
                            list($fecha, $hora) = explode(" ", $fechapago);
                            $horafinal = explode(":00", $hora);
                            $timestamp = strtotime($fecha);
                            $newFecha = date("d/m/Y", $timestamp);
                            $timestampFyH = strtotime($fechacitas); 
                            $newDateFyH = date("d-m-Y H:i:s", $timestampFyH );
                            if($horafinal[0]=='01'){
                                $enlace=" a la ";
                            }else{
                                $enlace=" a las ";
                            }
                            $tiempoFinal=$newFecha . $enlace . $horafinal[0] . ":00";
                            if($lista['llenadoHC']==""){
                                $llenadoHC="No enviada";
                            }else{
                                $llenadoHC="Enviada";
                            }
                            if($rowcita['asistencia']=="No asistió" || $rowcita['asistenciapac']=="No asistió"){
                                $llenadoHC="Cita no realizada";
                            }
                        }
                    }
                    $n = rand();
                ?>
                <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span>N° de cita:</span><br><?php echo $idcita?></p>
                            <p><span>Fecha y hora:</span><br><?php echo $tiempoFinal;?></p>
                        </div>
                        <div class="historia2">
                            <p><span>Pagado por:</span><br><?php echo $paciente?></p>
                            <p style="<?php if ($llenadoHC == 'No enviada') { ?>color:#FFC107<?php } ?>"><span style="color:black">Historia Clínica:</span><br><?php echo $llenadoHC;?></p>
                        </div>
                    </div>
                    <div class="boxhisto2">
                        <div class="historia3">
                            <p><span>Pagado a:</span><br><?php echo $doctor.' '.$nombrespro.' '.$apellidospro?></p>
                            <p style="<?php if ($asistencia == 'No asistió') { ?>color:#ff0000<?php } ?>"><span style="color:black">Asistencia:</span><br><?php echo $asistencia?></p>
                        </div>
                        <div class="historia4">
                            <p><span>Precio de cita:</span><br>S/ <?php echo $costo?></p>
                            <?php
                            if($abonado=='NO'){
                            ?>
                            <form id="formPagar<?= $n ?>" method="POST">
                                <p class="pprepago"><span style="color:#FFC107">Ganancia por abonar:</span></p><div class="ppago"><p id="montoPago">S/ <?php echo round(82.01*$costo/100 - 1 - 18*(17.99*$costo/100 + 1)/100, 1)?></p><div class="botonesPago"><?php if($asistencia=="No asistió"){ ?><label id="labelequal" for="equal<?= $n ?>"><i class="fa-solid fa-square-caret-down"></i></label><?php } ?><?php if($llenadoHC!="No enviada" && $asistencia=="Asistió"){ ?><label id="labelmas" for="mas<?= $n ?>"><i class="fa-solid fa-square-plus"></i></label><?php } ?></div></div>
                                <input type="hidden" name="numbercita" id="numbercita" value="<?php echo $idcita ?>">
                                <input type="button" onclick="sendFormEqual(event, this, 'formPagar<?= $n ?>')" id="equal<?= $n ?>" name="generardeuda" style="display:none">
                                <input type="button" onclick="sendForm(event, this, 'formPagar<?= $n ?>')" id="mas<?= $n ?>" name="pagar" style="display:none">
                            </form>
                            <?php
                            } else if($abonado=='F'){
                            ?>
                            <form id="formPagar<?= $n ?>" method="POST">
                                <p class="pprepago"><span style="color:#FF0000">Deuda por pagar (Inasistencia):</span></p><div class="ppago"><p id="montoPago">S/ <?php echo round(17.99*$costo/100 + 1 + 18*(17.99*$costo/100 + 1)/100, 1)?></p><div class="botonesPago"><?php if($asistencia=="No asistió"){ ?><label id="labelminus" for="minus<?= $n ?>"><i class="fa-solid fa-square-minus"></i></label><?php } ?></div></div>
                                <input type="hidden" name="numbercita" id="numbercita" value="<?php echo $idcita ?>">
                                <input type="hidden" name="idPro" id="idPro" value="<?php echo $idpro ?>">
                                <input type="button" onclick="sendFormMinus(event, this, 'formPagar<?= $n ?>')" id="minus<?= $n ?>" name="deuda" style="display:none">
                            </form>
                            <?php
                            } else if($abonado=='P'){
                            ?>
                            <p><span style="color:#00D418">Deuda pagada (Inasistencia):</span><br>S/ <?php echo round(17.99*$costo/100 + 1 + 18*(17.99*$costo/100 + 1)/100, 1)?></p>
                            <?php
                            } else{
                            ?>
                            <p><span style="color:#00d418">Ganancia abonada:</span><br>S/ <?php echo round(82.01*$costo/100 - 1 - 18*(17.99*$costo/100 + 1)/100, 1)?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </main>
</body>
<?php echo footermed();?>
</html>