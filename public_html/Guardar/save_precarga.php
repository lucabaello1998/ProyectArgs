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
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien = $nombre ." " .$apellido;

if (isset($_POST['save_precarga'])) {
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Precarga meterial', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $zona = $_POST['zona'];
  $materiall = utf8_decode($_POST['material']);
  $cantidad = $_POST['cantidad'];
  $tipo = 'Precarga';

  $query_mat = "SELECT * FROM ingresomaterial WHERE seriado = '' AND material = '$materiall' GROUP BY material";
  $result_mat = mysqli_query($conn, $query_mat);
  if (mysqli_num_rows($result_mat) == 1) {
    $row = mysqli_fetch_array($result_mat);
    $material = $row['material'];
    $sap = $row['sap'];
  }
  
  $query = "INSERT INTO asignacion_material (quien, deposito, sap, material, cantidad, tipo) VALUES ('$quien','$zona', '$sap', '$materiall', '$cantidad', '$tipo')";
  $result = mysqli_query($conn, $query);
  if(!$result)
  {
    $msj = $query;
    $color = 'danger';
  }
  else
  {
    $msj = "El material " .$material ." fue guardado en el " .$zona .".";
    $color = 'success';
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/precarga.php');
}
?>