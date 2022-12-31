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
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}

if (isset($_POST['save_reclamos']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Reclamos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $rf = $_POST['rf'];
  $direccion = $_POST['direccion'];
  $fechains = $_POST['fechains'];
  $fechamail = $_POST['fechamail'];
  $problema = $_POST['problema'];
  $telefono = $_POST['telefono'];
  $fechasolu = "2021-01-01";
  $solucion = "Ninguna aun";
  $gasto = "0" ;

  
  


  $query = "INSERT INTO reclamos(tecnico, rf, ot, direccion, fechains, fechamail, problema, telefono, fechasolu, solucion, gasto) VALUES ('$tecnico', '$rf', '$ot', '$direccion', '$fechains', '$fechamail', '$problema', '$telefono', '$fechasolu', '$solucion', '$gasto')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El reclamo de " .$tecnico ." fue guardado";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/reclamos.php');

}

?>