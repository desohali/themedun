<?php
//session_set_cookie_params(60 * 60 * 24 * 365);
ini_set("session.gc_maxlifetime", 60*60*24*365);
ini_set("session.cookie_lifetime", 60*60*24*365);
session_start();

include "./php/conexion_paciente.php";

$favid = $_POST['id'];
$user = $_SESSION['id'];

$countLikes = $conexion->query("SELECT * FROM favoritos WHERE usuario = '$user' AND idfav = '$favid'");
$cLike = $countLikes->num_rows;

if($cLike == 0) {
	$insertLike = $conexion->query("INSERT INTO favoritos (usuario,idfav) VALUES ('$user', '$favid')");
} else {
	$insertLike = $conexion->query("DELETE FROM favoritos WHERE usuario = '$user' AND idfav = '$favid'");
}

?>