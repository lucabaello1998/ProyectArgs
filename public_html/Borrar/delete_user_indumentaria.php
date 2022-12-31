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
if($tipo != "Administrador") /////Visor - Deposito - Supervisor - Despacho/////
{
header("location: ../index.php");
}
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "DELETE FROM indumentaria_user WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Query Failed.");
	}
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'Indumentaria eliminado';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/herramientas.php');
}

?>
