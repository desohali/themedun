<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historial de Pagos - The Med Universe | Profesional</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/navpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/historial.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>
<body id="body">
<?php echo headernav()?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo $_ENV['APP_URL'];?>js/m&obpro.js"></script>
    <main>
    <div class="boxhistorial">
        <div class="ctn-historial" style="min-height:auto;margin-bottom:25px">
        <?php
            include './php/conexion_paciente.php';
            $TotalPagosNoAbonados=$TotalPagosAbonados=$TotalPagosNoCobrados=$TotalPagosCobrados='0';
            $consultap="SELECT SUM(localizacion) as TotalPagosNoAbonados FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'NO'";
            $resultadop=mysqli_query($conexion, $consultap);
            $filap=$resultadop->fetch_assoc();
            if(isset($filap['TotalPagosNoAbonados'])){
                $TotalPagosNoAbonados=$filap['TotalPagosNoAbonados'];
            }
            $consultap2="SELECT SUM(localizacion) as TotalPagosAbonados FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'SI'";
            $resultadop2=mysqli_query($conexion, $consultap2);
            $filap2=$resultadop2->fetch_assoc();
            if(isset($filap2['TotalPagosAbonados'])){
                $TotalPagosAbonados=$filap2['TotalPagosAbonados'];
            }
            $consultap3="SELECT SUM(localizacion) as TotalPagosNoCobrados FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'F'";
            $resultadop3=mysqli_query($conexion, $consultap3);
            $filap3=$resultadop3->fetch_assoc();
            if(isset($filap3['TotalPagosNoCobrados'])){
                $TotalPagosNoCobrados=$filap3['TotalPagosNoCobrados'];
            }
            $consultap4="SELECT SUM(localizacion) as TotalPagosCobrados FROM citas WHERE idupro = '".$idpro."' AND idpay <> 0 AND abonado = 'P'";
            $resultadop4=mysqli_query($conexion, $consultap4);
            $filap4=$resultadop4->fetch_assoc();
            if(isset($filap4['TotalPagosCobrados'])){
                $TotalPagosCobrados=$filap4['TotalPagosCobrados'];
            }
            $nombres=$apellidos=$nombresyape=$apellidosyape=$yape=$tipodoc=$newDateNac=$timestampNac=$numdoc=$nacimiento=$direccion=$banco=$tipocuenta=$codigocuenta='';
            $consultacuenta = "SELECT * FROM cuentabancaria WHERE idpro = '".$_SESSION['idpro']."' ";
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
                        $newDateNac = date("d/m/Y", $timestampNac );
                    }
                }
            }
        ?>
        
            <script>
                window.addEventListener("DOMContentLoaded", function(){
                    const formCuentaBancaria = document.getElementById("formCuentaBancaria");
            
                    formCuentaBancaria.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idpro", $("#inputIdpro").val());
                        formData.append("yape", $("#yape").val());
                        if($("#nombres").val()!='' && $("#apellidos").val()!='' && $("#doctitular").val()!='' && $("#numdoctitular").val()!='' && $("#nactitular").val()!='' && $("#domiciliotitular").val()!='' && $("#nombrebanco").val()!='' && $("#tipocuenta").val()!='' && $("#codigocuenta").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/registrarCuentaBancaria.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta bancaria registrada',
                                    text: 'Ahora podrá recibir sus pagos semanales.',
                                    icon: 'success',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    window.location.reload();
                                    });
                        };
                            
                    });
                });
            </script>
            <script>
                window.addEventListener("DOMContentLoaded", function(){
                    const formCuentaBancaria = document.getElementById("formCuentaEditar");
            
                    formCuentaBancaria.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idpro", $("#inputIdpro2").val());
                        if($("#nombres").val()!='' && $("#apellidos").val()!='' && $("#doctitular").val()!='' && $("#numdoctitular").val()!='' && $("#nactitular").val()!='' && $("#domiciliotitular").val()!='' && $("#nombrebanco").val()!='' && $("#tipocuenta").val()!='' && $("#codigocuenta").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/editarCuentaBancaria.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta bancaria registrada',
                                    text: 'Ahora podrá recibir sus pagos semanales.',
                                    icon: 'success',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    window.location.reload();
                                    });
                        };
					});
                });
            </script>
            <script>
                window.addEventListener("DOMContentLoaded", function(){
                    const formYape = document.getElementById("formYape");
            
                    formYape.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idpro", $("#inputIdpro").val());
                        formData.append("nombres", $("#nombres").val());
                        if($("#nombresyape").val()!='' && $("#apellidosyape").val()!='' && $("#yape").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/registrarYape.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta de Yape registrada',
                                    text: 'Ahora podrá recibir sus pagos semanales.',
                                    icon: 'success',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    window.location.reload();
                                    });
                        };
                            
                    });
                });
            </script>
            <script>
                window.addEventListener("DOMContentLoaded", function(){
                    const formYape = document.getElementById("formYapeEditar");
            
                    formYape.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idpro", $("#inputIdpro2").val());
                        if($("#nombresyape").val()!='' && $("#apellidosyape").val()!='' && $("#yape").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/editarYape.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta de Yape registrada',
                                    text: 'Ahora podrá recibir sus pagos semanales.',
                                    icon: 'success',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    window.location.reload();
                                    });
                        };
					});
                });
            </script>
			<div class="ctn-editarpc" id="editarpc">
                <h2>MIS GANANCIAS</h2>
                        <div class="historia4" id="historia4">
                                <!-- Button trigger modal -->
								<button type="button" class="btn btn-danger" id="btndeuda" data-toggle="modal" data-target="#modalDeuda">
									Pagar Deuda
								</button>

								<!-- Modal -->
								<div class="modal fade moddeuda" id="modalDeuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modsegundo" role="document" id="msegundo">
										<div class="modal-content modtercero" id="mtercero">
											<div class="modal-header">
												<h5 class="modal-title" id="pagarTitle">Pagar por Yape o Transferencia Directa</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="columnastmu">
													<div class="columnasuno">
														<p><span>Número de Cuenta BCP:</span><br>33575750511084</p><br>
														<p><span>Código de Cuenta Interbancario:</span><br>00233517575051108485</p>
														<hr id="hr-register">
														<div class="filaregister">
															<ul>
																<li>Pague su deuda con cualquiera de estos métodos de pago:<br><br>1. Transferencia bancaria o interbancaria a cualquiera de los números de cuenta que se muestran.<br><br>2. Yape al código QR que aparece en la versión escritorio o al +51 986 206 045.<br><br>Recuerde enviarnos un correo o mensaje de WhatsApp con la imagen del comprobante de pago para actualizar el pago de su deuda.</li>
															</ul>
														</div>
													</div>
													<div class="columnasdos">
														<div class="columnasimg">
															<img src="<?php echo $_ENV['APP_URL']; ?>images/Yape-TMU.jpg">
														</div>
														<br><a id="awsp" href="https://wa.me/51986206045?text=Hola%2C+realic%C3%A9+el+pago+de+mi+cita+y+adjunto+el+comprobante+de+pago+para+que+puedan+actualizar+su+programaci%C3%B3n.%F0%9F%98%80" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
                        </div>
            </div>
            <div class="ctn-infpagos">
            <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span style="color:#00D418">Ganancia abonada:</span><br>S/ <?php echo (82*$TotalPagosAbonados)/100?></p>
                            <p><span style="color:#FFC107">Ganancia por abonar:</span><br>S/ <?php echo (82*($TotalPagosNoAbonados))/100?></p>
                        </div>
                        <div class="historia2">
                            <p><span style="color:#FF0800">Deuda pagada (Inasistencia):</span><br>S/ <?php echo (18*($TotalPagosCobrados))/100?></p>
                            <p><span style="color:#FFC107">Deuda por pagar (Inasistencia):</span><br>S/ <?php echo (18*($TotalPagosNoCobrados))/100?></p>
                        </div>
                    </div>
                    <div class="boxhisto2" style="align-items:center;">
                        <div class="historia3">
                            <p style="text-align:center"><span>¿AÚN NO COBRA SUS GANANCIAS?</span><br>Agregue una cuenta bancaria o de Yape donde pueda recibir sus pagos semanales.</p>
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
                                        <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                                        <?php
                                        if($nombres==''){
                                        ?>
                                            <div class="modal-body">
									<div class="contenedor__login-register">
                                        <form id="formCuentaBancaria" method="POST" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <input type="text" placeholder="Nombres" name="nombres" id="nombres" required>
                                                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required><br>
                                            </div>
                                            <div class="filaregister">
                                                <select name="documento" id="doctitular" required><option class="select-opt" value="">Documento de identidad</option><option value="DNI">DNI</option><option value="Carnet de extranjería">Carnet de extranjería</option><option value="Pasaporte">Pasaporte</option><option value="Permiso temporal de permanencia">Permiso temporal de permanencia</option></select>
                                                <input type="number" placeholder="N° de documento" name="numdoc" id="numdoctitular" min="0" required>
                                            </div>
                                            <div class="filaregister">
                                                <input type="date" name="nacimiento" id="nactitular" min="1905-01-01"  required>
                                                <input type="text" placeholder="Domicilio" name="domicilio" id="domiciliotitular" required>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <select name="nombrebanco" id="nombrebanco" required>
                                                    <option class="select-opt" value="">Banco</option>
                                                <?php 
                                                    include './php/conexion_paciente.php';
                            
                                                    $selectm = "SELECT * FROM bancos";
                                                    $ejecutar = mysqli_query($conexion,$selectm);
                            
                                                ?>
                            
                                                <?php foreach ($ejecutar as $opciones): ?>
                            
                                                    <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>
                            
                                                <?php endforeach?>

                                                </select>
                                                <select name="tipocuenta" id="tipocuenta" required>
                                                    <option class="select-opt" value="">Tipo de cuenta</option>
                                                    <option value="Cuenta corriente">Cuenta corriente</option>
                                                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                                                </select>
                                            </div>
                                            <div class="filaregister">
                                                <input type="number" placeholder="Código de Cuenta Interbancario (CCI)" name="codigocuenta" id="codigocuenta" min="0" required>
                                                <input type="number" id="inputIdpro" style="visibility:hidden" value="<?php echo $idpro;?>">
                                            </div>
                                            <hr id="hr-register">
                                            <p class="pguardar">Al hacer clic en "Guardar", autorizo recibir el pago de mis ganancias en la cuenta relacionada.</p>
                                            <input type='submit' value="Guardar" name="registrarCuenta">
                                        </form>
                                    </div>
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="modal-body" id="bodyCuenta2">
									<div class="contenedor__login-register">
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
                                            <hr id="hr-register">
                                            <div class="filaregister">
                                                <label id="labelEditar">Editar</label>
                                            </div>
                                        </form>
                                    </div>
                                        </div>
                                        <div class="modal-body" id="bodyCuentaEditar">
									<div class="contenedor__login-register">
                                        <form id="formCuentaEditar" method="POST" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <input type="text" placeholder="Nombres" name="nombres" id="nombres" value="<?php echo $nombres?>" required>
                                                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" value="<?php echo $apellidos?>" required>
                                            </div>
                                            <div class="filaregister">
                                                <select name="documento" id="doctitular" required><option class="select-opt" value="<?php echo $tipodoc?>" selected><?php echo $tipodoc?></option><option value="DNI">DNI</option><option value="Carnet de extranjería">Carnet de extranjería</option><option value="Pasaporte">Pasaporte</option><option value="Permiso temporal de permanencia">Permiso temporal de permanencia</option></select>
                                                <input type="number" placeholder="N° de documento" name="numdoc" id="numdoctitular" min="0" value="<?php echo $numdoc?>" required>
                                            </div>
                                            <div class="filaregister">
                                                <input type="date" name="nacimiento" id="nactitular" min="1905-01-01"  value="<?php echo $nacimiento?>" required>
                                                <input type="text" placeholder="Domicilio" name="domicilio" id="domiciliotitular" value="<?php echo $direccion?>" required>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <select name="nombrebanco" id="nombrebanco" required>
                                                    <option class="select-opt" value="<?php echo $banco?>" selected><?php echo $banco?></option>
                                                <?php 
                                                    include './php/conexion_paciente.php';
                            
                                                    $selectm = "SELECT * FROM bancos";
                                                    $ejecutar = mysqli_query($conexion,$selectm);
                            
                                                ?>
                            
                                                <?php foreach ($ejecutar as $opciones): ?>
                            
                                                    <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>
                            
                                                <?php endforeach?>

                                                </select>
                                                <select name="tipocuenta" id="tipocuenta" required>
                                                    <option class="select-opt" value="<?php echo $tipocuenta?>" selected><?php echo $tipocuenta?></option>
                                                    <option value="Cuenta corriente">Cuenta corriente</option>
                                                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                                                </select>
                                            </div>
                                            <div class="filaregister">
                                                <input type="number" placeholder="Código de Cuenta Interbancario (CCI)" name="codigocuenta" id="codigocuenta" min="0" value="<?php echo $codigocuenta?>" required>
                                                <input type="number" id="inputIdpro2" style="visibility:hidden" value="<?php echo $idpro;?>">
                                            </div>
                                            <hr id="hr-register">
                                            <p class="pguardar">Al hacer clic en "Guardar", autorizo recibir el pago de mis ganancias en la cuenta relacionada.</p>
                                            <input type='submit' value="Guardar" name="registrarCuenta">
                                        </form>
                                    </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
										</div>
									</div>
								</div>
								<!-- Button trigger modal -->
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
                                        <!-- <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
                                        <?php
                                        if($yape==''){
                                        ?>
                                            <div class="modal-body">
									<div class="contenedor__login-register">
                                        <form id="formYape" method="POST" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <input type="text" placeholder="Nombres" name="nombresyape" id="nombresyape" required>
                                                <input type="text" placeholder="Apellidos" name="apellidosyape" id="apellidosyape" required><br>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <input type="number" placeholder="(+51) N° de teléfono" name="yape" id="yape" min="0" required>
                                            </div>
                                            <div class="filaregister">
                                                <input type="number" id="inputIdpro" style="display:none" value="<?php echo $idpro;?>">
                                            </div>
                                            <hr id="hr-register">
                                            <p class="pguardar">Al hacer clic en "Guardar", autorizo recibir el pago de mis ganancias en la cuenta relacionada.</p>
                                            <input type='submit' id="submitYape" value="Guardar" name="registrarCuenta">
                                        </form>
                                    </div>
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="modal-body" id="bodyYape2">
									<div class="contenedor__login-register">
                                        <form id="formYape2" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <p class="pcentral"><span>Nombres y apellidos:</span><br><?php echo $nombresyape.' '.$apellidosyape?></p>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <p class="pmedio"><span>N° de teléfono:</span><br><?php echo $yape?></p>
                                            </div>
                                            <hr id="hr-register">
                                            <div class="filaregister" id="filaEditar">
                                                <label id="labelEditarYape">Editar</label>
                                            </div>
                                        </form>
                                    </div>
                                        </div>
                                        <div class="modal-body" id="bodyYapeEditar">
									<div class="contenedor__login-register">
                                        <form id="formYapeEditar" method="POST" class="formulario__register">
                                            <p class="pdatos"><span>I. DATOS DEL TITULAR:</span></p>
                                            <div class="filaregister">
                                                <input type="text" placeholder="Nombres" name="nombresyape" id="nombresyape" value="<?php echo $nombresyape?>" required>
                                                <input type="text" placeholder="Apellidos" name="apellidosyape" id="apellidosyape" value="<?php echo $apellidosyape?>" required>
                                            </div>
                                            <p class="pdatos"><span>II. DATOS DE LA CUENTA:</span></p>
                                            <div class="filaregister">
                                                <input type="number" placeholder="(+51) N° de teléfono" name="yape" id="yape" min="0" value="<?php echo $yape?>" required>
                                                <input type="number" id="inputIdpro2" style="display:none" value="<?php echo $idpro;?>">
                                            </div>
                                            <hr id="hr-register">
                                            <p class="pguardar">Al hacer clic en "Guardar", autorizo recibir el pago de mis ganancias en la cuenta relacionada.</p>
                                            <input type='submit' id="submitYape" value="Guardar" name="registrarCuenta">
                                        </form>
                                    </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
										</div>
									</div>
								</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ctn-historial" id="histopro">
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
                $consultavistas ="SELECT *, idpago as idpagos, (select start from citas where idpay=idpagos) as startCitas FROM pagos WHERE usuariopro = '".$idpro."' ORDER BY startCitas DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                $consultares=mysqli_query($conexion, $consultavistas);
                while ($lista=mysqli_fetch_array($consultares)) {
                    $consultacita = "SELECT *, id as idu,(select nombres from usuarios where id=idu) as nombresPaciente, (select apellidos from usuarios where id=idu) as apellidosPaciente FROM citas WHERE idpay = '".$lista['idpago']."' ";
                    $resultadocita = mysqli_query($conexion, $consultacita);
                    if ($resultadocita) {
                        while ($rowcita = $resultadocita->fetch_array()){
                            $idcita = $rowcita['idcita'];
                            $paciente = $rowcita['nombresPaciente'].' '.$rowcita['apellidosPaciente'];
                            $costo = $rowcita['localizacion'];
                            $start = $rowcita['start'];
                            $abonado = $rowcita['abonado'];
                            $asistencia = $rowcita['asistencia'];
                            $fechapago = $start;
                            list($fecha, $hora) = explode(" ", $fechapago);
                            $horafinal = explode(":00", $hora);
                            $timestamp = strtotime($fecha);
                            $newFecha = date("d/m/Y", $timestamp);
                        }
                    }
                ?>
                <hr>
                <div class="box-body">
                    <div class="boxhisto1">
                        <div class="historia1">
                            <p><span>N° de cita:</span><br><?php echo $idcita?></p>
                            <p><span>Fecha y hora de cita:</span><br><?php echo $newFecha . " a las " . $horafinal[0] . ":00";?></p>
                        </div>
                        <div class="historia2">
                            <p><span>Pagado por:</span><br><?php echo $paciente?></p>
                            <p><span>Método de pago:</span><br><?php echo $lista['metodopago']?></p>
                        </div>
                    </div>
                    <div class="boxhisto2">
                        <div class="historia3">
                            <p><span>Pagado a:</span><br><?php echo $doctor.' '.$nombrespro.' '.$apellidospro?></p>
                            <p><span>Asistencia:</span><br><?php echo $asistencia?></p>
                        </div>
                        <div class="historia4">
                            <p><span>Precio de cita:</span><br>S/ <?php echo $costo?></p>
                            <?php
                            if($abonado=='NO'){
                            ?>
                            <p><span style="color:#FFC107">Por abonar (82% Precio de cita):</span><br>S/ <?php echo (82*$costo)/100?></p>
                            <?php
                            }else if($abonado=='F'){
                            ?>
                            <p><span style="color:#FFC107">Por pagar (18% Precio de cita):</span><br>S/ <?php echo (18*$costo)/100?></p>
                            <?php
                            }else if($abonado=='P'){
                            ?>
                            <p><span style="color:#FF0800">Pagado (18% Precio de cita):</span><br>S/ <?php echo (18*$costo)/100?></p>
                            <?php
                            }else{
                            ?>
                            <p><span style="color:#00d418">Abonado (82% Precio de cita):</span><br>S/ <?php echo (82*$costo)/100?></p>
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
    <script src="<?php echo $_ENV['APP_URL'];?>js/editarCuentaBancaria.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/editarYape.js"></script>
</body>
<?php echo footermed();?>
</html>