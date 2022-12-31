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


if (isset($_POST['save_indumentaria']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Indumentaria', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  if (!$_POST['indumentaria'])
  {
    $indumentaria = $_POST['indumentariadentro'];
  }
  else
  {
    $indumentaria = $_POST['indumentaria'];
  }
  
  $talle = $_POST['talle'];
  $sap = $_POST['sap'];
  $centro = $_POST['centro'];
  $pedido = $_POST['pedido'];
  $cantidad = $_POST['cantidad'];
  $fecha = $_POST['fecha'];
  


  $query = "INSERT INTO indumentaria(indumentaria, talle, sap, centro, pedido, cantidad, fecha) VALUES ('$indumentaria', '$talle', '$sap', '$centro', '$pedido', '$cantidad', '$fecha')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "Se cargo " .$cantidad ." " .$indumentaria ." talle " .$talle ." en el deposito de " .$centro ;
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/indumentaria.php');

}

?>

