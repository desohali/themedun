<?php

include 'conexion_paciente.php';
include '../configuracion.php';

class Valoraciones
{
  public $conexion;
  public $currentDate;

  function __construct($conexion)
  {
    $this->conexion = $conexion;
    $this->currentDate = new DateTime();
    $this->currentDate->setTimezone(new DateTimeZone('America/Lima'));
  }

  public function registrarValoracion()
  {

    list(
      'idu' => $idu,
      'idupro' => $idupro,
      'valoracion' => $valoracion,
      'comentarios' => $comentarios,
    ) = @$_POST;

    if ($idu != "0") {
      // VERIFICAMOS SI EL PACIENTE YA DIO UNA VALORACION
      $select = "SELECT * FROM valoraciones WHERE idu=" . $idu . " AND valoracion <> 0 AND idupro=" . $idupro;
      $resultSelect = mysqli_query($this->conexion, $select) or die(mysqli_error($this->conexion));

      if ($resultSelect->num_rows > 0 && empty($comentarios)) { // ACTUALIZAMOS LA VALORACION

        $query = "UPDATE valoraciones SET leido='NO', valoracion=$valoracion, fechanoti=NOW() WHERE idu=" . $idu . " AND valoracion <> 0 AND idupro=" . $idupro;

        $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));
      } else { // REGISTRAMOS SU VALORACION

        $query = "INSERT INTO valoraciones (idu, idupro, valoracion, comentarios, fechaRegistro, fechanoti) VALUES ";
        $query .= "($idu, $idupro, $valoracion, JSON_INSERT('[]', '$[0]', '$comentarios'), NOW(), NOW())";

        $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));
      }
    } else {

      $query = "INSERT INTO valoraciones (idu, idupro, valoracion, comentarios, fechaRegistro, fechanoti) VALUES ";
      $query .= "($idu, $idupro, $valoracion, JSON_INSERT('[]', '$[0]', '$comentarios'), NOW(), NOW())";
      /* return $query; */
      $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));
    }


    return "se registro";
  }

  public function eliminarComentario()
  {
    list(
      /* 'idu' => $idu, */
      'id' => $id,
    ) = @$_POST;

    $query = "DELETE FROM valoraciones WHERE id=" . $id;
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    return "se eliminó";
  }

  public function eliminarRespuesta()
  {
    list(
      /* 'idu' => $idu, */
      'id' => $id,
      'indice' => $indice,
    ) = @$_POST;

    $query = "UPDATE valoraciones SET comentarios=JSON_REMOVE(comentarios, '$[$indice]') WHERE id=" . $id;
    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    return "se eliminó";
  }

  public function responseComentario()
  {
    list(
      'idComentario' => $idComentario,
      'comentario' => $comentario
    ) = @$_POST;

    $queryIndice = "SELECT (SELECT JSON_LENGTH(comentarios)) as count FROM valoraciones  WHERE id=" . $idComentario;
    $resultIndice = mysqli_query($this->conexion, $queryIndice) or die(mysqli_error($this->conexion));

    while ($obj = $resultIndice->fetch_object()) {
      $indice = $obj;
    }

    $query = "UPDATE valoraciones SET leido='NO', ";
    $query .= "comentarios=JSON_ARRAY_INSERT(comentarios, '$[$indice->count]', '$comentario')  WHERE id=" . $idComentario;

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    return json_decode(json_encode($comentario));
  }

  public function listarValoraciones()
  {

    list(
      /* 'idu' => $idu, */
      'idupro' => $idupro,
    ) = @$_POST;

    $query = "SELECT * FROM valoraciones WHERE idupro=" . $idupro;
    /* $query .= " AND (SELECT STR_TO_DATE(fechanoti, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY))"; */

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];
    while ($obj = $result->fetch_object()) {
      array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }
  
  public function listarValor()
  {

    list(
      'idu' => $idu,
      'idupro' => $idupro,
    ) = @$_POST;

    $query = "SELECT * FROM valoraciones WHERE idupro=" . $idupro . " AND idu=" . $idu;
    /* $query .= " AND (SELECT STR_TO_DATE(fechanoti, '%Y-%m-%d %T') > date_add(NOW(), INTERVAL -30 DAY))"; */

    $result = mysqli_query($this->conexion, $query) or die(mysqli_error($this->conexion));

    $arrayJson = [];
    while ($obj = $result->fetch_object()) {
      array_push($arrayJson, $obj);
    }

    return $arrayJson;
  }
}

// listen methods
$method = @$_POST['method'];
if ($method) {
  $valoraciones = new Valoraciones($conexion);
  echo json_encode($valoraciones->{$method}());
}

/* $valoraciones = new Valoraciones($conexion);
  echo json_encode($valoraciones->responseComentario()); */
