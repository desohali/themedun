<?php

  function getItem($orderId){
    $ACCESS_TOKEN="TEST-4332121290660940-011922-f2b23786f590ccbe0175beea8f3e766c-1291343904"; //aqui cargamos el token
    $curl = curl_init(); //iniciamos la funcion curl
    
    curl_setopt_array($curl, array(
    //ahora vamos a definir las opciones de conexion de curl
        CURLOPT_URL => "https://api.mercadopago.com/merchant_orders/". $orderId, //aqui iria el id de tu pago
        CURLOPT_CUSTOMREQUEST => "GET", // el metodo a usar, si mercadopago dice que es post, se cambia GET por POST.
        CURLOPT_RETURNTRANSFER => true, //esto es importante para que no imprima en pantalla y guarde el resultado en una variable
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 0, 
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$ACCESS_TOKEN
        ),
      ));
      
      $response = curl_exec($curl); //ejecutar CURL
      $json_data = json_decode($response, true);

      return array(
        "status" => @$json_data["status"],
        "firstItem" => @$json_data["items"][0],
      );
  }
?>