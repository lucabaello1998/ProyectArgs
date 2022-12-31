<?php
include("../db.php");
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
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$r = mysqli_query($conn, "DELETE FROM altas WHERE id = '$id'");
	if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Eliminado";
    $msj_toast = "La orden fue eliminada correctamente.";
    $color_toast = "danger";
  }
	$_SESSION['card'] = 1;
	$_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
	header('Location: ../Basico/altas2.php');
}

?>
