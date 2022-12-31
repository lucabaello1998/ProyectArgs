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

	$queryy = "SELECT * FROM entregamaterial WHERE id=$id";
	$resulta = mysqli_query($conn, $queryy);
	if (mysqli_num_rows($resulta) == 1)
	{
    $row = mysqli_fetch_array($result);
    $centro = $row['centro'];
    $cantidad = $row['cantidad'];
    $material = $row['material'];
	}

	$queryyy = "UPDATE materiales set cantidad = cantidad + '$cantidad' WHERE material=$material AND centro='$centro'";
  	mysqli_query($conn, $queryyy);

	$query = "DELETE FROM entregamaterial WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Query Failed.");
	}
	$_SESSION['card'] = 1;
	$_SESSION['message'] = 'Entrega eliminada';
	$_SESSION['message_type'] = 'danger';
	header('Location: ../Basico/cargam.php');
}

?>
