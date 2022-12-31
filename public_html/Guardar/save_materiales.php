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
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor/////
}



if (isset($_POST['save_materiales'])) {
  if (!$_POST['material'])
  {
    $material = $_POST['materialdentro'];
  }
  else
  {
    $material = $_POST['material'];
  }
  
  
  $centro = $_POST['centro'];
  
  $cantidad = $_POST['cantidad'];
  $fecha = $_POST['fecha'];
  


  $query = "INSERT INTO materiales(material, centro, cantidad, fecha) VALUES ('$material', '$centro', '$cantidad', '$fecha')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "Se cargo " .$cantidad ." " .$material ." en el deposito de " .$centro ;
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/cargam.php');

}

?>

