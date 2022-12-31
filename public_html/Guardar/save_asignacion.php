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

if (isset($_POST['save_tecnicos']))
{
	/* MOVIMIENTO INDIVIDUAL */
		$token_movi = uniqid();
		$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
		$tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
		$hoy_movi = date("Y-m-j");
		mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Asignacion', '$hoy_movi', '$tipo_us', '$zona_us')");
	/* MOVIMIENTO INDIVIDUAL */
	$quien = $nombre ." " .$apellido;
	$fecha = $_POST['fecha'];
	$tecnico = $_POST['tecnico'];
	$query_id = "SELECT * FROM tecnicos WHERE tecnico = '$tecnico' ";
	$result_id = mysqli_query($conn, $query_id);
	while($row = mysqli_fetch_assoc($result_id))
	{
		$id = $row['id_recurso'];
	}
	$token = (strtotime("now"));
	$sap = $_POST['sap'];
	$material = $_POST['material'];
	$cantidad = $_POST['cantidad'];
  $zona = $_POST['zona'];
	$seriado = $_POST['seriado'];
	$tipo_asig = 'Asignacion';

	$yyy = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tecnico' AND fecha = '$fecha' AND tipo = 'Asignacion' AND deposito = '$zona' LIMIT 1");
	if(mysqli_num_rows($yyy) == 1)
	{
		$row = mysqli_fetch_array($yyy);
		$fecha_old = $row['fecha'];
		$token_old = $row['token'];
	}

	if($fecha == $fecha_old)
	{
		$msj = "El tecnico " .$tecnico ." ya fue cargado anteriormente con esa fecha.";
		$color = "danger";
	}
	else
	{
		if (isset($_POST['material']))
		{
			///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
			while(true)
			{
				//// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
				$item1 = $quien;
				$item2 = $fecha;
				$item3 = $tecnico;
				$item4 = $id;
				$item5 = current($sap);
				$item6 = current($material);
				$item7 = current($cantidad);
				$item8 = $zona;
				$item9 = $token;
				$item10 = $tipo_asig;
				
				////// ASIGNARLOS A VARIABLES ///////////////////
				$quienquien = $item1;
				$fechafecha = $item2;
				$tecnicotecnico = $item3;
				$idid = $item4;
				$sapsap=(( $item5 !== false) ? $item5 : ", &nbsp;");
				$materialmaterial=(( $item6 !== false) ? $item6 : ", &nbsp;");
				$cantidadcantidad = (( $item7 !== false) ? $item7 : ", &nbsp;");
				$zonazona = $item8;
				$tokentoken = $item9;
				$tipotipo = $item10;
				
				if($materialmaterial !== '')
				{
					//// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
					$valores='("'.$quienquien.'","'.$fechafecha.'","'.$tecnicotecnico.'","'.$idid.'","'.$sapsap.'","'.$materialmaterial.'","'.$cantidadcantidad.'","'.$zonazona.'","'.$tokentoken.'","'.$tipotipo.'"),';

					//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
					$valoresQ= substr($valores, 0, -1);
					
					///////// QUERY DE INSERCIÓN ////////////////////////////
					$entrada = "INSERT INTO  asignacion_material (quien, fecha, tecnico, id_tec, sap, material, cantidad, deposito, token, tipo) VALUES $valoresQ";
					$result = mysqli_query($conn, $entrada);
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
				}

				// Up! Next Value
				$item5 = next( $sap );
				$item6 = next( $material );
				$item7 = next( $cantidad );

				// Check terminator
				if($item5 === false && $item6 === false && $item7 === false) break;
			}
		}

		if (isset($_POST['seriado']))
		{
			///////////// SEPARAR VALORES DE ARRAYS////////////////////
			while(true)
			{
				$ser = current($seriado);
				$query_sr = "SELECT * FROM ingresomaterial WHERE seriado = '$ser' ";
				$result_sr = mysqli_query($conn, $query_sr);
				while($row = mysqli_fetch_assoc($result_sr))
				{
					$material = $row['material'];
					$sap = $row['sap'];
					$cantidad = $row['cantidad'];
					$ot_ser = $row['ot'];
				}

				$lll = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$fecha' AND seriado = '$ser' AND tipo = 'Asignacion' ");
				while($op = mysqli_fetch_array($lll))
				{
					$tecnico_ser = $op['tecnico'];
					$seriado_ser = $op['seriado'];
				}
				
				//// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
				$item1 = $quien;
				$item2 = $fecha;
				$item3 = $tecnico;
				$item4 = $id;
				$item5 = $sap;
				$item6 = $material;
				$item7 = $cantidad;
				$item8 = $zona;
				$item9 = current($seriado);
				$item10 = $token;
				$item11 = $tipo_asig;
				
				////// ASIGNARLOS A VARIABLES ///////////////////
				$quienquien = $item1;
				$fechafecha = $item2;
				$tecnicotecnico = $item3;
				$idid = $item4;
				$sapsap=$item5;
				$materialmaterial= $item6 ;
				$cantidadcantidad =  $item7 ;
				$zonazona = $item8;
				$seriadoseriado = (( $item9 !== false) ? $item9 : ", &nbsp;");
				$tokentoken = $item10;
				$tipotipo = $item11;
				
				if($seriadoseriado !== '')
				{
					//// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
					$valores='("'.$quienquien.'","'.$fechafecha.'","'.$tecnicotecnico.'","'.$idid.'","'.$sapsap.'","'.$materialmaterial.'","'.$cantidadcantidad.'","'.$zonazona.'","'.$seriadoseriado.'","'.$tokentoken.'","'.$tipotipo.'"),';

					//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
					$valoresQ= substr($valores, 0, -1);
					
					if($seriadoseriado == $seriado_ser)
					{
						$msj2 = ", El equipo " .$seriadoseriado ." ya fue asignado a $tecnico_ser .";
					}
					else
					{
						if($seriadoseriado == $seriado_ser)
						{
							$msj1 = ", El equipo " .$seriadoseriado ." ya fue utilizado en $ot_ser .";
						}
						else
						{
							///////// QUERY DE INSERCIÓN ////////////////////////////
							$entrada = "INSERT INTO  asignacion_material (quien, fecha, tecnico, id_tec, sap, material, cantidad, deposito, seriado, token, tipo) VALUES $valoresQ";
							$result = mysqli_query($conn, $entrada);
							if($result)
							{
								$msj = "La carga de " .$tecnico ." fue realizada con exito.";
								$color = "success";
							}
						}
						
					}
				}
				
				// Up! Next Value
				$item9 = next( $seriado );

				// Check terminator
				if($item9 === false) break;
			}
		}
	}
  
	
	
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj .$msj1 .$msj2;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/asignacion_materiales.php');
}

if (isset($_POST['menos']))
{
	if(isset($_POST['menos']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $encriptado = date ('Y-m-d', strtotime($ultima_fecha."-1 day"));
    $fechaa = base64_encode($encriptado);
  }
  header('Location: ../Basico/asignacion_materiales.php?dia='.$fechaa);
}

if (isset($_POST['mas']))
{
	if(isset($_POST['mas']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $encriptado = date ('Y-m-d', strtotime($ultima_fecha."+1 day"));
    $fechaa = base64_encode($encriptado);
  }
  header('Location: ../Basico/asignacion_materiales.php?dia='.$fechaa);
}
?>
