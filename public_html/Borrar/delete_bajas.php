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
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
if(isset($_GET['id']))
{
	/* MOVIMIENTO INDIVIDUAL */
		$token_movi = uniqid();
		$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
		$tipo_us = $_SESSION['tipo_us'];
		$zona_us = $_SESSION['zona'];
		$hoy_movi = date("Y-m-j");
		mysqli_query($conn, "INSERT INTO movimiento_interno(token,
		quien,
		movimiento,
		pag,
		inicio,
		tipo,
		zona) VALUES ('$token_movi',
		'$quien_notas',
		'Borrado',
		'Bajas',
		'$hoy_movi',
		'$tipo_us',
		'$zona_us')");
	/* MOVIMIENTO INDIVIDUAL */
	$id = $_GET['id'];
	$result = mysqli_query($conn, "DELETE FROM bajas WHERE id = '$id'");
	if(!$result)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al actualizar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Borrado";
      $msj_toast = "La orden fue eliminada correctamente";
      $color_toast = "danger";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
	header('Location: ../Basico/bajas.php');
}
?>