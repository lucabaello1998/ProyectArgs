<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$tipo = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['save_descarga']))
{
	$quien = $nombre ." " .$apellido;
	$tecnico = $_POST['tecnico'];
	$sap = $_POST['sap'];
	$material = $_POST['material'];
	$cantidad = $_POST['cantidad'];
  $zona = $_POST['zona'];
	$seriado = $_POST['seriado'];
  $fecha = $_POST['fecha'];
  $usado = $_POST['usado'];
	$ot = $_POST['ot'];

  
	if (isset($_POST['material']))
	{
		///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
		while(true)
		{
			//// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
			$item5 = current($usado);
      $item6 = current($material);
      $item7 = current($seriado);
			
			////// ASIGNARLOS A VARIABLES ///////////////////
			$usadousado=(( $item5 !== false) ? $item5 : ", &nbsp;");
      $materialmaterial=(( $item6 !== false) ? $item6 : ", &nbsp;");
      $seriadoseriado=(( $item7 !== false) ? $item7 : ", &nbsp;");

      if($seriadoseriado == '')
      {
        $valores="usado = '" .$usadousado."',";
        $where = "material = '".$materialmaterial."'";
      }
      else
      {
        $valores="usado ='" .$usadousado."',";
        $where = "seriado = '".$seriadoseriado."'";
      };

			//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
			$valoresQ = substr($valores, 0, -1);
			
			///////// QUERY DE INSERCIÓN ////////////////////////////
			$entrada = "UPDATE asignacion_material SET $valoresQ, ot = '$ot' WHERE fecha = '$fecha' AND tecnico = '$tecnico' AND deposito = '$zona' AND $where ";
			$result = mysqli_query($conn, $entrada);
			if(!$result)
			{
				$msj = "Error en el servidor.";
				$color = "danger";
			}
			else
			{
				$msj = "La descarga de " .$tecnico ." del dia " .$fecha ." fue realizada con exito.";
				$color = "success";
			}
			// Up! Next Value
			$item5 = next( $usado );
      $item6 = next( $material );
      $item7 = next( $seriado );

			// Check terminator
			if($item5 === false && $item6 === false && $item7 === false ) break;
		}
	}

  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/descarga.php');
}
?>
