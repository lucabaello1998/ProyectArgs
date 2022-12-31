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
  header("location: ../index.php");
}

if (isset($_POST['save_cambiotec']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Cambio de tecnologia', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $calendario = $_POST['calendario'];
  $mac_ont = $_POST['mac_ont'];
  $sn_ont = $_POST['sn_ont'];



  $query = "INSERT INTO cambiotecnologia(tecnico, ot, direccion, calendario, mac_ont, sn_ont) VALUES ('$tecnico', '$ot', '$direccion', '$calendario', '$mac_ont', '$sn_ont')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Error en la carga de la orden, comuniquese al 1162595187 XD");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La orden " .$ot ." de " .$tecnico ." fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/cambiotec.php');

}

?>
