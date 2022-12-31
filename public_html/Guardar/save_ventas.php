<?php

include('../db.php');
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}

if (isset($_POST['save_ventas'])) {
	$cliente = strtotime("now");
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  $contacto = $_POST['contacto'];
  $direccion = $_POST['direccion'];
  $entrecallea = $_POST['entrecallea'];
  $entrecalleb = $_POST['entrecalleb'];
  $provincia = $_POST['provincia'];
  $localidad = $_POST['localidad'];
  $fecha = $_POST['fecha'];
  $turno = $_POST['turno'];
  $instalacion = $_POST['instalacion'];
  $obs = $_POST['obs'];

  $query = "INSERT INTO ventas(cliente, nombre, apellido, dni, contacto, direccion, entrecallea, entrecalleb, provincia, localidad, fecha, turno, instalacion, obs) VALUES ('$cliente', '$nombre', '$apellido', '$dni', '$contacto', '$direccion', '$entrecallea', '$entrecalleb', '$provincia', '$localidad', '$fecha', '$turno', '$instalacion', '$obs')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La instalacion de " .$nombre ." " .$apellido ." fue programada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/ventas.php');

}

?>
