<?php
  include './php/conexion_paciente.php';
  $updateCita = mysqli_query($conexion, "UPDATE citas SET localizacion = '200' WHERE idcita='165'");
?>