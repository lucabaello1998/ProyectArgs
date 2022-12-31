<?php

include 'db.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

$fecha = date('Y-m-d');

$mes = date('m');
$anio = date('Y');


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);



$consulta_alta_mes_actual = "SELECT COUNT(*) AS total FROM corpo WHERE (tarea LIKE '%alta%' OR tarea LIKE '%ALTA%') AND MONTH(fecha) = $mes AND YEAR(fecha) = $anio";

$consulta_baja_mes_actual  = "SELECT COUNT(*) AS total FROM corpo WHERE (tarea LIKE '%baja%' OR tarea LIKE '%BAJA%') AND MONTH(fecha) = $mes AND YEAR(fecha) = $anio";

$consulta_pendientes = "SELECT COUNT(*) AS total FROM corpo_tareas WHERE (estado LIKE '%a coordinar%' OR estado LIKE '%a confirmar%') AND MONTH(F_Asignado) = $mes AND YEAR(F_Asignado) = $anio";


$resultado_consulta_alta_mes_actual = mysqli_query($conn, $consulta_alta_mes_actual);

$resultado_consulta_baja_mes_actual = mysqli_query($conn, $consulta_baja_mes_actual);

$resultado_consulta_pendientes = mysqli_query($conn, $consulta_pendientes);


$fila_resultado_consulta_alta_mes_actual = mysqli_fetch_assoc($resultado_consulta_alta_mes_actual);

$fila_resultado_consulta_baja_mes_actual = mysqli_fetch_assoc($resultado_consulta_baja_mes_actual);

$fila_resultado_consulta_pendientes = mysqli_fetch_assoc($resultado_consulta_pendientes);

$resultado_json = json_encode(array(
    "alta_mes" => $fila_resultado_consulta_alta_mes_actual, 
    "baja_mes" => $fila_resultado_consulta_baja_mes_actual, 
    "pendientes" => $fila_resultado_consulta_pendientes,
    "mes" => $mes));





echo $resultado_json;

mysqli_close($conexion);

?>