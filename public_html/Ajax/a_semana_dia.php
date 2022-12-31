<?php
include("../db.php"); 
if(isset($_POST["mas"]))
{
  $diaSemana = date("w");
  $num_semana = 0 .$_POST["fecha"];
  # Calcular el tiempo (no la fecha) de cuándo fue el inicio de semana
  $tiempoDeInicioDeSemana = strtotime("-" . $diaSemana . " days"); # Restamos -X days
  # Y formateamos ese tiempo
  $fechaInicioSemana = date("Y-m-d", $tiempoDeInicioDeSemana);
  $fechamas = date ('Y-m-d', strtotime($fechaInicioSemana."+$num_semana day". "+2 day"));
  # Ahora para el fin, sumamos
  $tiempoDeFinDeSemana = strtotime("+" . $diaSemana . " days"); # Sumamos +X days, pero partiendo del tiempo de inicio
  # Y formateamos
  $fechaFinSemana = date("Y-m-d", $tiempoDeFinDeSemana);
  $fechamas2 = date ('Y-m-d', strtotime($fechaFinSemana."+$num_semana day"));

  # Listo. Hora de imprimir
  echo "Del " .Fecha9($fechamas) ." al " .Fecha9($fechamas2);
}
?>