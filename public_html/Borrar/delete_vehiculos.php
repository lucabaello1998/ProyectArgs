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
if($tipo == "Visor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
	
	
if(isset($_GET['id']))
{			
	$id = $_GET['id'];
	$query = "SELECT * FROM vehiculos WHERE id = $id";
	$result_tasks = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($result_tasks)) 
	{
		$pdf = $row['archivo'].".pdf";
		$filename = "../Archivos/vehiculos/$pdf";
		if (file_exists($filename))
		{
		    $success = unlink($filename);    
		    if (!$success)
		    {
		      $msg = "No se pudo eliminar el archivo " .$pdf;
		    }
			$query = "DELETE FROM vehiculos WHERE id = $id";
			$result = mysqli_query($conn, $query);
			if(!$result)
			{
				$msg ="Error al eliminar el vehiculo";
			}
			else
			{
				$msg = "Vehiculo eliminado";
			}
				
		}
		else
		{
			$msg = "No existe el archivo PDF";
		}		
	}
}
else
{
$msg= "Error";
}
$_SESSION['card'] = 1;
$_SESSION['message'] = $msg;
$_SESSION['message_type'] = 'danger';
header('Location: ../Basico/vehiculos.php');

?>
