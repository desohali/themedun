<?php
  include 'conexion_paciente.php';
  include_once 'Zoom_Api.php';

  $idpro = $_POST['idpro'];
  $ocultfehonew = $_POST['ocultfeho'];

  $zoom_meeting = new Zoom_Api();
  
  $data = array();
  $data['topic'] 		= 'Cita The Med Universe';
  $data['start_time'] = date($ocultfehonew.":00:00");
  $data['duration'] 	= 40;
  $data['type'] 		= 2;
  $data['password'] 	= "12345";
  
  try {
      $response = $zoom_meeting->createMeeting($data);
  } catch (Exception $ex) {
      echo $ex;
  };

  $query = "UPDATE citas SET title = 'Programada... Únete con el link en la fecha y hora correspondientes.', color = '#0052d4',";
  $query .= " ubicacion = '".$response->join_url."', fechanoti=now() WHERE idupro = '".$idpro."' AND start = '".$ocultfehonew."'";
  $result = mysqli_query($conexion, $query);

  echo json_encode(array(
    "title" => "Programada... Únete con el link en la fecha y hora correspondientes.",
    "url" => $response->join_url,
  ));
     
  ?>