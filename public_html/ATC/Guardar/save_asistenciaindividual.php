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

if (isset($_POST['save_asistenciaindividual'])) {
  $nombre = $_POST['tecnico'];
  $fechaa = $_POST['fechaa'];
  $horaa = $_POST['horaa'];
  $diaa = $_POST['diaa'];
  
  


  $query = "INSERT INTO asistenciaatc(nombre, fecha, hora, dia) VALUES ('$nombre', '$fechaa', '$horaa', '$diaa')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del tecnico " .$nombre ." fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../ATC/Basico/asistencia.php');

}

?>
