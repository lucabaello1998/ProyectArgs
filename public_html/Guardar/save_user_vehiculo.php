<?php

include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo != "Administrador") /////Visor - Deposito - Supervisor - Despacho/////
{
header("location: ../index.php");
}

if (isset($_POST['save_vehiculo'])) {
  $vehiculo = $_POST['vehiculo'];

$query = "INSERT INTO vehiculo_user(vehiculo) VALUES ('$vehiculo')";
$result = mysqli_query($conn, $query);
if(!$result) {
  die("Query Failed.");
}
$_SESSION['card'] = 1;
$_SESSION['message'] = "El vehiculo " .$vehiculo ." fue guardado.";
$_SESSION['message_type'] = 'success';
header('Location: ../Basico/herramientas.php');

}

?>
