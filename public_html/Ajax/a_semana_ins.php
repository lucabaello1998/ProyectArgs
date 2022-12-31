<style>
  :root { --del-color: #F56F84;}
  del 
  {
    --color: var(--del-color, red);
    text-decoration: none;
    padding: 0 .5em;
    background-repeat: no-repeat;
    background-image: 
      linear-gradient(to left, rgba(255, 255, 255, .5), transparent),
      linear-gradient(2deg, var(--color) 50%, transparent 50%),
      linear-gradient(-.9deg, var(--color) 50%, transparent 50%),
      linear-gradient(-60deg, var(--color) 50%, transparent 50%),
      linear-gradient(120deg, var(--color) 50%, transparent 50%);
    
    background-size: 
      30% 1.5px,
      calc(100% - 20px) 10px, 
      calc(100% - 20px) 10px,
      10px 10px,
      8px 8px; 
    
    background-position: 
      100% calc(50% + 2px),
      center center, 
      center center, 
      2px 50%, 
      calc(100% - 3px) calc(50% + 1px);
  }
</style>
<?php
  $diaSemana = date("w");
  $num_semana = 0 .$_POST["fecha"];
  # Calcular el tiempo (no la fecha) de cuándo fue el inicio de semana
  $tiempoDeInicioDeSemana = strtotime("-" . $diaSemana . " days"); # Restamos -X days
  # Y formateamos ese tiempo
  $fechaInicioSemana = date("Y-m-d", $tiempoDeInicioDeSemana);
  $fechamas = date ('Y-m-d', strtotime($fechaInicioSemana."+$num_semana day". "+1 day"));
  # Ahora para el fin, sumamos
  $tiempoDeFinDeSemana = strtotime("+" . $diaSemana . " days"); # Sumamos +X days, pero partiendo del tiempo de inicio
  # Y formateamos
  $fechaFinSemana = date("Y-m-d", $tiempoDeFinDeSemana);
  $fechamas2 = date ('Y-m-d', strtotime($fechaFinSemana."+$num_semana day". "+1 day"));
?>
<?php 
include("../db.php"); 
$resu = mysqli_query($conn, "SELECT * FROM calendario WHERE (inicio BETWEEN '$fechamas' AND '$fechamas2') AND tarea = 'Auditoria de instalacion' AND estado <> 'Rechazado' ");  //////ARRAY DE ULTIMOS TECNICOS
while($row = mysqli_fetch_assoc($resu))
{
  $array[] = $row['tecnico']; /////guarda resultados en un array Array ( [0] => Brian Flores [1] => Carlos Da Silva [2] => Cristian Caro [3] => Leandro Vaca [4] => Mauro Ramirez [5] )
}

$result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");  
while($row = mysqli_fetch_assoc($result_tasks))
{
  $tec = $row['tecnico']; /////guarda los resultados de la consulta en la variable $tec

  if (in_array($tec, $array)) ////buscame el valor de $tec en la lista de $array
  {
    ?>
      <span class="badge badge-pill badge-danger objeto m-1 p-1" style="cursor: pointer;" data-event='{ "title": "Auditoria de instalacion", "color": "#FFAA16", "tecnico": "<?php echo $row['tecnico']; ?>" }'><?php echo limitar_cadena($row['tecnico'],15) ?></span>
    <?php
  }
  else
  {
    ?>
      <span class="badge badge-pill badge-warning objeto m-1 p-1" style="cursor: pointer;" data-event='{ "title": "Auditoria de instalacion", "color": "#FFAA16", "tecnico": "<?php echo $row['tecnico']; ?>" }'><?php echo limitar_cadena($row['tecnico'],15) ?></span>
    <?php
  }
}

          