<?php
include 'conexion_paciente.php';
$idhc = $_POST["idhc"];
$anexouno = $anexodos = $anexotres = $anexocuatro = $comentario = "";

$comentario = nl2br(ucfirst(trim($_POST["comentario"])));

$nombrefoto1 = $_FILES['txtauno']['name'];
$ruta1 = $_FILES['txtauno']['tmp_name'];
if($nombrefoto1!='' && $ruta1!=''){
    $anexouno = $idhc.'A1'.$nombrefoto1;
    $destino1 = "../anexos/".$anexouno;
}
$nombrefoto2 = $_FILES['txtados']['name'];
$ruta2 = $_FILES['txtados']['tmp_name'];
if($nombrefoto2!='' && $ruta2!=''){
    $anexodos = $idhc.'A2'.$nombrefoto2;
    $destino2 = "../anexos/".$anexodos;
}
$nombrefoto3 = $_FILES['txtatres']['name'];
$ruta3 = $_FILES['txtatres']['tmp_name'];
if($nombrefoto3!='' && $ruta3!=''){
    $anexotres = $idhc.'A3'.$nombrefoto3;
    $destino3 = "../anexos/".$anexotres;
}
$nombrefoto4 = $_FILES['txtacuatro']['name'];
$ruta4 = $_FILES['txtacuatro']['tmp_name'];
if($nombrefoto4!='' && $ruta4!=''){
    $anexocuatro = $idhc.'A4'.$nombrefoto4;
    $destino4 = "../anexos/".$anexocuatro;
}
$sql = "UPDATE hclinica SET anexouno = '$anexouno', anexodos = '$anexodos', anexotres = '$anexotres', anexocuatro = '$anexocuatro', comentario = '$comentario' WHERE idhc = '".$idhc."' ";
$stmt = mysqli_query($conexion, $sql);
if(is_uploaded_file($ruta1)){
    copy($ruta1, $destino1);
}
if(is_uploaded_file($ruta2)){
    copy($ruta2, $destino2);
}
if(is_uploaded_file($ruta3)){
    copy($ruta3, $destino3);
}
if(is_uploaded_file($ruta4)){
    copy($ruta4, $destino4);
}
?> 
