<?php
    header('Content-Type: application/json');
    // $pdo=new PDO("mysql:dbname=themedun_paciente;host=localhost","root",'tiburon2$ABC');
    $pdo=new PDO("mysql:dbname=themedun_paciente;host=144.22.51.20","themedun",'tiburon2$ABC');
    //SELECCIONAR LOS EVENTOS DEL CALENDARIO
    /* $sentenciaSQL=$pdo->prepare("SELECT * FROM citas WHERE id = '".$_GET['id']."' "); */

    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexoMedico,";
    $query .= "(select especialidad from usuariospro where idpro=idupro) as especialidad,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
    $query .= "FROM citas WHERE id='".$_GET['id']."' AND estado='ACTIVO'";

    $sentenciaSQL=$pdo->prepare($query);

    $sentenciaSQL->execute();
    $resultado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    

    echo json_encode($resultado);
?>