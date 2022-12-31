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
	$query = "SELECT * FROM auditoria_instalaciones WHERE id=$id";
  $result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1)
	{
    $row = mysqli_fetch_array($result);
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
    $imagentercera = $row['imagenter'];
    $imagencuarta = $row['imagencuar'];
  }
  $filename1 = "../Archivos/instalaciones/$imagenprimera";
  if (file_exists($filename1))
  {
    $success = unlink($filename1);           
  }
  $filename2 = "../Archivos/instalaciones/$imagensegunda";
  if (file_exists($filename2))
  {
    $success = unlink($filename2);           
  }
  $filename3 = "../Archivos/instalaciones/$imagentercera";
  if (file_exists($filename3))
  {
    $success = unlink($filename3);           
  }
  $filename4 = "../Archivos/instalaciones/$imagencuarta";
  if (file_exists($filename4))
  {
    $success = unlink($filename4);           
  }

	$query = "DELETE FROM auditoria_instalaciones WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Query Failed.");
	}
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'Auditoria eliminada';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/auditorias_instalaciones2.php');
}

?>
