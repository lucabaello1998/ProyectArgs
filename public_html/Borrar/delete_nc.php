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
	$query = "DELETE FROM no_conformidades WHERE id = $id";
	$result = mysqli_query($conn, $query);
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'No conformidad eliminada';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/no_conformidad.php');
}
?>
