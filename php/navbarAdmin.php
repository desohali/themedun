<?php

include 'conexion_paciente.php';

$salida = "";
$query = "SELECT * FROM usuariospro ORDER By idpro";

$resultado = $conexion->query($query);
if ($resultado->num_rows > 0) {
    $salida .= "<ul id='box-search'>";
    while ($fila = $resultado->fetch_assoc()) {
        $salida .= "  <li>
                            <a href='" . $_ENV['APP_URL'] . "perfilrevision/" . $fila['idpro'] . "'>
                                <i id='search-busca' class='fa-solid fa-magnifying-glass'><p>" . $fila['nombrespro'] . ' ' . $fila['apellidospro'] . "</p></i>
                            </a>
                        </li>";
    }
    $salida .= "</ul>";
}

echo $salida;
