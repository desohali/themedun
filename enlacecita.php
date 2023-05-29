<?php

$id = $_GET['id'];
$url = $_GET['url'];

if(isset($id) && isset($_GET['payment_id']) && isset($_GET['status']) && isset($_GET['payment_type']) && isset($_GET['merchant_order_id'])){
    if($_GET['payment_type']=='credit_card'){
        $_GET['payment_type'] = 'credit-card';
    } else if($_GET['payment_type']=='debit_card'){
        $_GET['payment_type'] = 'debit-card';
    }
	header("Location: cita/".$id."/".$_GET['payment_id']."/".$_GET['status']."/".$_GET['payment_type']."/".$_GET['merchant_order_id'] . "/" . $url);
}else{
	header("Location: " . $url . "/".$id);
}

/*if(isset($_GET['id']) && isset($_GET['payment_id']) && isset($_GET['payment_type']) && isset($_GET['status'])){
	$views = explode("/", $_GET['id']);
    include 'cita/'.$_GET['id'].'/'.$_GET['payment_id'].'/'.$_GET['payment_type'].'/'.$_GET['status'];
}else{
	include 'http://localhost/themeduni/cita/'.$_GET['id'];
}*/
?>