<?php

include('../../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "ATC") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   
}

if (isset($_POST['save_kilometrosindividual'])) {
  $nombre = $_POST['nombre'];
  $fecha = $_POST['fecha'];
  $hora = $_POST['hora'];
  $fin = $_POST['fin'];
  $dia = $_POST['dia'];
  $partido = $_POST['partido'];
  $km = $_POST['km'];
  $reportes = $_POST['reportes'];
  $obs = $_POST['obs'];

  $query = "INSERT INTO atckilometros(nombre, fecha, hora, fin, dia, partido, km, obs, reportes) VALUES ('$nombre', '$fecha', '$hora', '$fin', '$dia', '$partido', '$km', '$obs', '$reportes')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del relevador " .$nombre ." fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../ATC/indexatc.php');

}

?>
