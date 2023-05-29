<?php
include 'conexion_paciente.php';
$idhc = $_POST["idhc"];
$tiempoenf = $inicio = $curso = $sintomas = $relato = $anthf = $antpp = $medicamentos = $alergias = $freccar = $frecres = $sato = $presion = $temperatura = $peso = $talla = $imc = $evalfisica = $prures = $diagpre = $diagdef = $tratfarm = $indicec = $indicesp = $archivoc = $grabacion = "";
$tiempoenf = nl2br(ucfirst(trim($_POST["tiempoenf"])));
$inicio = ucfirst(trim($_POST["inicio"]));
$curso = ucfirst(trim($_POST["curso"]));
$sintomas = nl2br(ucfirst(trim($_POST["sintomas"])));
$relato = nl2br(ucfirst(trim($_POST["relato"])));
$anthf = nl2br(ucfirst(trim($_POST["anthf"])));
$antpp = nl2br(ucfirst(trim($_POST["antpp"])));
$medicamentos = nl2br(ucfirst(trim($_POST["medicamentos"])));
$alergias = nl2br(ucfirst(trim($_POST["alergias"])));
$freccar = trim($_POST["freccar"]);
$frecres = trim($_POST["frecres"]);
$sato = trim($_POST["sato"]);
$presion = ucfirst(trim($_POST["presion"]));
$temperatura = trim($_POST["temperatura"]);
$peso = trim($_POST["peso"]);
$talla = trim($_POST["talla"]);
$imc = trim($_POST["imc"]);
$evalfisica = nl2br(ucfirst(trim($_POST["evalfisica"])));
$prures = nl2br(ucfirst(trim($_POST["prures"])));
$diagpre = nl2br(ucfirst(trim($_POST["diagpre"])));
$diagdef = nl2br(ucfirst(trim($_POST["diagdef"])));
$tratfarm = nl2br(ucfirst(trim($_POST["tratfarm"])));
$indicec = nl2br(ucfirst(trim($_POST["indicec"])));
$indicesp = nl2br(ucfirst(trim($_POST["indicesp"])));
$nombrefoto1 = $_FILES['txtarc']['name'];
$ruta1 = $_FILES['txtarc']['tmp_name'];
if($nombrefoto1!='' && $ruta1!=''){
    $archivoc=$idhc.''.$nombrefoto1;
    $destino1 = "../complementarios/".$archivoc;
}
$nombrefoto2 = $_FILES['txtgrabacion']['name'];
$ruta2 = $_FILES['txtgrabacion']['tmp_name'];
if($nombrefoto2!='' && $ruta2!=''){
    $grabacion=$idhc.''.$nombrefoto2;
    $destino2 = "../grabaciones/".$grabacion;
}
$sql = "UPDATE hclinica SET tiempoenf = '$tiempoenf', inicio = '$inicio', curso = '$curso', sintomas = '$sintomas', relato = '$relato', anthf = '$anthf', antpp = '$antpp', medicamentos = '$medicamentos', alergias = '$alergias', freccar = '$freccar', frecres = '$frecres', sato = '$sato', presion = '$presion', temperatura = '$temperatura', peso = '$peso', talla = '$talla', imc = '$imc', evalfisica = '$evalfisica', prures = '$prures', diagpre = '$diagpre', diagdef = '$diagdef', tratfarm = '$tratfarm', indicec = '$indicec', indicesp = '$indicesp', archivoc = '$archivoc', grabacion = '$grabacion' WHERE idhc = '".$idhc."' ";
$stmt = mysqli_query($conexion, $sql);
if(is_uploaded_file($ruta1)){
    copy($ruta1, $destino1);
}
if(is_uploaded_file($ruta2)){
    copy($ruta2, $destino2);
}
?> 
