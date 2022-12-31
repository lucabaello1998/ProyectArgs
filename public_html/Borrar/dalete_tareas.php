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
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}
if(isset($_GET['token'])) {
	$token = $_GET['token'];
  $tarea = mysqli_query($conn, "SELECT * FROM tareas WHERE token = '$token'");
	if (mysqli_num_rows($tarea) == 1)
	{
    $row = mysqli_fetch_array($tarea);
    $imagenprimera = $row['archivo_uno'];
    $imagensegunda = $row['archivo_dos'];
    $imagentercera = $row['archivo_tres'];
  }
  $filename1 = "../Archivos/tareas/$imagenprimera";
  if (file_exists($filename1))
  {
    unlink($filename1);
  }
  $filename2 = "../Archivos/tareas/$imagensegunda";
  if (file_exists($filename2))
  {
    unlink($filename2);
  }
  $filename3 = "../Archivos/tareas/$imagentercera";
  if (file_exists($filename3))
  {
    unlink($filename3);
  }
  $titulo_toast = "Borrado";
  $msj_toast = "La tarea fue borrada correctamente";
  $color_toast = "danger";
}
	$_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
?>
