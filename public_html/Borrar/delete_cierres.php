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
if(isset($_POST['borrar']))
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
		'Cierre de tarea',
		'$hoy_movi',
		'$tipo_us',
		'$zona_us')");
	/* MOVIMIENTO INDIVIDUAL */
	$token = $_POST['token'];
  $resultt = mysqli_query($conn, "SELECT * FROM cierre_tarea WHERE token = '$token'");
  if (mysqli_num_rows($resultt) == 1)
  {
    $row = mysqli_fetch_array($resultt);
    $imagenpri = $row['imagenpri'];
    $imagenseg = $row['imagenseg'];
    $imagenter = $row['imagenter'];
    $tipo_tarea = $row['tipo_tarea'];
  }

  if($tipo_tarea == 'Exitoso')
  {
    $filename1 = "../Archivos/cierre_tarea/exitoso/$imagenpri";
    if (file_exists($filename1))
    {
      unlink($filename1);
    }
    $filename2 = "../Archivos/cierre_tarea/exitoso/$imagenseg";
    if (file_exists($filename2))
    {
      unlink($filename2);
    }
    $filename3 = "../Archivos/cierre_tarea/exitoso/$imagenter";
    if (file_exists($filename3))
    {
      unlink($filename3);
    }
  }
  else
  {
    $filename4 = "../Archivos/cierre_tarea/fallido/$imagenpri";
    if (file_exists($filename4))
    {
      unlink($filename4);
    }
  }

	$result = mysqli_query($conn, "DELETE FROM cierre_tarea WHERE token = '$token'");
	if(!$result)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al actualizar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Borrado";
      $msj_toast = "La orden fue borrada correctamente";
      $color_toast = "danger";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
	header('Location: ../Basico/cierres_tareas.php');
}
?>