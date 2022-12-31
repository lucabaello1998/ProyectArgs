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
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$query_img = "SELECT * FROM auditoria_vehiculo WHERE id=$id";
  $result_img = mysqli_query($conn, $query_img);
	if (mysqli_num_rows($result_img) == 1)
	{
    $row = mysqli_fetch_array($result_img);
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
    $imagentercera = $row['imagenter'];
    $imagencuarta = $row['imagencuar'];
  }
  $filename1 = "../Archivos/foto_vehiculos/$imagenprimera";
  if (file_exists($filename1))
  {
    $success = unlink($filename1);           
  }
  $filename2 = "../Archivos/foto_vehiculos/$imagensegunda";
  if (file_exists($filename2))
  {
    $success = unlink($filename2);           
  }
  $filename3 = "../Archivos/foto_vehiculos/$imagentercera";
  if (file_exists($filename3))
  {
    $success = unlink($filename3);           
  }
  $filename4 = "../Archivos/foto_vehiculos/$imagencuarta";
  if (file_exists($filename4))
  {
    $success = unlink($filename4);           
  }



	$query = "DELETE FROM auditoria_vehiculo WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Query Failed.");
	}
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'Auditoria eliminada';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/auditorias_vehiculo.php');
}

?>
