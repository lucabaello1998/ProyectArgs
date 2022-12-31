<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
$quien_notas = $nombre_us .' ' .$apellido_us;
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
if (isset($_POST['save_bajas']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Bajas', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = uniqid();
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $zona = $_POST['zona'];
  $tkl = $_POST['tkl'];
  $motivo = $_POST['motivo'];
  $obs = $_POST['obs'];
  $direccion = $_POST['direccion'];
  $calendario = $_POST['calendario'];

  $result = mysqli_query($conn, "INSERT INTO bajas(token, quien, tecnico, ot, zona, tkl, motivo, obs, direccion, calendario) VALUES ('$token', '$quien_notas', '$tecnico', '$ot', '$zona', '$tkl', '$motivo', '$obs', '$direccion', '$calendario')");
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La orden " .$ot ." de " .$tecnico ." fue guardada.";
    $color_toast = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/bajas.php');
}
?>