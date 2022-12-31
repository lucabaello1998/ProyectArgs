<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo_us = $_SESSION['tipo_us'];
if($tipo_us == "Administrador") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
if(isset($_GET['token']))
{
	$token = $_GET['token'];
	$r = mysqli_query($conn, "DELETE FROM movimiento_interno WHERE token = '$token'");
	if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al borrar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Eliminado";
    $msj_toast = "El movimiento fue eliminado correctamente.";
    $color_toast = "danger";
  }
	$_SESSION['card'] = 1;
	$_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
	header('Location: ../Basico/movimientos_internos.php');
}
?>