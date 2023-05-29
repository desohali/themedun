<?php
include 'conexion_paciente.php';

switch ($_POST['accion']) {
  case 'registrarHorarios':
    $idupro = $_POST["idupro"];
    $ndia = $_POST['ndia'];
    $nhora = $_POST['nhora'];
    $elininaroAniadir = $_POST['elininaroAniadir'];

    if ($elininaroAniadir == "ELIMINAR") {
      $query = "DELETE FROM horarios WHERE idupro = '".$idupro."' AND ndia = '".$ndia."' AND nhora = '".$nhora."'";
      $result = mysqli_query($conexion, $query);
    }

    if ($elininaroAniadir == "AÑADIR") {
      $query = "INSERT INTO horarios (nhora, ndia, idupro) VALUES ";
      $query .= "('".$nhora."', '".$ndia."', '".$idupro."')";
      $result = mysqli_query($conexion, $query);
    }
    
    echo "Se registro con exito";

    break;
  case 'listarDisponibilidad':
      $idupro = $_POST["idupro"];
      $CantidadMostrar=1000;
      /* // Validado  la variable GET
      $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
      $TotalReg       =mysqli_query($conexion, "SELECT * FROM horarios");
      $totalr = mysqli_num_rows($TotalReg);
      //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
      $TotalRegistro  =ceil($totalr/$CantidadMostrar);
      //Operacion matematica para mostrar los siquientes datos.
      $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0; */
      //Consulta SQL
      $query = "SELECT * FROM horarios WHERE idupro = '".$idupro."' ORDER BY nhora ASC LIMIT $CantidadMostrar";//.(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
      $result = mysqli_query($conexion, $query);
      $json = [];
      while ($row=mysqli_fetch_assoc($result)) {
        array_push($json, $row);
      }

      echo json_encode($json);

      break;
  default:
    # code...
    echo "Error al registrar";
    break;
}


?> 