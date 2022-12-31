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

if (isset($_POST['save_indumentaria'])) {
  $indumentaria = $_POST['indumentaria'];

$query = "INSERT INTO indumentaria_user(indumentaria) VALUES ('$indumentaria')";
$result = mysqli_query($conn, $query);
if(!$result) {
  die("Query Failed.");
}
$_SESSION['card'] = 1;
$_SESSION['message'] = "La indumentaria " .$indumentaria ." fue guardada.";
$_SESSION['message_type'] = 'success';
header('Location: ../Basico/herramientas.php');

}

?>
