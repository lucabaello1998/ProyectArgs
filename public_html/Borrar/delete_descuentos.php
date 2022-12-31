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
  header("location: ../index.php");   /////Visor - Deposito/////
}
if(isset($_GET['id'])) {
	$id = $_GET['id'];

	$query_img = "SELECT * FROM descuentos WHERE id=$id";
  $result_img = mysqli_query($conn, $query_img);
	if (mysqli_num_rows($result_img) == 1)
	{
    $row = mysqli_fetch_array($result_img);
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
  }
  $filename1 = "../Archivos/penalizaciones/$imagenprimera";
  if (file_exists($filename1))
  {
    $success = unlink($filename1);
  }
  $filename2 = "../Archivos/penalizaciones/$imagensegunda";
  if (file_exists($filename2))
  {
    $success = unlink($filename2);
  }



	$query = "DELETE FROM descuentos WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Query Failed.");
	}
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'Penalizacion eliminada';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/descuentos.php');
}

?>
