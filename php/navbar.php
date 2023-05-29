
<?php

include 'conexion_paciente.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    /* header("location: login"); */
    /* exit; */
}

$salida = "";
$query = "SELECT * FROM usuariospro WHERE estado = '1' ORDER By idpro";

$resultado = $conexion->query($query);
if ($resultado->num_rows > 0) {
    $salida .= "<ul id='box-search'>";
    while ($fila = $resultado->fetch_assoc()) {
        $salida .= "  <li>
                            <a href='" . $_ENV['APP_URL'] . "perfilproo/" . $fila['idpro'] . "'>
                                <i id='search-busca' class='fa-solid fa-magnifying-glass'><p>" . $fila['nombrespro'] . ' ' . $fila['apellidospro'] . "</p></i>
                            </a>
                        </li>";
    }
    $salida .= "</ul>";
}

echo $salida;

?>