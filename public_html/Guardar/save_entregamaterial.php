<?php

include('../db.php');
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



$queryDescarga = $conn->query("SELECT material, tecnico, fechaegre, centro, cantidad FROM entregamaterial");
$queryAsignacion = $conn->query("SELECT cantidad, centro, material, tecnico FROM materiales");


	if (isset($_POST['save_entregamaterial']))     /////////Si se presiona el boton "save_taskdm"///////////
	{
		/* MOVIMIENTO INDIVIDUAL */
			$token_movi = uniqid();
			$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
			$tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
			$hoy_movi = date("Y-m-j");
			mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Entrega herramienta', '$hoy_movi', '$tipo_us', '$zona_us')");
		/* MOVIMIENTO INDIVIDUAL */
	///////////////////Conversion de variables////////////////////
	  $material = $_POST['material'];
	  $tecnico = $_POST['tecnico'];
	  $fechaegre = $_POST['fechaegre'];
	  $centro = $_POST['centro'];
	  $cantidad = $_POST['cantidad'];

		$query= "SELECT SUM(cantidad) as 'canmat' FROM materiales WHERE centro='$centro' AND material='$material'"; 
		$result_tasks = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result_tasks)) { 
		$canmat= $row['canmat'];
		}

		if ($canmat >= 1 && $canmat >= $cantidad)
		{

		///////////////////////////Se ejecuta la insercion a la tabla taskdm////////////////////////
		  $queryDesc=$conn->query("INSERT INTO entregamaterial (material, tecnico, fechaegre, centro, cantidad) VALUES ('$material', '$tecnico', '$fechaegre', '$centro', '$cantidad')");
		  if ($queryDesc==true)  ////////////////Si se ejecuta con exito se pasa a la actualizacion de la tabla taskas/////////////

		  {
		    $queryAsig=$conn->query("UPDATE materiales set  cantidad = cantidad - '$cantidad', tecnico = '$tecnico' WHERE centro = '$centro' AND material = '$material'  ORDER BY id DESC LIMIT 1");
		  }
		  if ($queryAsig=true)   //////////////Si se ejecuta con exito se envia el mensaje///////////

		  {
		  	
		  /////////////////Mensaje en la variable _SESSION/////////////
		  	$_SESSION['card'] = 1;
		  $_SESSION['message'] = "Se le entrego " .$cantidad ." " .$material ." a " .$tecnico ." del deposito " .$centro ;   ////////////////Mensaje//////////////
		  $_SESSION['message_type'] = 'success';   ////////////////Color///////////
		  header('Location: ../Basico/cargam.php'); ///////////////////////Despues enviar a....///////////////////
		  }
		  /////////////////Si la actualizacion de la tabla materiales no se realiza, aparece mensaje////////////////////////////
		    die("Error.");
		 
		}
		else
		{
		  /////////////////Mensaje en la variable _SESSION/////////////
			$_SESSION['card'] = 1;
		  $_SESSION['message'] = "No hay suficiente " .$material ." en el deposito de " .$centro .", solo tienes " .$canmat ;   ////////////////Mensaje//////////////
		  $_SESSION['message_type'] = 'danger';   ////////////////Color///////////
		  header('Location: ../Basico/cargam.php'); ///////////////////////Despues enviar a....///////////////////
		}
	
	}
	