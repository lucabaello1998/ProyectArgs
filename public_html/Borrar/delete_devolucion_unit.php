<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$$tipo_us = $_SESSION['tipo_us'];
if($$tipo_us == "Administrador") { $usu = 1; }
if($$tipo_us == "Despacho") { $usu = 1; }
if($$tipo_us == "Supervisor") { $usu = 1; }
if($$tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
if(isset($_GET['token']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us_us = $_SESSION['tipo_us'];
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
    'Borrar',
    'Devolucion',
    '$hoy_movi',
    '$tipo_us_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
	$token = $_GET['token'];
	$r = mysqli_query($conn, "DELETE FROM devolucion WHERE token = '$token'");
	if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Eliminado";
    $msj_toast = "El item fue eliminado correctamente.";
    $color_toast = "danger";
  }
	$_SESSION['card'] = 1;
	$_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
	header('Location: ../Basico/devolucion.php');
}
?>