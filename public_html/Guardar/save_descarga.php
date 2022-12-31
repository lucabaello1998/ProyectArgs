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
	/* MOVIMIENTO INDIVIDUAL */
		$token_movi = uniqid();
		$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
		$tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
		$hoy_movi = date("Y-m-j");
		mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Descarga de material', '$hoy_movi', '$tipo_us', '$zona_us')");
	/* MOVIMIENTO INDIVIDUAL */
	$quien = $nombre ." " .$apellido;
	$tecnico = $_POST['tecnico'];
	$query_id = "SELECT * FROM tecnicos WHERE tecnico = '$tecnico' ";
	$result_id = mysqli_query($conn, $query_id);
	while($row = mysqli_fetch_assoc($result_id))
	{
		$id = $row['token'];
	}
	$sap = $_POST['sap'];
	$material = $_POST['material'];
	$cantidad = $_POST['cantidad'];
  $zona = $_POST['zona'];
	$seriado = $_POST['seriado'];
  $fecha = $_POST['fecha'];
  $usado = $_POST['usado'];
	$ot = $_POST['ot'];
	$token = $_POST['token'];
	$tipo_asig = 'Descarga';
  
	if (isset($_POST['material']))
	{
		///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
		while(true)
		{
			//// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
			$item5 = current($usado);
      $item6 = current($material);
			$item7 = current($seriado);
			$item8 = current($sap);
			
			////// ASIGNARLOS A VARIABLES ///////////////////
			$usadousado=(( $item5 !== false) ? $item5 : ", &nbsp;");
      $materialmaterial=(( $item6 !== false) ? $item6 : ", &nbsp;");
			$seriadoseriado = (( $item7 !== false) ? $item7 : ", &nbsp;");
			$sapsap=(( $item8 !== false) ? $item8 : ", &nbsp;");

			if($seriadoseriado == '')
      {
        //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
				$valores='("'.$quien.'","'.$fecha.'","'.$tecnico.'","'.$id.'","'.$sapsap.'","'.$materialmaterial.'","'.$usadousado.'","'.$zona.'","'.$ot.'","'.$token.'","'.$tipo_asig.'"),';

				//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
				$valoresQ= substr($valores, 0, -1);

				//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
				$valoresQ = substr($valores, 0, -1);
				
				///////// QUERY DE INSERCIÓN ////////////////////////////
				$entrada = "INSERT INTO  asignacion_material (quien, fecha, tecnico, id_tec, sap, material, usado, deposito, ot, token, tipo) VALUES $valoresQ";
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
      }
      else
      {
        //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
				$valores='("'.$quien.'","'.$fecha.'","'.$tecnico.'","'.$id.'","'.$sapsap.'","'.$materialmaterial.'","'.$usadousado.'","'.$zona.'","'.$seriadoseriado.'","'.$ot.'","'.$token.'","'.$tipo_asig.'"),';

				//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
				$valoresQ= substr($valores, 0, -1);
				
				///////// QUERY DE INSERCIÓN ////////////////////////////
				$entrada = "INSERT INTO  asignacion_material (quien, fecha, tecnico, id_tec, sap, material, usado, deposito, seriado, ot, token, tipo) VALUES $valoresQ";
				$result = mysqli_query($conn, $entrada);
				$cc = mysqli_query($conn, "UPDATE ingresomaterial set cantidad - $usadousado, ot = '$ot', descargado_por = '$quien', descargado_cuando = '$fecha' WHERE seriado = '$seriadoseriado'");
				if(!$result)
				{
					$msj = "Error en el servidor.";
					$color = "error";
				}
				else
				{
					$msj = "La carga de " .$tecnico ." fue realizada con exito.";
					$color = "success";
				}
      };
      
			// Up! Next Value
			$item5 = next( $usado );
      $item6 = next( $material );
			$item7 = next( $seriado );
			$item8 = next( $sap );

			// Check terminator
			if($item5 === false && $item6 === false && $item7 === false && $item8 === false ) break;
		}
	}
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/descarga.php');
}

if (isset($_POST['menos']))
{
	if(isset($_POST['menos']))
 {
	 $ultima_fecha = $_POST['ultima_fecha'];
   $encriptado = date ('Y-m', strtotime($ultima_fecha."- 1 month"));
	 $fechaa = base64_encode($encriptado);
 }
  header('Location: ../Basico/descarga.php?mes='.$fechaa);
}

if (isset($_POST['mas']))
{
	if(isset($_POST['mas']))
 {
	 $ultima_fecha = $_POST['ultima_fecha'];
   $encriptado = date ('Y-m', strtotime($ultima_fecha."+ 1 month"));
	 $fechaa = base64_encode($encriptado);
 }
  header('Location: ../Basico/descarga.php?mes='.$fechaa);
}
?>
