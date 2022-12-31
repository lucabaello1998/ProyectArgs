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
if (isset($_POST['save_sap']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'SAP', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $sap = $_POST['sap'];
  $material = $_POST['material'];

  $sap_mat = mysqli_query($conn, "SELECT *,COUNT(sap) as 'total' FROM basemateriales WHERE sap = '$sap' OR material = '$material'");
  while($row = mysqli_fetch_assoc($sap_mat))
  {
    if($row['total'] == 0)
    {
      $ingreso = mysqli_query($conn, "INSERT INTO basemateriales(sap, material)VALUES('$sap','$material')");
      if(!$ingreso)
      {
        $titulo_toast = "Error";
        $msj_toast = "Hubo un error interno al guardar el proceso";
        $color_toast = "danger";
      }
      else
      {
        $titulo_toast = "Guardado";
        $msj_toast = "El material " .$material ." fue guardado correctamente.";
        $color_toast = "success";
      }
    }
    else
    {
      $titulo_toast = "Error";
      $msj_toast = "El material " .$material ." ya estaba ingresado previamente";
      $color_toast = "danger";
    }
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast; 
  header('Location: ../Basico/sap.php');
}
?>