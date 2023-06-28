<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historia Clínica - The Med Universe | Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL'];?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/navpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hclinicapro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
</head>
<body id="body">
<?php echo headernav()?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&obpro.js"></script>
    <main>
    <div class="boxclini">
        <?php
            include './php/conexion_paciente.php';
            $consultacita = "SELECT *, (select idcita from citas where idpay='".$_GET['idHistoria']."') as nrocita, (select start from citas where idpay='".$_GET['idHistoria']."') as fyhcita, (select idupro from citas where idpay='".$_GET['idHistoria']."') as iduPro FROM hclinica WHERE idhc = '".$idHistoria."' ";
            $resultadocita = mysqli_query($conexion, $consultacita);
            if ($resultadocita) {
                while ($lista = $resultadocita->fetch_array()){
                    $nrocita = $lista['nrocita'];
                    $iduPro = $lista['iduPro'];
                    $fyhcita = $lista['fyhcita'];
                    $timestampFyH = strtotime($fyhcita); 
                    $newDateFyH = date("d/m/Y H:i:s", $timestampFyH );
                    $horacita = explode(":", $newDateFyH);
                    
                    list($fecha, $hora) = explode(" ", $fyhcita);
                    $horafinal = explode(":00", $hora);
                    $timestamp = strtotime($fecha);
                    $fechastr = strtotime($fecha);
                    $newFecha = date("d/m/Y", $timestamp);

                    if($horafinal[0]=='01'){
                        $enlace=" a la ";
                    }else{
                    $enlace=" a las ";
                    }
                    $tiempoFinal=$newFecha . $enlace . $horafinal[0] . ":00";
                    $idhc = $lista['idhc'];
                    $idmed = $lista['idmed'];
                    $tiempoenf = $lista['tiempoenf'];
                    $inicio = $lista['inicio'];
                    $curso = $lista['curso'];
                    $sintomas = $lista['sintomas'];
                    $relato = $lista['relato'];
                    $anthf = $lista['anthf'];
                    $antpp = $lista['antpp'];
                    $medicamentos = $lista['medicamentos'];
                    $alergias = $lista['alergias'];
                    $freccar = $lista['freccar'];
                    $frecres = $lista['frecres'];
                    $sato = $lista['sato'];
                    $presion = $lista['presion'];
                    $temperatura = $lista['temperatura'];
                    $peso = $lista['peso'];
                    $talla = $lista['talla'];
                    $imc = $lista['imc'];
                    if($freccar!=''){
                        $freccar=$freccar.' lpm';
                    }
                    if($frecres!=''){
                        $frecres=$frecres.' rpm';
                    }
                    if($sato!=''){
                        $sato=$sato.' %';
                    }
                    if($temperatura!=''){
                        $temperatura=$temperatura.' °C';
                    }
                    if($peso!=''){
                        $peso=$peso.' kg';
                    }
                    if($talla!=''){
                        $talla=$talla.' m';
                    }
                    $evalfisica = $lista['evalfisica'];
                    $prures = $lista['prures'];
                    $diagpre = $lista['diagpre'];
                    $diagdef = $lista['diagdef'];
                    $tratfarm = $lista['tratfarm'];
                    $indicec = $lista['indicec'];
                    $indicesp = $lista['indicesp'];
                    $archivoc = $lista['archivoc'];
                    $grabacion = $lista['grabacion'];
                    $anexouno = $lista['anexouno'];
                    $anexodos = $lista['anexodos'];
                    $anexotres = $lista['anexotres'];
                    $anexocuatro = $lista['anexocuatro'];
                    $comentario = $lista['comentario'];
                }
            }
            $consultamed = "SELECT * FROM usuariospro WHERE idpro = '".$iduPro."' ";
            $resultadomed = mysqli_query($conexion, $consultamed);
            if ($resultadomed) {
                while ($rowmed = $resultadomed->fetch_array()){
                    $idpro = $rowmed['idpro'];
                    $nombrespro = $rowmed['nombrespro'];
                    $apellidospro = $rowmed['apellidospro'];
                    $nacimientopro = $rowmed['nacimientopro'];
                    $sexopro = $rowmed['sexopro'];
                    $paispro = $rowmed['paispro'];
                    $ciudadpro = $rowmed['ciudadpro'];
                    $especialidad = $rowmed['especialidad'];
                    $profesion = "Medicina";
                    if ($especialidad == "Psicología"){
                        $profesion = "Psicología";
                    }
                    $timestampNacPro = strtotime($nacimientopro); 
                    $newDateNacPro = date("d/m/Y", $timestampNacPro );
                    if($sexopro == "Femenino"){
                        $doctor = "Dra.";
                    }else{
                        $doctor = "Dr.";
                    }
                }
            }
        ?>
            <div class="ctn-sideperfil">
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'] . 'fotoperfil/mini_' . $fotoperfil . "?v=" . rand() ?>" id="fppro" alt="Foto de perfil">
                </div>
                <div class="ctn-titrecord">
                    <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5);?></h2>
                </div>
                <div class="ctn-record">
                    <ul class="listarecord">
        <?php
        $CantidadMostrar=10000;
        // Validado  la variable GET
        $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
        $TotalReg       =mysqli_query($conexion, "SELECT * FROM citas");
        $totalr = mysqli_num_rows($TotalReg);
        //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
        $TotalRegistro  =ceil($totalr/$CantidadMostrar);
        //Operacion matematica para mostrar los siquientes datos.
        $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
        //Consulta SQL
        $consultavistas ="SELECT * FROM citas WHERE id = '".$id."' AND idpay <> '0' AND asistenciapac <> 'No Asistió' AND asistencia <> 'No Asistió' ORDER BY start DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
        $consultares=mysqli_query($conexion, $consultavistas);
        while ($lista2=mysqli_fetch_array($consultares)) {
            $fechacita = $lista2['start'];
            $timestampFC = strtotime($fechacita); 
            $newDateFC = date("d/m/Y", $timestampFC );
            $consultamed2 = "SELECT * FROM usuariospro WHERE idpro = '".$lista2['idupro']."' ";
            $resultadomed2 = mysqli_query($conexion, $consultamed2);
            if ($resultadomed2) {
                while ($rowmed2 = $resultadomed2->fetch_array()){
                    $idpro2 = $rowmed2['idpro'];
                    $nombrespro2 = $rowmed2['nombrespro'];
                    $apellidospro2 = $rowmed2['apellidospro'];
                    $especialidad2 = $rowmed2['especialidad'];
                    $sexopro2 = $rowmed2['sexopro'];
                    if($sexopro2 == "Femenino"){
                        $doctor2 = "Dra.";
                    }else{
                        $doctor2 = "Dr.";
                    }
                }
            }
            $consultamed3 = "SELECT tiempoenf FROM hclinica WHERE idhc = '".$lista2['idpay']."' ";
            $resultadomed3 = mysqli_query($conexion, $consultamed3);
            if ($resultadomed3) {
                while ($rowmed3 = $resultadomed3->fetch_array()){
                    $tiempoenfermedad = $rowmed3['tiempoenf'];
                }
            }
        ?>
                        <a href="<?php echo $_ENV['APP_URL'].'hclinicapro/'.$id.'/'.$lista2['idpay'];?>"><li style="<?php if($lista2['idpay']==$idHistoria){echo 'background:#F0F2F5;';}?>"><span style="<?php if($tiempoenfermedad==''){echo 'color:#FFC107;';}else{echo 'color:#00d418;';}?>"><?php echo $newDateFC . ': ';?></span><span class="spanlista"><?php echo $especialidad2;?></span></li></a>
        <?php
        }
        ?>
                    </ul>
                </div>
            </div>
        <?php
        include './php/conexion_paciente.php'; 
            if($idmed==$_SESSION['idpro'] && empty($tiempoenf)){
        ?>
        <script>
            window.addEventListener("DOMContentLoaded", function(){
                const formHistoria = document.getElementById("formHistoria");
        
                formHistoria.addEventListener("submit", async function(e){
                    e.preventDefault();
                    const {isConfirmed} = await Swal.fire({
                        title: 'Historia Clínica',
                        text: "¿Está seguro de guardar la historia clínica? Ya no la podrá modificar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00d418',
                        cancelButtonColor: '#0052d4',
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'No'
                    });
            
                    if (isConfirmed) {
                        const formData = new FormData(this);
                        formData.append("idhc", <?php echo $idHistoria;?>);
                        if($("#idantdos").val()!=''){
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/guardarHistoria.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Historia Clínica guardada',
                                    text: '',
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
        <form id="formHistoria" action="POST" enctype="multipart/form-data">
            <div class="ctn-hclinica">
                <div class="ctn-editarpc">
                    <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5);?></h2>
                </div>
                <div class="box-body">
                    <div class="boxhc" id="boxintrocita">
                        <h2>I. REGISTRO DE CITA</h2>
                        <div class="divhisto" id="introcita">
                            <input type="hidden" id="noneid" value="<?php echo $idhc?>">
                            <p><span>N° de cita:</span><br><?php echo $nrocita?></p>
                            <p><span>Fecha y hora de cita:</span><br><?php echo $tiempoFinal;?></p>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $fecha = $fechastr - strtotime($nacimiento) + 86400;
                    $edad = floor($fecha / 31556926);

                    $fecha2 = $fechastr - strtotime($nacimientopro) + 86400;
                    $edad2 = floor($fecha2 / 31556926);
                    ?>
                    <div class="boxhc" id="boxfiliacion">
                        <h2>II. FILIACIÓN</h2>
                        <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $nombres.' '.$apellidos?></p>
                        <div class="divhisto" id="filiacion">
                            <div class="divhisto" id="filiacion1">
                                <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNac?> (<?php echo $edad?> años)</p>
                                <p><span>Género:</span><br><?php echo $sexo?></p>
                            </div>
                            <div class="divhisto" id="filiacion2">
                                <p><span>País:</span><br><?php echo $pais?></p>
                                <p><span>Ciudad:</span><br><?php echo $ciudad?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxanamnesis">
                        <h2>III. ANAMNESIS</h2>
                        <div class="divhisto" id="anamnesis">
                            <p><textarea id="idtiempo" name="tiempoenf" placeholder='Tiempo de enfermedad' class="txthc" rows="1" maxlength="350" required></textarea></p>
                            <p><select name="inicio" id="idinicio" class="txthc" required><option class="select-opt" value="">Forma de inicio</option><option value="Insidioso">Insidioso</option><option value="Brusco">Brusco</option></select></p>
                        </div>
                        <div class="divhisto" id="anamnesis">
                            <p><select name="curso" id="idcurso" class="txthc" required><option class="select-opt" value="">Curso</option><option value="Progresivo">Progresivo</option><option value="Estacionario">Estacionario</option><option value="Intermitente">Intermitente</option></select></p>
                            <p><textarea id="idsintomas" name="sintomas" placeholder='Signos y síntomas principales' class="txthc" rows="1" maxlength="350" required></textarea></p>
                        </div>
                        <p id="filrelato"><textarea name="relato" placeholder='Relato cronológico' class="txthc" id="idrelato" rows="3" maxlength="1000" required></textarea></p>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxantecedentes">
                        <h2>IV. ANTECEDENTES</h2>
                        <div class="divhisto" id="antecedentes">
                            <p><textarea id="idantuno" name="anthf" placeholder='Antecedentes heredo - familiares' class="txthc" rows="3" maxlength="350" required></textarea></p>
                            <p><textarea id="idantdos" name="antpp" placeholder='Antecedentes personales - patológicos' class="txthc" rows="3" maxlength="350" required></textarea></p>
                        </div>
                        <div class="divhisto" id="antecedentes2">
                            <p><textarea id="idmedicamentos" name="medicamentos" placeholder='Medicamentos' class="txthc" rows="1" maxlength="350" required></textarea></p>
                            <p><textarea id="idalergias" name="alergias" placeholder='Alergias' class="txthc" rows="1" maxlength="350" required></textarea></p>
                        </div>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxexafisico">
                        <h2>V. EXAMEN FÍSICO (OPCIONAL)</h2>
                        <div class="divhisto" id="exafisico">
                            <div class="divhisto" id="fisi10">
                                <p id="idfreccar" class="fisizq"><input type="number" placeholder="Frec. cardiaca (lpm)" id="txtfreccar" min="0" max="1000" name="freccar" class="txthc"></p>
                                <p id="idfrecres" class="fisder"><input type="number" placeholder="Frec. respiratoria (rpm)" id="txtfrecres" min="0" max="100" name="frecres" class="txthc"></p>
                            </div>
                            <div class="divhisto" id="fisi11">
                                <p id="idsat" class="fisizq"><input type="number" placeholder="Sat. de oxígeno (%)" id="txtsato" min="0" max="100" name="sato" class="txthc"></p>
                                <p id="idpresion" class="fisder"><input type="text" placeholder="Presión arterial (S/D)" id="txtpresion" name="presion" class="txthc" maxlength="15"></p>
                            </div>
                        </div>
                        <div class="divhisto" id="exafisico2">
                            <div class="divhisto" id="fisi20">
                                <p id="idtemperatura" class="fisizq"><input type="number" placeholder="Temperatura (°C)" id="txttemperatura" min="0" max="100" name="temperatura" class="txthc" step=".1"></p>
                                <p id="idpeso" class="fisder"><input type="number" placeholder="Peso (kg)" id="txtpeso" min="0" max="1000" name="peso" class="txthc" step=".1"></p>
                            </div>
                            <div class="divhisto" id="fisi21">
                                <p id="idtalla" class="fisizq"><input type="number" placeholder="Talla (m)" id="txttalla" min="0" max="10" name="talla" class="txthc" step=".01"></p>
                                <p id="idimc" class="fisder"><input type="text" placeholder="Índice de Masa Corporal" id="txtimc" name="imc" class="txthc" maxlength="25" readonly><br><input type="button" name="calcularimc" value="Calcular IMC" onclick="calculaimc()" id="calcularIMC"></input></p>
                            </div>
                        </div>
                        <p id="filef"><textarea name="evalfisica" placeholder='Evaluación física' class="txthc" id="txtevalf" rows="3" maxlength="1000"></textarea></p>
                    </div>
                    <script type="text/javascript">
                        function calculaimc(){
                            var peso = Number(document.getElementById('txtpeso').value);
                            var talla = Number(document.getElementById('txttalla').value);
                            var imc = (peso/(talla*talla)).toFixed(2);
                            if(imc < 18.5){
                                var condicion = imc+' (Bajo peso)';
                            }else if(imc >= 18.5 && imc < 25){
                                var condicion = imc+' (Peso saludable)';
                            }else if(imc >= 25 && imc < 30){
                                var condicion = imc+' (Sobrepeso)';
                            }else if(imc >= 30){
                                var condicion = imc+' (Obesidad)';
                            }else{
                                var condicion = '';
                            }

                            document.getElementById('txtimc').value = condicion;
                        }
                    </script>
                    <hr>
                    <div class="boxhc" id="boxexacomple">
                        <h2>VI. EXÁMENES COMPLEMENTARIOS (OPCIONAL)</h2>
                        <p id="filpru"><textarea id="idpruebas" name="prures" placeholder='Pruebas y resultados' class="txthc" rows="3" maxlength="1000"></textarea></p>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxdiagnostico">
                        <h2>VII. DIAGNÓSTICOS</h2>
                        <ul><li id="licodigo">Encontrará el código CIE-10 del diagnóstico en: <a id="codigocie" href="https://eciemaps.mscbs.gob.es/ecieMaps/browser/index_10_mc.html" target="_blank">Buscar código CIE-10</a>.</li></ul>
                        <div class="divhisto" id="diagnostico">
                            <p><textarea id="iddiaguno" name="diagpre"  placeholder='Diagnósticos presuntivos con CIE-10' class="txthc" rows="3" maxlength="350" required></textarea></p>
                            <p><textarea id="iddiagdos" name="diagdef" placeholder='Diagnósticos definitivos con CIE-10' class="txthc" rows="3" maxlength="350" required></textarea></p>
                        </div>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxtratamiento">
                        <h2>VIII. PLAN DE TRABAJO</h2>
                        <p id="filtrata"><textarea id="idtratamiento" name="tratfarm" placeholder='Tratamiento farmacológico' class="txthc" rows="3" maxlength="1000" required></textarea></p>
                        <div class="divhisto" id="tratamiento">
                            <p><textarea id="idindiuno" name="indicec" placeholder='Indicaciones de exámenes complementarios' class="txthc" rows="3" maxlength="350" required></textarea></p>
                            <p><textarea id="idindidos" name="indicesp" placeholder='Indicaciones adicionales' class="txthc" rows="3" maxlength="350" required></textarea></p>
                        </div>
                    </div>
                    <hr>
                    <div class="boxhc" id="boxanexos">
                        <h2>IX. ANEXOS DEL PROFESIONAL (OPCIONAL)</h2>
                        <div class="divhisto" id="anexos">
                            <label class="receta" id="labelevi" for="evidencia">Imagen de receta médica</label>
                            <input onchange="evilabel(this.value)" type="file" name="txtarc" class="evidencia" id="evidencia" data-multiple-caption="{count} files selected">
                            <script>function evilabel(valor){document.querySelector('.receta').innerText = valor;document.querySelector('.receta').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.receta').innerText = 'Imagen de receta médica';
                                document.querySelector('.receta').style.color = '#777777';
                            }}</script>
                            <label class="grabacion" id="labelevi2" for="evidencia2">Documento o imagen de orientación</label>
                            <input onchange="evilabel2(this.value)" type="file" name="txtgrabacion" class="evidencia2" id="evidencia2" data-multiple-caption="{count} files selected">
                            <script>function evilabel2(valor){document.querySelector('.grabacion').innerText = valor;document.querySelector('.grabacion').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.grabacion').innerText = 'Documento o imagen de orientación';
                                document.querySelector('.grabacion').style.color = '#777777';
                            }}</script>
                        </div>
                    </div>
                    <hr>
                <div class="boxhc" id="boxanexos">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE</h2>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexouno;?>" download><?php if($anexouno!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexodos;?>" download><?php if($anexodos!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexotres;?>" download><?php if($anexotres!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexocuatro;?>" download><?php if($anexocuatro!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <p id="filrelato"><span>Motivo de consulta:</span><br><?php echo $comentario;?></p>
                </div>
                    <hr>
                    <div class="boxhc" id="boxfiliacion">
                        <h2>XI. PROFESIONAL TRATANTE</h2>
                        <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $doctor.' '.$nombrespro.' '.$apellidospro?></p>
                        <div class="divhisto" id="filiacion">
                            <div class="divhisto" id="filiacion1">
                                <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNacPro?> (<?php echo $edad2?> años)</p>
                                <p><span>Género:</span><br><?php echo $sexopro?></p>
                            </div>
                            <div class="divhisto" id="filiacion2">
                                <p><span>País, ciudad:</span><br><?php echo $paispro?>, <?php echo $ciudadpro?></p>
                                <p><span>Especialidad:</span><br><?php echo $especialidad;?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="boxhc">
                        <div class="divhisto">
                            <p id="pacredito">Al hacer clic en "Guardar", declaro ser quien registró los datos consignados en el presente formulario, así como la veracidad de ellos.</p>
                        </div>
                    </div>
                    <input type="submit" name="guardarhc" id="guardarhc" value="Guardar">
                </div>
            </div>
        </form>
<?php
            } else if($idmed!=$_SESSION['idpro'] && empty($tiempoenf)){
        ?>
        <div class="ctn-hclinica">
			<div class="ctn-editarpc">
                <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5)?></h2>
            </div>
            <div class="box-body">
                <div class="boxhc" id="boxintrocita">
                    <h2>I. REGISTRO DE CITA</h2>
                    <div class="divhisto" id="introcita">
                        <p><span>N° de cita:</span><br><?php echo $nrocita?></p>
                        <p><span>Fecha y hora de cita:</span><br><?php echo $tiempoFinal;?></p>
                    </div>
                </div>
                <hr>
                <?php
                $fecha = $fechastr - strtotime($nacimiento) + 86400;
                $edad = floor($fecha / 31556926);

                $fecha2 = $fechastr - strtotime($nacimientopro) + 86400;
                $edad2 = floor($fecha2 / 31556926);
                ?>
                <div class="boxhc" id="boxfiliacion">
                    <h2>II. FILIACIÓN</h2>
                    <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $nombres.' '.$apellidos?></p>
                    <div class="divhisto" id="filiacion">
                        <div class="divhisto" id="filiacion1">
                            <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNac?> (<?php echo $edad?> años)</p>
                            <p><span>Género:</span><br><?php echo $sexo?></p>
                        </div>
                        <div class="divhisto" id="filiacion2">
                            <p><span>País:</span><br><?php echo $pais?></p>
                            <p><span>Ciudad:</span><br><?php echo $ciudad?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanamnesis">
                    <h2>III. ANAMNESIS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxantecedentes">
                    <h2>IV. ANTECEDENTES</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxexafisico">
                    <h2>V. EXAMEN FÍSICO</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxexacomple">
                    <h2>VI. EXÁMENES COMPLEMENTARIOS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxdiagnostico">
                    <h2>VII. DIAGNÓSTICOS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxtratamiento">
                    <h2>VIII. PLAN DE TRABAJO</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <h2>IX. ANEXOS DEL PROFESIONAL</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE</h2>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexouno;?>" download><?php if($anexouno!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexodos;?>" download><?php if($anexodos!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexotres;?>" download><?php if($anexotres!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexocuatro;?>" download><?php if($anexocuatro!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <p id="filrelato"><span>Motivo de consulta:</span><br><?php echo $comentario;?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxfiliacion">
                    <h2>XI. PROFESIONAL TRATANTE</h2>
                    <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $doctor.' '.$nombrespro.' '.$apellidospro?></p>
                    <div class="divhisto" id="filiacion">
                        <div class="divhisto" id="filiacion1">
                            <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNacPro?> (<?php echo $edad2?> años)</p>
                            <p><span>Género:</span><br><?php echo $sexopro?></p>
                        </div>
                        <div class="divhisto" id="filiacion2">
                            <p><span>País, ciudad:</span><br><?php echo $paispro?>, <?php echo $ciudadpro?></p>
                            <p><span>Especialidad:</span><br><?php echo $especialidad;?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <h2 id="nodatos">El profesional aún no ha registrado los datos de esta cita en la Historia Clínica.</h2>
            </div>
        </div>
        <?php
            } else{
        ?>
        <div id="boxclini2">
        <div class="ctn-hclinica">
			<div class="ctn-editarpc">
                <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5)?></h2>
            </div>
            <div class="box-body">
                <div class="boxhc" id="boxintrocita">
                    <h2>I. REGISTRO DE CITA</h2>
                    <div class="divhisto" id="introcita">
                        <p><span>N° de cita:</span><br><?php echo $nrocita?></p>
                        <p><span>Fecha y hora de cita:</span><br><?php echo $tiempoFinal;?></p>
                    </div>
                </div>
                <hr>
                <?php
                $fecha = $fechastr - strtotime($nacimiento) + 86400;
                $edad = floor($fecha / 31556926);

                $fecha2 = $fechastr - strtotime($nacimientopro) + 86400;
                $edad2 = floor($fecha2 / 31556926);
                ?>
                <div class="boxhc" id="boxfiliacion">
                    <h2>II. FILIACIÓN</h2>
                    <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $nombres.' '.$apellidos?></p>
                    <div class="divhisto" id="filiacion">
                        <div class="divhisto" id="filiacion1">
                            <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNac?> (<?php echo $edad?> años)</p>
                            <p><span>Género:</span><br><?php echo $sexo?></p>
                        </div>
                        <div class="divhisto" id="filiacion2">
                            <p><span>País:</span><br><?php echo $pais?></p>
                            <p><span>Ciudad:</span><br><?php echo $ciudad?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanamnesis">
                    <h2>III. ANAMNESIS</h2>
                    <div class="divhisto guardado" id="anamnesis">
                        <p><span>Tiempo de enfermedad:</span><br><?php echo $tiempoenf?></p>
                        <p><span>Forma de inicio:</span><br><?php echo $inicio?></p>
                    </div>
                    <div class="divhisto guardado" id="anamnesis">
                        <p><span>Curso:</span><br><?php echo $curso?></p>
                        <p><span>Signos y síntomas principales:</span><br><?php echo $sintomas?></p>
                    </div>
                    <p id="filrelato"><span>Relato cronológico:</span><br><?php echo $relato?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxantecedentes">
                    <h2>IV. ANTECEDENTES</h2>
                    <div class="divhisto guardado" id="antecedentes">
                        <p><span>Antecedentes heredo - familiares:</span><br><?php echo $anthf?></p>
                        <p><span>Antecedentes personales - patológicos:</span><br><?php echo $antpp?></p>
                    </div>
                    <div class="divhisto guardado" id="antecedentes2">
                        <p><span>Medicamentos:</span><br><?php echo $medicamentos?></p>
                        <p><span>Alergias:</span><br><?php echo $alergias?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxexafisico">
                    <h2>V. EXAMEN FÍSICO (OPCIONAL)</h2>
                    <div class="divhisto" id="exafisico">
                        <div class="divhisto" id="fisi10">
                            <p><span>Frec. cardiaca:</span><br><?php echo $freccar?></p>
                            <p><span>Frec. respiratoria:</span><br><?php echo $frecres?></p>
                        </div>
                        <div class="divhisto" id="fisi11">
                            <p><span>Sat. de oxígeno:</span><br><?php echo $sato?></p>
                            <p><span>Presión arterial:</span><br><?php echo $presion?></p>
                        </div>
                    </div>
                    <div class="divhisto" id="exafisico2">
                        <div class="divhisto" id="fisi20">
                            <p><span>Temperatura:</span><br><?php echo $temperatura?></p>
                            <p><span>Peso:</span><br><?php echo $peso?></p>
                        </div>
                        <div class="divhisto" id="fisi21">
                            <p><span>Talla:</span><br><?php echo $talla?></p>
                            <p><span>Índice de Masa Corporal:</span><br><?php echo $imc?></p>
                        </div>
                    </div>
                    <p id="filef"><span>Evaluación física:</span><br><?php echo $evalfisica?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxexacomple">
                    <h2>VI. EXÁMENES COMPLEMENTARIOS (OPCIONAL)</h2>
                    <p id="filpru"><span>Pruebas y resultados:</span><br><?php echo $prures?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxdiagnostico">
                    <h2>VII. DIAGNÓSTICOS</h2>
                    <div class="divhisto guardado" id="diagnostico">
                        <p><span>Diagnósticos presuntivos:</span><br><?php echo $diagpre?></p>
                        <p><span>Diagnósticos definitivos:</span><br><?php echo $diagdef?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxtratamiento">
                    <h2>VIII. PLAN DE TRABAJO</h2>
                    <p id="filtrata"><span>Tratamiento farmacológico:</span><br><?php echo $tratfarm?></p>
                    <div class="divhisto guardado" id="tratamiento">
                        <p><span>Indicaciones de exámenes complementarios:</span><br><?php echo $indicec?></p>
                        <p><span>Indicaciones adicionales:</span><br><?php echo $indicesp?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <h2>IX. ANEXOS DEL PROFESIONAL</h2>
                    <div class="divhisto guardado" id="anexos">
                        <p><span>Imagen de receta médica:</span><br><a href="<?php echo $_ENV['APP_URL'].'complementarios/'.$archivoc;?>" download><?php if($archivoc!=''){echo 'Descargar receta';};?></a></p>
                        <p><span>Documento o imagen de orientación:</span><br><a href="<?php echo $_ENV['APP_URL'].'grabaciones/'.$grabacion;?>" download><?php if($grabacion!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE</h2>
                    </div>
                    <div class="divhisto guardado" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexouno;?>" download><?php if($anexouno!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexodos;?>" download><?php if($anexodos!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <div class="divhisto guardado" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexotres;?>" download><?php if($anexotres!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'anexos/'.$anexocuatro;?>" download><?php if($anexocuatro!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <p id="filrelato"><span>Motivo de consulta:</span><br><?php echo $comentario;?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxfiliacion">
                    <h2>XI. PROFESIONAL TRATANTE</h2>
                    <p id="filnombre"><span>Nombres y apellidos:</span><br><?php echo $doctor.' '.$nombrespro.' '.$apellidospro?></p>
                    <div class="divhisto" id="filiacion">
                        <div class="divhisto" id="filiacion1">
                            <p><span>F. Nacimiento (Edad):</span><br><?php echo $newDateNacPro?> (<?php echo $edad2?> años)</p>
                            <p><span>Género:</span><br><?php echo $sexopro?></p>
                        </div>
                        <div class="divhisto" id="filiacion2">
                            <p><span>País, ciudad:</span><br><?php echo $paispro?>, <?php echo $ciudadpro?></p>
                            <p><span>Especialidad:</span><br><?php echo $especialidad;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php
            }
        ?>
    </div>
    </main>
</body>
<?php echo footermed();?>
</html>