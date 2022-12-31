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
if(isset($_GET['token']))
{
  $tokens = $_GET['token'];
  $queryy = "SELECT * FROM calendario WHERE token = '$tokens'";
  $resultt = mysqli_query($conn, $queryy);
  if (mysqli_num_rows($resultt) == 1)
  {
    $row = mysqli_fetch_array($resultt);
    $titulo = $row['titulo'];   
  }

	$token = $_GET['token'];
	$consuk = "DELETE FROM calendario WHERE token = '$token' ";
	$resu = mysqli_query($conn, $consuk);
	if(!$resu)
    {
			$msj = "Error en el servidor.";
			$color = "danger";
    }
    else
    {
			$msj = "La tarea " .$titulo ." fue eliminada.";
			$color = "danger";
    }
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msj;
    $_SESSION['message_type'] = $color;
    header('Location: ../Basico/b_calendario.php');
}

?>