<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historia Clínica - The Med Universe | Paciente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hclinicapro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hclinica.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body id="body">
<?php echo headernav();include './php/navbar.php';?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="boxclini">
        <?php
            $consultacita = "SELECT *, (select idcita from citas where idpay='".$idHistoria."') as nrocita, (select start from citas where idpay='".$idHistoria."') as fyhcita FROM hclinica WHERE idhc = '".$idHistoria."' ";
            $resultadocita = mysqli_query($conexion, $consultacita);
            if ($resultadocita) {
                while ($lista = $resultadocita->fetch_array()){
                    $nrocita = $lista['nrocita'];
                    $fyhcita = $lista['fyhcita'];
                    list($fecha, $hora) = explode(" ", $fyhcita);
                    $horafinal = explode(":00", $hora);
                    $timestamp = strtotime($fecha);
                    $fechastr = strtotime($fecha);
                    $newFecha = date("d/m/Y", $timestamp);
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
                    $comen = preg_replace("/<br \/>/" , "" , $comentario);
                }
            }
            $consultamed = "SELECT * FROM usuariospro WHERE idpro = '".$idmed."' ";
            $resultadomed = mysqli_query($conexion, $consultamed);
            if ($resultadomed) {
                while ($rowmed = $resultadomed->fetch_array()){
                    $idpro = $rowmed['idpro'];
                    $nombrespro = $rowmed['nombrespro'];
                    $apellidospro = $rowmed['apellidospro'];
                    $nacimientopro = $rowmed['nacimientopro'];
                    $timestampNacPro = strtotime($nacimientopro); 
                    $newDateNacPro = date("d/m/Y", $timestampNacPro );
                    $sexopro = $rowmed['sexopro'];
                    $paispro = $rowmed['paispro'];
                    $ciudadpro = $rowmed['ciudadpro'];
                    $especialidad = $rowmed['especialidad'];
                    $profesion = "Medicina";
                    if ($especialidad == "Psicología"){
                        $profesion = "Psicología";
                    }
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
            $idmedico = $lista2['idupro'];
            $idpagos2 = $lista2['idpay'];
            $consultamed2 = "SELECT especialidad FROM usuariospro WHERE idpro = '".$idmedico."' ";
            $resultadomed2 = mysqli_query($conexion, $consultamed2);
            if ($resultadomed2) {
                while ($rowmed2 = $resultadomed2->fetch_array()){
                    $especialidad2 = $rowmed2['especialidad'];
                }
            }
            $consultamed3 = "SELECT tiempoenf FROM hclinica WHERE idhc = '".$idpagos2."' ";
            $resultadomed3 = mysqli_query($conexion, $consultamed3);
            if ($resultadomed3) {
                while ($rowmed3 = $resultadomed3->fetch_array()){
                    $tiempoenfermedad = $rowmed3['tiempoenf'];
                }
            }
        ?>
                        <li><span style="<?php if($tiempoenfermedad==''){echo 'color:#FFC107;';}else{echo 'color:#00d418;';}?>"><?php echo $newDateFC . ': ';?></span><a href="<?php echo $_ENV['APP_URL'].'hclinica/'.$id.'/'.$idpagos2;?>"><span class="spanlista"><?php echo $especialidad2;?></span></a></li>
        <?php
        }
        ?>
                    </ul>
                </div>
            </div>
        <?php
            include './php/conexion_paciente.php';
            if(empty($tiempoenf)){
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
                        <p><span>Fecha y hora de cita:</span><br><?php echo $newFecha . " a las " . $horafinal[0] . ":00";?></p>
                    </div>
                </div>
                <hr>
                <?php
                $fecha = $fechastr - strtotime($nacimiento);
                $edad = floor($fecha / 31556926);

                $fecha2 = $fechastr - strtotime($nacimientopro);
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
                <?php 
                if($anexouno == '' && $anexodos == '' && $anexotres == '' && $anexocuatro == '' && $comentario == ''){
                ?>
        <script>
            window.addEventListener("DOMContentLoaded", function(){
                const formPaciente = document.getElementById("formPaciente");
        
                formPaciente.addEventListener("submit", async function(e){
                    e.preventDefault();
                    if($("#auno").val()=='' && $("#ados").val()=='' && $("#atres").val()=='' && $("#acuatro").val()=='' && $("#comentario").val()==''){
                        const text = await Swal.fire({
                            title: 'Información no guardada',
                            text: 'Debes ingresar la información y/o los archivos señalados.',
                            icon: 'error',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            return false;
                        });
                    } else{
                    const {isConfirmed} = await Swal.fire({
                        title: 'Anexos del paciente',
                        text: "¿Estás seguro de guardar la información? El profesional la podrá revisar en tu Historia Clínica.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00d418',
                        cancelButtonColor: '#0052d4',
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'No'
                    });
            
                    if (isConfirmed) {
                        const formData = new FormData(this);
                        formData.append("idhc", $("#noneid").val());
                        
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/guardarAnexos.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Anexos del paciente guardados',
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
                <form id="formPaciente" action="POST" enctype="multipart/form-data">
                <div class="boxhc" id="boxanexos">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE (OPCIONAL)</h2>
                        <div class="divinper">
                            <input type="submit" name="guardarap" id="guardarap" value="Guardar">
                        </div>
                    </div>
                        <input type="hidden" id="noneid" value="<?php echo $idhc?>">
                        <div class="divhisto" id="anexos">
                            <label class="cuno" id="labelauno" for="auno">Documento o imagen de ayuda diagnóstica</label>
                            <input onchange="aunolabel(this.value)" type="file" name="txtauno" class="auno" id="auno" data-multiple-caption="{count} files selected">
                            <script>function aunolabel(valor){document.querySelector('.cuno').innerText = valor;
                            document.querySelector('.cuno').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.cuno').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.cuno').style.color = '#777777';
                            }}</script>
                            <label class="cdos" id="labelados" for="ados">Documento o imagen de ayuda diagnóstica</label>
                            <input onchange="adoslabel(this.value)" type="file" name="txtados" class="ados" id="ados" data-multiple-caption="{count} files selected">
                            <script>function adoslabel(valor){document.querySelector('.cdos').innerText = valor;document.querySelector('.cdos').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.cdos').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.cdos').style.color = '#777777';
                            }}</script>
                        </div>
                        <div class="divhisto" id="anexos">
                            <label class="ctres" id="labelatres" for="atres">Documento o imagen de ayuda diagnóstica</label>
                            <input onchange="atreslabel(this.value)" type="file" name="txtatres" class="atres" id="atres" data-multiple-caption="{count} files selected">
                            <script>function atreslabel(valor){document.querySelector('.ctres').innerText = valor;document.querySelector('.ctres').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.ctres').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.ctres').style.color = '#777777';
                            }}</script>
                            <label class="ccuatro" id="labelacuatro" for="acuatro">Documento o imagen de ayuda diagnóstica</label>
                            <input onchange="acuatrolabel(this.value)" type="file" name="txtacuatro" class="acuatro" id="acuatro" data-multiple-caption="{count} files selected">
                            <script>function acuatrolabel(valor){document.querySelector('.ccuatro').innerText = valor;document.querySelector('.ccuatro').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.ccuatro').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.ccuatro').style.color = '#777777';
                            }}</script>
                        </div>
                        <p id="filrelato"><textarea name="comentario" placeholder='Cuéntale al profesional el motivo de tu consulta...' class="txthc" id="comentario" rows="3"></textarea></p>
                </div>
                </form>
                <?php
                } else{
                ?>
        <script>
            window.addEventListener("DOMContentLoaded", function(){
                const formPaciente2 = document.getElementById("formPaciente2");
        
                formPaciente2.addEventListener("submit", async function(e){
                    e.preventDefault();
                    
                    const {isConfirmed} = await Swal.fire({
                        title: 'Anexos del paciente',
                        text: "¿Estás seguro de guardar la información? El profesional la podrá revisar en tu Historia Clínica.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00d418',
                        cancelButtonColor: '#0052d4',
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'No'
                    });
            
                    if (isConfirmed) {
                        const formData = new FormData(this);
                        formData.append("idhc", $("#noneid").val());
                        
                            const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/editarAnexos.php", {
                                method: "post",
                                body: formData
                            });
                                const text = await Swal.fire({
                                    title: 'Anexos del paciente guardados',
                                    text: '',
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
                <div class="boxhc" id="boxanexos3">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE</h2>
                        <div class="divinper">
                            <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                        </div>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexouno;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexouno;?>"><?php if($anexouno!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexodos;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexodos;?>"><?php if($anexodos!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexotres;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexotres;?>"><?php if($anexotres!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexocuatro;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexocuatro;?>"><?php if($anexocuatro!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <p id="filrelato"><span>Motivo de consulta:</span><br><?php echo $comentario;?></p>
                </div>
                <form id="formPaciente2" action="POST" enctype="multipart/form-data">
                <div class="boxhc box2" id="boxanexos2">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE (OPCIONAL)</h2>
                        <div class="divinper">
                            <input type="submit" name="guardarap" id="guardarap" value="Guardar">
                        </div>
                    </div>
                        <input type="hidden" id="noneid" value="<?php echo $idhc?>">
                        <div class="divhisto" id="anexos">
                            <label class="cuno" id="labelauno" for="auno"><?php if($anexouno==''){echo "Documento o imagen de ayuda diagnóstica";}else{echo $anexouno;}?></label>
                            <input onchange="aunolabel(this.value)" type="file" name="txtauno" class="auno" id="auno" data-multiple-caption="{count} files selected">
                            <script>function aunolabel(valor){document.querySelector('.cuno').innerText = valor;document.querySelector('.cuno').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.cuno').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.cuno').style.color = '#777777';
                            }}</script>
                            <label class="cdos" id="labelados" for="ados"><?php if($anexodos==''){echo "Documento o imagen de ayuda diagnóstica";}else{echo $anexodos;}?></label>
                            <input onchange="adoslabel(this.value)" type="file" name="txtados" class="ados" id="ados" data-multiple-caption="{count} files selected">
                            <script>function adoslabel(valor){document.querySelector('.cdos').innerText = valor;document.querySelector('.cdos').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.cdos').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.cdos').style.color = '#777777';
                            }}</script>
                        </div>
                        <div class="divhisto" id="anexos">
                            <label class="ctres" id="labelatres" for="atres"><?php if($anexotres==''){echo "Documento o imagen de ayuda diagnóstica";}else{echo $anexotres;}?></label>
                            <input onchange="atreslabel(this.value)" type="file" name="txtatres" class="atres" id="atres" data-multiple-caption="{count} files selected">
                            <script>function atreslabel(valor){document.querySelector('.ctres').innerText = valor;document.querySelector('.ctres').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.ctres').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.ctres').style.color = '#777777';
                            }}</script>
                            <label class="ccuatro" id="labelacuatro" for="acuatro"><?php if($anexocuatro==''){echo "Documento o imagen de ayuda diagnóstica";}else{echo $anexocuatro;}?></label>
                            <input onchange="acuatrolabel(this.value)" type="file" name="txtacuatro" class="acuatro" id="acuatro" data-multiple-caption="{count} files selected">
                            <script>function acuatrolabel(valor){document.querySelector('.ccuatro').innerText = valor;document.querySelector('.ccuatro').style.color = 'black';
                            if(valor == ""){
                                document.querySelector('.ccuatro').innerText = 'Documento o imagen de ayuda diagnóstica';
                                document.querySelector('.ccuatro').style.color = '#777777';
                            }}</script>
                        </div>
                        <p id="filrelato"><textarea name="comentario" placeholder='Cuéntale al profesional el motivo de tu consulta' class="txthc" id="comentario" rows="3"><?php echo $comen;?></textarea></p>
                </div>
                </form>
<script>
document.getElementById("bbfiled1").addEventListener("click", mostrar_editinfper);

box3 = document.getElementById("boxanexos3");
box2 = document.getElementById("boxanexos2");

function mostrar_editinfper() {
    box2.style.display = "block";
    box3.style.display = "none";
}
</script>
                <?php
                }
                ?>
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
                            <p><span>Especialidad:</span><br><?php echo $especialidad?></p>
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
        <div class="ctn-hclinica">
			<div class="ctn-editarpc">
                <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5)?></h2>
            </div>
            <div class="box-body">
                <div class="boxhc" id="boxintrocita">
                    <h2>I. REGISTRO DE CITA</h2>
                    <div class="divhisto" id="introcita">
                        <p><span>Número de cita:</span><br><?php echo $nrocita?></p>
                        <p><span>Fecha y hora de cita:</span><br><?php echo $newFecha . " a las " . $horafinal[0] . ":00";?></p>
                    </div>
                </div>
                <hr>
                <?php
                $fecha = $fechastr - strtotime($nacimiento);
                $edad = floor($fecha / 31556926);

                $fecha2 = $fechastr - strtotime($nacimientopro);
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
                        <p><span>Tiempo de enfermedad:</span><br><?php echo $tiempoenf?></p>
                        <p><span>Forma de inicio:</span><br><?php echo $inicio?></p>
                    </div>
                    <div class="divhisto" id="anamnesis">
                        <p><span>Curso:</span><br><?php echo $curso?></p>
                        <p><span>Signos y síntomas principales:</span><br><?php echo $sintomas?></p>
                    </div>
                    <p id="filrelato"><span>Relato cronológico:</span><br><?php echo $relato?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxantecedentes">
                    <h2>IV. ANTECEDENTES</h2>
                    <div class="divhisto" id="antecedentes">
                        <p><span>Antecedentes heredo - familiares:</span><br><?php echo $anthf?></p>
                        <p><span>Antecedentes personales - patológicos:</span><br><?php echo $antpp?></p>
                    </div>
                    <div class="divhisto" id="antecedentes2">
                        <p><span>Medicamentos:</span><br><?php echo $medicamentos?></p>
                        <p><span>Alergias:</span><br><?php echo $alergias?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxexafisico">
                    <h2>V. EXAMEN FÍSICO</h2>
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
                            <p><span>IMC:</span><br><?php echo $imc?></p>
                        </div>
                    </div>
                    <p id="filef"><span>Evaluación física:</span><br><?php echo $evalfisica?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxexacomple">
                    <h2>VI. EXÁMENES COMPLEMENTARIOS</h2>
                    <p id="filpru"><span>Pruebas y resultados:</span><br><?php echo $prures?></p>
                </div>
                <hr>
                <div class="boxhc" id="boxdiagnostico">
                    <h2>VII. DIAGNÓSTICOS</h2>
                    <div class="divhisto" id="diagnostico">
                        <p><span>Diagnósticos presuntivos:</span><br><?php echo $diagpre?></p>
                        <p><span>Diagnósticos definitivos:</span><br><?php echo $diagdef?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxtratamiento">
                    <h2>VIII. PLAN DE TRABAJO</h2>
                    <p id="filtrata"><span>Tratamiento farmacológico:</span><br><?php echo $tratfarm?></p>
                    <div class="divhisto" id="tratamiento">
                        <p><span>Indicaciones de exámenes complementarios:</span><br><?php echo $indicec?></p>
                        <p><span>Indicaciones adicionales:</span><br><?php echo $indicesp?></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <h2>IX. ANEXOS DEL PROFESIONAL</h2>
                    <div class="divhisto" id="anexos">
                        <p><span>Imagen de receta médica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/complementarios/'.$archivoc;?>" download="<?php echo $_ENV['APP_URL'].'/complementarios/'.$archivoc;?>"><?php if($archivoc!=''){echo 'Descargar receta';};?></a></p>
                        <p><span>Documento o imagen de orientación:</span><br><a href="<?php echo $_ENV['APP_URL'].'/grabaciones/'.$grabacion;?>" download="<?php echo $_ENV['APP_URL'].'/grabaciones/'.$grabacion;?>"><?php if($grabacion!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <div class="ctn-editarp">
                        <h2>X. ANEXOS DEL PACIENTE</h2>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexouno;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexouno;?>"><?php if($anexouno!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexodos;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexodos;?>"><?php if($anexodos!=''){echo 'Descargar archivo';};?></a></p>
                    </div>
                    <div class="divhisto" id="anexos">
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexotres;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexotres;?>"><?php if($anexotres!=''){echo 'Descargar archivo';};?></a></p>
                        <p><span>Documento o imagen de ayuda diagnóstica:</span><br><a href="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexocuatro;?>" download="<?php echo $_ENV['APP_URL'].'/anexos/'.$anexocuatro;?>"><?php if($anexocuatro!=''){echo 'Descargar archivo';};?></a></p>
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
        <?php
            }
        ?>
    </div>
    </main>
</body>
<?php echo footermed();?>
</html>