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

if (isset($_POST['save_herramienta'])) {
  $herramienta = $_POST['herramienta'];

  


  $query = "INSERT INTO herramienta(herramienta) VALUES ('$herramienta')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La herramienta " .$herramienta ." fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/herramientas.php');

}

?>
