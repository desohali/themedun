<?php

include 'conexion_paciente.php';
include '../configuracion.php';

class Notificaciones
{
  public $conexion;
  public $currentDate;

  function __construct($conexion)
  {
    $this->conexion = $conexion;
    $this->currentDate = new DateTime();
    $this->currentDate->setTimezone(new DateTimeZone('America/Lima'));
  }

  public function tiempoTranscurrido($fechaNotificacion): string
  {

    $fechaNotificacionMilisegundos = (strtotime($fechaNotificacion) * 1000);
    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    $segundos =  (($fechaActualMilisegundos - $fechaNotificacionMilisegundos) / 1000);
    $minutos = (int)($segundos / 60);
    $horas = (int)($minutos / 60);
    $dias = (int)($horas / 24);

    $myDate = [
      'días' => $dias,
      'horas' => $horas,
      'minutos' => $minutos,
      'segundos' => $segundos
    ];

    $msg = new stdClass();
    foreach ($myDate as $clave => $valor) {
      if ($valor > 0) {
        $msg->nombre = $clave;
        $msg->cantidad = $valor;
        break;
      }
    }
    
    if($msg->cantidad=='1' && $msg->nombre=='segundos'){
        $msg->nombre='segundo';
    }else if($msg->cantidad=='1' && $msg->nombre=='minutos'){
        $msg->nombre='minuto';
    }else if($msg->cantidad=='1' && $msg->nombre=='horas'){
        $msg->nombre='hora';
    }else if($msg->cantidad=='1' && $msg->nombre=='días'){
        $msg->nombre='día';
    }

    return "Hace " . @$msg->cantidad . " " . @$msg->nombre;
  }

  public function listarNotificacionesPaciente()
  {

    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexopro,";
    $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
    $query .= "(select especialidad from usuariospro where idpro=idupro) as profesion,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente, ";
    $query .= "(select estado from usuarios where id=idu) as estadoPaciente ";
    $query .= "FROM citas WHERE id=" . @$_POST['id'] . " AND (SELECT STR_TO_DATE(start, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY)) AND estado <> 'CANCELADA' ORDER BY idcita";

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];

    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    while ($obj = $result->fetch_object()) {
      $sexo = $obj->sexopro == "Masculino" ? "Dr. " : "Dra. ";
      list($fecha, $hora) = explode(" ", $obj->start);
      $horafinal = explode(":00", $hora);
      
      if ($obj->sexopro == "Femenino") {
           $profesion = "Profesional";
           $profedos = "el profesional";
      }else{
          $profesion = "Profesional";
          $profedos = "el profesional";
      }
      if ($obj->profesion == "Psicología") {
          if ($obj->sexopro == "Femenino") {
              $profesion = "Profesional";
              $profedos = "el profesional";
          }else{
              $profesion = "Profesional";
              $profedos = "el profesional";
          }
      }
      $timestamp = strtotime($fecha);
      $newFecha = date("d/m/Y", $timestamp);

      if ($obj->estadoPaciente == "1") {

        if ($obj->estado == "RECHAZADA" && $obj->title != $_ENV['CITA_VENCIDA']) {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>RECHAZADA</span> por " . $profedos;
          $obj->notificacion .= ". Selecciona otra fecha disponible.";
        } else if ($obj->estado == "ELIMINADA" && $obj->title != $_ENV['CITA_VENCIDA']) {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>CANCELADA</span>. Otro paciente realizó el pago antes";
          $obj->notificacion .= ", selecciona otra fecha disponible.";
        } else if ($obj->title == $_ENV['CITA_ENVIADA'] && $obj->estado != "RECHAZADA") {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#FFC107'>ENVIADA</span>. Espera a que " . $profedos . " realice la confirmación.";
        } else if ($obj->title == $_ENV['CITA_CONFIRMADA'] && $obj->estado != "RECHAZADA") {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#00d418'>CONFIRMADA</span>. Realiza el pago lo antes posible.";
        } else if ($obj->title == $_ENV['CITA_PROGRAMADA'] && $obj->estado != "RECHAZADA") {
          /* Tu cita con el $medico ha sido programada. Únete con este link $link el $fecha a las $hora. */
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Cita <span style='color:#0052d4'>PROGRAMADA</span>. Únete con el link en la fecha y hora correspondientes.";/*  . $obj->ubicacion; */
        } else if ($obj->title == $_ENV['CITA_VENCIDA']) {
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>" . $profesion.": </span>" . $sexo . $obj->nombresMedico . " " . $obj->apellidosMedico;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>VENCIDA</span>. Selecciona otra fecha disponible.";
        } else {
          $obj->notificacion = "";
        }

        $obj->tiempo = $obj->fechanoti ? $this->tiempoTranscurrido($obj->fechanoti) : '';

        $fechaNotificacionMilisegundos = (strtotime($obj->fechanoti) * 1000);
        $obj->tiempoSegundos = $obj->fechanoti ? (($fechaActualMilisegundos - $fechaNotificacionMilisegundos) / 1000) : 0;

        array_push($arrayJson, $obj);
      }
    }

