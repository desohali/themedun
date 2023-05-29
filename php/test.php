<?php
  include 'conexion_paciente.php';
  require '../vendor/autoload.php';
  include '../configuracion.php';

  $idcita = $_POST['idcita'];
  $url = $_POST['url'];

  $query = "SELECT *, id as idu,";
  $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
  $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
  $query .= "(select sexopro from usuariospro where idpro=idupro) as sexoMedico,";
  $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
  $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
  $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente ";
  $query .= "FROM citas WHERE idcita='".$idcita."'";

  $result = mysqli_query($conexion, $query);

  while ($row = $result->fetch_object()){
    $cita = $row;
  }

  if($cita->sexoMedico == 'Femenino'){
    $doctor = "Dra.";
  }else{
    $doctor = "Dr.";
  }
  
  MercadoPago\SDK::setAccessToken('TEST-4332121290660940-011922-f2b23786f590ccbe0175beea8f3e766c-1291343904');
  $preference = new MercadoPago\Preference();

  $productos_mp = array();
  $idpro = $cita->idupro;
  $item = new MercadoPago\Item();
  /* $item -> id = $idpro;
  $item -> title = 'Dr. '.$nombrespro.' '.$apellidospro;
  $item -> picture_url = "./fotoperfilpro/$fotoperfilpro";
  $item -> description = "$profesion.', '.$especialidad";
  $item -> quantity = 1;
  $item -> unit_price = $precio; */
  $item -> id = $cita->idcita;
  $item->title = $doctor . " " . $cita->nombresMedico . " " .  $cita->apellidosMedico;
  /* $item -> picture_url = "http://www.savar.com.pe/websavar/new/assets/images/locales/Argentina.JPG"; */
  $item -> description = $cita->especialidad;
  $item->quantity = 1;
  $item->unit_price = $cita->localizacion;
  $item -> currency_id = 'PEN';

  array_push($productos_mp, $item);
  unset($item);

  $preference->payment_methods = array(
    "excluded_payment_types" => array(
      array("id" => "ticket"),
      array("id" => "bank_transfer"),
      array("id" => "atm"),
    ),
  );

  $preference -> items = $productos_mp;
	$preference -> back_urls = array(
		"success" => $_ENV['APP_URL']."enlacecita.php?id=$idpro&url=$url",
		"failure" => $_ENV['APP_URL']."enlacecita.php?id=$idpro&url=$url",
		"pending" => $_ENV['APP_URL']."enlacecita.php?id=$idpro&url=$url"
	);
	$preference -> auto_return = "approved";
	$preference -> save();

  $response = array(
      'id' => $preference->id,
  ); 
  echo json_encode($response);
?>