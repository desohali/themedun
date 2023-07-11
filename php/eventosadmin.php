<?php
    header('Content-Type: application/json');
    // $pdo=new PDO("mysql:dbname=themedun_paciente;host=localhost","root",'tiburon2$ABC');
    $pdo=new PDO("mysql:dbname=themedun_paciente;host=144.22.51.20","themedun",'tiburon2$ABC');
    //SELECCIONAR LOS EVENTOS DEL CALENDARIO
    /* $sentenciaSQL=$pdo->prepare("SELECT * FROM citas WHERE idupro = '".$_GET['idpro']."'"); */

    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexoMedico,";
    $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
    $query .= "FROM citas WHERE estado='ACTIVO' and title = 'Programada... Únete con el link en la fecha y hora correspondientes.' OR estado='ACTIVO' and title = 'Confirmada... Realiza el pago de tu cita lo antes posible.'";

    $sentenciaSQL=$pdo->prepare($query);

    $sentenciaSQL->execute();
    $resultado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>