    return $arrayJson;
  }

  public function listarNotificationesDeAbonosAlMedico()
  {

    $idupro = @$_POST['idupro'];
    // NOTIFICACIONES DE PAGOS ABONOS Y DESCUENTOS AL MEDICO
    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexopro,";
    $query .= "(select estado from usuariospro where idpro=idupro) as estadopro,";
    $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
    $query .= "FROM citas WHERE idupro=$idupro AND idpay<>0 AND abonado<>'NO' AND ";
    $query .= "(SELECT STR_TO_DATE(start, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY)) ORDER BY idcita";

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];
    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    $enumEstadoAbonado = array(
      'NO' => 'ESTE ES EL VALOR POR DEFECTO, QUE CORRESPONSE A QUE NO SE A PAGADO AL MEDICO',
      'SI' => 'NOTIFICACION SE LE A APAGADO AL MEDICO',
      'F' => 'SE DESCONTARA LA COMISON DEL 15% EN LA PROXIMA CITA',
      'P' => 'SE APLICO EL DESCUENTO DEL 15%',
    );
    $enumKeys = array_keys($enumEstadoAbonado);

    while ($obj = $result->fetch_object()) {
      /* $sexo = $obj->sexopro == "Masculino" ? "Dr. " : "Dra. "; */
      list($fecha, $hora) = explode(" ", $obj->start);
      $horafinal = explode(":00", $hora);

      $timestamp = strtotime($fecha);
      $newFecha = date("d/m/Y", $timestamp);
      $obj->notidicacionDeAbono = true;

      if ($obj->abonado == $enumKeys[1]) {
        $obj->notificacion = "<span class='spanbolder'>Cita <span style='color:#00d418'>(Asistió)</span>: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
        $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
        $obj->notificacion .= "<br>Su ganancia por esta cita ha sido <span style='color:#00d418'>ABONADA</span>.";
      } else if ($obj->abonado == $enumKeys[2]) {
        $obj->notificacion = "<span class='spanbolder'>Cita <span style='color:#ff0800'>(No Asistió)</span>: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
        $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
        $obj->notificacion .= "<br>Se ha generado una deuda por <span style='color:#ff0000'>INASISTENCIA</span> a esta cita. En el “Historial de Pagos” encontrará los métodos de pago para saldar su deuda.";
      } else if ($obj->abonado == $enumKeys[3]) {
        $obj->notificacion = "<span class='spanbolder'>Cita <span style='color:#ff0800'>(No Asistió)</span>: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
        $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
        $obj->notificacion .= "<br>Su deuda por inasistencia ha sido <span style='color:#00d418'>PAGADA</span>.";
      } else {
        $obj->notificacion = "";
      }

      $obj->tiempo = $obj->fechaabono ? $this->tiempoTranscurrido($obj->fechaabono) : '';

      $fechaNotificacionMilisegundos = (strtotime($obj->fechaabono) * 1000);
      $obj->tiempoSegundos = $obj->fechaabono ? (($fechaActualMilisegundos - $fechaNotificacionMilisegundos) / 1000) : 0;

      array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }

  public function listarNotificacionesMedico()
  {
    $idupro = @$_POST['idupro'];

    // NOTIFICACIONES DE CITAS EN SUS DIFERENTES ESTADOS
    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexopro,";
    $query .= "(select estado from usuariospro where idpro=idupro) as estadopro,";
    $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
    $query .= "FROM citas WHERE idupro=" . $idupro . " AND (SELECT STR_TO_DATE(start, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY)) AND estado <> 'RECHAZADA' ORDER BY idcita";

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];

    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    while ($obj = $result->fetch_object()) {
      /* $sexo = $obj->sexopro == "Masculino" ? "Dr. " : "Dra. "; */
      list($fecha, $hora) = explode(" ", $obj->start);
      $horafinal = explode(":00", $hora);

      $timestamp = strtotime($fecha);
      $newFecha = date("d/m/Y", $timestamp);


        $obj->notificacion = "";
        if ($obj->estado == "CANCELADA") {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" .  $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>CANCELADA</span> por el paciente.";
        } else if ($obj->estado == "ELIMINADA") {

          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" .  $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>CANCELADA</span>";
          $obj->notificacion .= ". Otro paciente realizó el pago antes.";
        } else if ($obj->title == $_ENV['CITA_ENVIADA'] && $obj->estado != "CANCELADA") {
          /* Has RECIBIDO una solicitud de cita. Realiza su confirmación. */
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#FFC107'>RECIBIDA</span>. Realice su confirmación lo antes posible.";
        } else if ($obj->title == $_ENV['CITA_CONFIRMADA'] && $obj->estado != "CANCELADA") {
          /* Has CONFIRMADO una solicitud de cita. Espere a que el paciente realice el pago. */
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#00d418'>CONFIRMADA</span>. Espere a que el paciente realice el pago.";
        } else if ($obj->title == $_ENV['CITA_PROGRAMADA'] && $obj->estado != "CANCELADA") {
          /* Tu cita con el $medico ha sido programada. Únete con este link $link el $fecha a las $hora. */
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Cita <span style='color:#0052d4'>PROGRAMADA</span>. Únete con el link en la fecha y hora correspondientes.";/*  . $obj->ubicacion; */
        } else if ($obj->title == $_ENV['CITA_VENCIDA']) {
          $obj->notificacion = "<span class='spanbolder'>Cita: </span>" . $newFecha . " a las " . $horafinal[0] . ":00";
          $obj->notificacion .= "<br><span>Paciente: </span>" . $obj->nombresPaciente . " " . $obj->apellidosPaciente;
          $obj->notificacion .= "<br>Solicitud de cita <span style='color:#ff0800'>VENCIDA</span>.";
        }

        $obj->tiempo = $obj->fechanoti ? $this->tiempoTranscurrido($obj->fechanoti) : '';

        $fechaNotificacionMilisegundos = (strtotime($obj->fechanoti) * 1000);
        $obj->tiempoSegundos = $obj->fechanoti ? (($fechaActualMilisegundos - $fechaNotificacionMilisegundos) / 1000) : 0;

        array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }

  public function listarNotificacionesValoracionMedico()
  {
    $query = "SELECT *, id as idu,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente, ";
    $query .= "(select estado from usuariospro where idpro=" . @$_POST['idupro'] . ") as estadopro";
    $query .= " FROM valoraciones WHERE idupro=" . @$_POST['idupro'] . " AND valoracion <> 0";
    $query .= " AND (SELECT STR_TO_DATE(fechanoti, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY))";
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];

    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    while ($obj = $result->fetch_object()) {
        $obj->notificacion = "<span class='spanbolder'>Nueva Valoración:</span> " . $obj->valoracion;
        $obj->notificacion .= " estrellas<br><span class='spanbolder'>Paciente:</span> ";
        $obj->notificacion .= $obj->nombresPaciente . " ";
        $obj->notificacion .= $obj->apellidosPaciente . "";

        $obj->tiempo = $obj->fechanoti ? $this->tiempoTranscurrido($obj->fechanoti) : '';

        array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }

  public function listarNotificacionesComentariosMedico()
  {
    $query = "SELECT *, (select estado from usuariospro where idpro=" . @$_POST['idupro'] . ") as estadopro FROM valoraciones ";
    $query .= "WHERE idupro=" . @$_POST['idupro'] . " and valoracion=0"; //  AND comentarios REGEXP '(leido)\\\S{1,}(NO)'

// AND (SELECT STR_TO_DATE(fechanoti, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY))

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];

    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);
    /* $PACIENTE  .  "te ha dejado un nuevo comentario" */

    while ($obj = $result->fetch_object()) {
        /* $obj->notificacion = "<span class='spanbolder'>Nueva Valoración:</span> " . $obj->valoracion;
        $obj->notificacion .= " estrellas.<br><span class='spanbolder'>Paciente:</span> ";
        $obj->notificacion .= $obj->nombresPaciente . " ";
        $obj->notificacion .= $obj->apellidosPaciente . "."; */
        /* $obj->notificacion .= $obj->apellidosPaciente . "."; */

        $obj->tiempo = $obj->fechanoti ? $this->tiempoTranscurrido($obj->fechanoti) : '';

        $fechaNotificacionMilisegundos = (strtotime($obj->fechanoti) * 1000);
        $obj->tiempoSegundos = $obj->fechanoti ? (($fechaActualMilisegundos - $fechaNotificacionMilisegundos) / 1000) : 0;

        array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }

  /* public function listarNotificacionesComentariosMedico()
  {
    $query = "SELECT *, id as idu,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
    $query .= " FROM valoraciones WHERE idupro=" . @$_POST['idupro'] . " AND valoracion <> 0";
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];

    $fechaActualMilisegundos = (strtotime($this->currentDate->format('Y-m-d H:i:s')) * 1000);

    while ($obj = $result->fetch_object()) {
      $obj->notificacion = "<span class='spanbolder'>Nueva Valoración:</span> " . $obj->valoracion;
      $obj->notificacion .= " estrellas.<br><span class='spanbolder'>Paciente:</span> ";
      $obj->notificacion .= $obj->nombresPaciente . " ";
      $obj->notificacion .= $obj->apellidosPaciente . ".";

      $obj->tiempo = $obj->fechanoti ? $this->tiempoTranscurrido($obj->fechanoti) : '';

      array_push($arrayJson, $obj);
    }

    return $arrayJson;
  } */

  public function verificarCitasVencidas()
  {

    $query = "UPDATE citas SET color='#ff0000', leido='NO', leidopro='NO', title='Vencida... La fecha de tu cita ha expirado.' ";
    $query .= "WHERE (SELECT STR_TO_DATE(start, '%Y-%m-%d %T') < NOW()) AND estado <> '" . $_ENV['CITA_PROGRAMADA'] . "'";

    /* return $query;  */
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    return "ok";

    /* $arrayJson = [];
    while ($obj = $result->fetch_object()) {
      array_push($arrayJson, $obj);
    }

    return $arrayJson; */
  }

  public function verificarCitaProgramada()
  {

    list(
      'idupro' => $idupro,
      'fecha' => $fecha,
    ) = @$_POST;

    $query = "SELECT * FROM citas WHERE 
    idupro=$idupro AND 
    title='Programada... Únete con el link en la fecha y hora correspondientes.' AND 
    start='$fecha' AND 
    estado='ACTIVO'";

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    // VERIFICAR SI LA CITA CONFIRMADA ACABA DE VENCER

    $confirm = $_ENV['CITA_CONFIRMADA'];

    $query2 = "SELECT * FROM citas WHERE 
    idupro=$idupro AND 
    title='$confirm' AND 
    (SELECT STR_TO_DATE(start, '%Y-%m-%d %T') < NOW()) AND 
    /* start='$fecha' AND  */
    estado='ACTIVO'";
    $result2 = mysqli_query($this->conexion, $query2) or die(mysqli_error($this->conexion));

    // VERIFICAR SI LA CITA YA HA CAMBIADO A VENCIDA EN LA BD

    $titleVencida = $_ENV['CITA_VENCIDA'];

    $query3 = "SELECT * FROM citas WHERE 
    idupro=$idupro AND 
    title='$titleVencida' AND 
    start='$fecha' AND 
    estado='ACTIVO'";
    $result3 = mysqli_query($this->conexion, $query3) or die(mysqli_error($this->conexion));

    // ESTE METODO ANTES DEL 16:07 7/10/2022 DEBOLVIA UN NUMERO ENUM 0 OR 1
    return [
      "mensajePacienteRealizoElPagoAntes" => $result->num_rows,
      "mensajeCitaAcabaDeVencer" => $result2->num_rows,
      "mensajeCitaVencida" => $result3->num_rows,
    ];
  }

  public function actualizarNotificacionesLeidasNoLeidas()
  {

    list(
      'id' => $id,
      'estadoLeido' => $estadoLeido
    ) = @$_POST;

    $query = "UPDATE citas SET leido='" . $estadoLeido . "' ";
    $query .= "WHERE id=" . $id;

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));


    return "se actualizó";
  }

  public function actualizarNotificacionesLeidasNoLeidasPro()
  {

    list(
      'idupro' => $idupro,
      'estadoLeido' => $estadoLeido
    ) = @$_POST;

    $query = "UPDATE citas SET leidopro='" . $estadoLeido . "' ";
    $query .= "WHERE idupro=" . $idupro;

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    // TAMBIEN ACTUALIZAMOS LAS VALORACIONES LEIDAS
    $queryValoraciones = "UPDATE valoraciones SET leido='" . $estadoLeido . "' ";
    $queryValoraciones .= "WHERE idupro=" . $idupro;
    $result = mysqli_query($this->conexion, $queryValoraciones) or die(mysqli_error($this->conexion));

    // ACTUALIZAMOS LOS ABONOS(PAGOS) LEIDOS DEL MEDICO
    $updateAbonos = "UPDATE citas SET leidoabono='" . $estadoLeido . "' ";
    $updateAbonos .= "WHERE idupro=" . $idupro;
    $result = mysqli_query($this->conexion, $updateAbonos) or die(mysqli_error($this->conexion));
    // ACTUALIZAMOS LOS COMENTARIOS LEIDOS, EN EL HOSTING FUNCIONA CON CORCHETES DE APERTURA Y CIERRE, EN LOCALHOST CON:(leido)\\\S{1,}(NO)
    $query = "SELECT * FROM valoraciones WHERE idupro=" . $idupro . " AND comentarios REGEXP '[(leido)\\\S{1,}:\\\S{1,}NO]'";
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $comentariosAActualizar = [];

    $arrayJson = [];
    while ($obj = $result->fetch_object()) {

      $obj->comentarios = json_decode($obj->comentarios, false, 512, JSON_UNESCAPED_UNICODE);

      for ($i = 0; $i < count($obj->comentarios); $i++) {
        $comentario = json_encode(preg_replace('/(leido)\S{1,}(NO)/', "leido\":\"SI", $obj->comentarios[$i]), JSON_UNESCAPED_UNICODE);
        if ($i == 0) {
          array_push($comentariosAActualizar, "UPDATE valoraciones set comentarios=JSON_INSERT('[]', '$[0]', $comentario ) WHERE id=" . $obj->id);
        } else {
          array_push($comentariosAActualizar, "UPDATE valoraciones set comentarios=JSON_ARRAY_INSERT(comentarios, '$[$i]', $comentario ) WHERE id=" . $obj->id);
        }
      }
    }

    for ($i = 0; $i < count($comentariosAActualizar); $i++) {
      $result = mysqli_query($this->conexion, $comentariosAActualizar[$i]);
    }

    return "se actualizó";
  }

  public function verificarCitasProgramadas10MinutosAntes()
  {

    $id = isset($_POST['id']) ? $_POST['id'] : $_POST['idpro'];

    $query = "SELECT start FROM citas ";
    $query .= isset($_POST['id']) ? "WHERE id=$id " : "WHERE idupro=$id ";
    $query .= "and estado='ACTIVO' ";
    $query .= "and title='Programada... Únete con el link en la fecha y hora correspondientes.' ";
    $query .= "and now() BETWEEN (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -11 MINUTE)) ";
    $query .= "AND (date_add(STR_TO_DATE(start, '%Y-%m-%d %T'), INTERVAL -9 MINUTE))";

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    return $result->num_rows;
  }
}

// listen methods
$method = @$_POST['method'];
if ($method) {
  $notificaciones = new Notificaciones($conexion);
  echo json_encode($notificaciones->{$method}());
} 

/* $notificaciones = new Notificaciones($conexion);
  //  echo json_encode($notificaciones->verificarCitasVencidas()); 

 echo json_encode($notificaciones->verificarCitaProgramada()); */
