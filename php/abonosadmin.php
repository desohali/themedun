<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Abono a <?php echo $nombrespro.' '.$apellidospro?> - The Med Universe | Administrador</title>
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
            title: 'Abono Pendiente',
            text: "¿Está seguro de haber pagado el abono pendiente? Ya no lo podrá modificar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00d418',
            cancelButtonColor: '#0052d4',
            confirmButtonText: 'Sí, Pagado',
            cancelButtonText: 'No'
        });
        if (isConfirmed) {
            const formData = new FormData(form);
            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/pagoAdmin.php", {
                method: "post",
                body: formData
            });
            await response.text();
            const text = await Swal.fire({
                title: 'Abono Pendiente Pagado',
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
            $TotalPagos=$TotalPagosAbonados=$TotalPagosPorAbonar='0';
            $consultap="SELECT COUNT(idCita) FROM pagosadmin WHERE idAdmin = '".$_GET['id']."'";
            $resultadop=mysqli_query($conexion, $consultap);
            $filap=$resultadop->fetch_assoc();
            if(isset($filap['COUNT(idCita)'])){
                $TotalPagos=$filap['COUNT(idCita)'];
            }
            $consultap2="SELECT COUNT(idCita) FROM pagosadmin WHERE idAdmin = '".$_GET['id']."' AND abonado = 'SI'";
            $resultadop2=mysqli_query($conexion, $consultap2);
            $filap2=$resultadop2->fetch_assoc();
            if(isset($filap2['COUNT(idCita)'])){
                $TotalPagosAbonados=$filap2['COUNT(idCita)'];
            }
            $nombres=$apellidos=$tipodoc=$numdoc=$nacimiento=$direccion=$banco=$tipocuenta=$codigocuenta='';
            $consultacuenta = "SELECT * FROM cuentabancariaadmin WHERE idadmin = '".$idpro."' ";
            $resultadocuenta = mysqli_query($conexion, $consultacuenta);
            if (isset($resultadocuenta)) {
                while ($rowcuenta = $resultadocuenta->fetch_array()){
                    $nombres = $rowcuenta['nombrestitular'];
                    $apellidos = $rowcuenta['apellidostitular'];
                    $tipodoc = $rowcuenta['tipodoctitular'];
                    $numdoc = $rowcuenta['numdoctitular'];
                    $nacimiento = $rowcuenta['nacimientotitular'];
                    $direccion = $rowcuenta['direcciontitular'];
                    $banco = $rowcuenta['nombrebanco'];
                    $tipocuenta = $rowcuenta['tipocuenta'];
                    $codigocuenta = $rowcuenta['codigocuentainterbancaria'];
                    $timestampNac = strtotime($nacimiento); 
                    $newDateNac = date("d-m-Y", $timestampNac );
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
                            <p><span style="color:#00D418">Total Abonado:</span><br>S/. <?php echo $TotalPagosAbonados?></p>
                        </div>
                        <div class="historia2">
                            <p><span style="color:#FFC107">Total por Abonar:</span><br>S/. <?php echo ($TotalPagos-$TotalPagosAbonados)?></p>
                        </div>
                    </div>
                    <div class="boxhisto2" style="align-items:center;">
                        <div class="historia3">
                            <p style="text-align:center"><span>¿YA ABONÓ SUS PAGOS?</span><br>The Med Universe abona los sueldos en pagos mensuales.</p>
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
                                                <p class="pmedio"><span>Fecha de nacimiento:</span><br><?php echo $newDateNac?></p>
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
                $TotalReg       =mysqli_query($conexion, "SELECT * FROM pagosadmin");
                $totalr = mysqli_num_rows($TotalReg);
                //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                $TotalRegistro  =ceil($totalr/$CantidadMostrar);
                //Operacion matematica para mostrar los siquientes datos.
                $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
                //Consulta SQL
                $consultavistas ="SELECT * FROM pagosadmin WHERE idAdmin = '".$idpro."' ORDER BY idpago DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                    $n = rand();
                ?>
                <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span>Pagado por:</span><br>The Med Universe S.A.C.S.</p>
                        </div>
                        <div class="historia2">
                            <p><span>Pagado a:</span><br><?php echo $nombrespro.' '.$apellidospro?></p>
                        </div>
                    </div>
                    <div class="boxhisto2">
                        <div class="historia3">
                            <p><span>N° de Cita:</span><br><?php echo $lista['idCita']?></p>
                        </div>
                        <div class="historia4">
                            <?php
                            if($lista['abonado']=='NO'){
                            ?>
                            <form id="formPagar<?= $n ?>" method="POST">
                                <p class="pprepago"><span style="color:#FFC107">Por Abonar:</span></p><p class="ppago">S/. 1<label id="labelmas" for="mas<?= $n ?>"><i class="fa-solid fa-square-plus"></i></label></p>
                                <input type="hidden" name="numbercita" id="numbercita" value="<?php echo $lista['idpago'] ?>">
                                <input type='button' onclick="sendForm(event, this, 'formPagar<?= $n ?>')" id="mas<?= $n ?>" name="pagar" style="display:none">
                            </form>
                            <?php
                            }else{
                            ?>
                            <p><span style="color:#00d418">Abonado:</span><br>S/. 1</p>
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