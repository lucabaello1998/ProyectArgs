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

if (isset($_POST['devolucion']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Devolcuion', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $sn = $_POST['sn'];
  $deposito = $_POST['deposito'];
  $fecha = $_POST['fecha'];
  $obs = $_POST['obs'];
  $sap = $_POST['sap'];
  $material = $_POST['material'];
  $cantidad = $_POST['cantidad'];
  $tipo_mat = $_POST['tipo'];
  $pallet = $_POST['pallet'];
  $num_caja = $_POST['num_caja'];
  $estado = 'En deposito';
  $num_remito = $_POST['num_remito'];
  $statuss = $_POST['status'];

  $datos_excel = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado <> 'Devuelto' ORDER BY id DESC LIMIT 1");
  while($row = mysqli_fetch_assoc($datos_excel))
  {
    $contratista = $row['contratista'];
    $referente = $row['referente'];
    $centro = $row['centro'];
    $almacen = $row['almacen'];
    $sitio = $row['sitio'];
  }

  $r = mysqli_query($conn, "INSERT INTO devolucion(token, quien, tecnico, ot, sn, deposito, fecha, obs, sap, material, cantidad, tipo, num_remito, contratista, referente, centro, almacen, pallet, num_caja, sitio, estado, statuss) VALUES ('$token_movi', '$quien_notas', '$tecnico', '$ot', '$sn', '$deposito', '$fecha', '$obs', '$sap', '$material', '$cantidad', '$tipo_mat', '$num_remito', '$contratista', '$referente', '$centro', '$almacen', '$pallet', '$num_caja', '$sitio', '$estado', '$statuss')");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La equipo " .$sn ." fue guardada correctamente.";
    $color_toast = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/devolucion.php');
}

if (isset($_GET['devolver']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Actualizado', 'Cambio de estado', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $devolver = $_GET['devolver'];
  $fecha_retiro = date("Y-m-d");
  $fecha_devolucion = date("Y-m-d H:i:s");
  $msj_obs = 'Material devuelto en el remito ' .$devolver;

  $depo = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$devolver' AND sn <> ''");
  while($row = mysqli_fetch_assoc($depo))
  {
    $sn = $row['sn'];
    mysqli_query($conn, "UPDATE ingresomaterial set cantidad = 0, obs = '$msj_obs', descargado_cuando = '$fecha_devolucion' WHERE seriado = '$sn' AND cantidad = 1");
  }

  $r = mysqli_query($conn, "UPDATE devolucion set estado = 'Devuelto', fecha_retiro = '$fecha_retiro' WHERE num_remito = '$devolver'");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al actualizar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Actualizado";
    $msj_toast = "El remito fue actualizado";
    $color_toast = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/devolucion.php');
}
?>