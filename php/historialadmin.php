<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historial de Pagos - The Med Universe | Administrador</title>
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
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
<?php echo headernav();include './php/navbarAdmin.php';?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo $_ENV['APP_URL'];?>js/buscadorAdmin.js"></script>
<script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
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
            $consultacuenta = "SELECT * FROM cuentabancariaadmin WHERE idadmin = '".$_SESSION['idAdmin']."' ";
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
        
            <script>
                window.addEventListener("DOMContentLoaded", function(){
                    const formCuentaBancariaAdmin = document.getElementById("formCuentaBancaria");
            
                    formCuentaBancariaAdmin.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idadmin", $("#inputIdadmin").val());
                        if($("#nombres").val()!='' && $("#apellidos").val()!='' && $("#doctitular").val()!='' && $("#numdoctitular").val()!='' && $("#nactitular").val()!='' && $("#domiciliotitular").val()!='' && $("#nombrebanco").val()!='' && $("#tipocuenta").val()!='' && $("#codigocuenta").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/registrarCuentaBancariaAdmin.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta Bancaria Registrada',
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
                    const formCuentaBancariaAdmin = document.getElementById("formCuentaEditar");
            
                    formCuentaBancariaAdmin.addEventListener("submit", async function(e){
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append("idadmin", $("#inputIdadmin2").val());
                        if($("#nombres").val()!='' && $("#apellidos").val()!='' && $("#doctitular").val()!='' && $("#numdoctitular").val()!='' && $("#nactitular").val()!='' && $("#domiciliotitular").val()!='' && $("#nombrebanco").val()!='' && $("#tipocuenta").val()!='' && $("#codigocuenta").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/editarCuentaBancariaAdmin.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Cuenta Bancaria Registrada',
                                    text: 'Ahora podrá recibir sus pagos mensuales.',
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
                            <p style="text-align:center"><span>¿AÚN NO COBRA SUS GANANCIAS?</span><br>Agregue una cuenta bancaria donde pueda recibir sus pagos mensuales.</p>
                        </div>
                        <div class="historia4" id="hbuttons">
                            <!-- modal -->
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
                                                <input type="number" id="inputIdadmin" style="visibility:hidden" value="<?php echo $idpro;?>">
                                            </div>
                                            <hr id="hr-register">
                                            <p class="pguardar">Al hacer clic en "Guardar", autorizo recibir el pago de mis ganancias en la cuenta relacionada.</p>
                                            <input type='submit' value="Guardar" name="registrarCuenta">
                                        </form>
                                    </div>
                                            </div>
                                        <?php
                                        } else{
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
                                                <label id="labelEditar" style="margin-top:15px">Editar</label>
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
                                                <input type="number" id="inputIdadmin2" style="visibility:hidden" value="<?php echo $idpro;?>">
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
                        <!-- end modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ctn-historial" id="histoadmin">
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
                        <p><span style="color:#FFC107">Por Abonar:</span><br>S/. 1</p>
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
    <script src="<?php echo $_ENV['APP_URL'];?>js/editarCuentaBancaria.js"></script>
</body>
<?php echo footermed();?>
</html>