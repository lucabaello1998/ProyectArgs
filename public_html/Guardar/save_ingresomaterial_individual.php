<?php
include("../db.php");
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
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

if(isset($_POST['individual']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Ingreso material individual', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $quien = $nombre ." " .$apellido;

  $fecha = $_POST['fecha'];
  $proveedor = $_POST['proveedor'];
  $deposito = $_POST['deposito'];
  $sap = $_POST['sap'];
  $material = $_POST['material'];
  $cantidad = $_POST['cantidad'];
  $obs_uno = $_POST['obs'];

  $entrada = "INSERT INTO  ingresomaterial(usuario, fecha, proveedor, deposito, operatoria, sap, material, cantidad, obs) VALUES ('$quien','$fecha', '$proveedor', '$deposito', 'IPTV', '$sap', '$material', '$cantidad', '$obs_uno')";
  $result = mysqli_query($conn, $entrada);
  if(!$result)
  {
    $msj = "Error en el servidor.";
    $color = "danger";
  }
  else
  {
    $msj = "El material fue guardado.";
    $color = "success";
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/ingresomaterial.php');
}
?>