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
  header("location: ../index.php");
}



$queryDescarga = $conn->query("SELECT indumentaria, tecnico, fechaegre, centro, cantidad FROM entregaindumentaria");
$queryAsignacion = $conn->query("SELECT cantidad, centro, indumentaria, tecnico FROM indumentaria");


	if (isset($_POST['save_entregaindumentaria']))     /////////Si se presiona el boton "save_taskdm"///////////
	{
		/* MOVIMIENTO INDIVIDUAL */
			$token_movi = uniqid();
			$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
			$tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
			$hoy_movi = date("Y-m-j");
			mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Entrega indumentaria', '$hoy_movi', '$tipo_us', '$zona_us')");
		/* MOVIMIENTO INDIVIDUAL */
	///////////////////Conversion de variables////////////////////
	  $indumentaria = $_POST['indumentaria'];
	  $tecnico = $_POST['tecnico'];
	  $fechaegre = $_POST['fechaegre'];
	  $centro = $_POST['centro'];
	  $cantidad = $_POST['cantidad'];
	  $talle = $_POST['talle'];

		$query= "SELECT SUM(cantidad) as 'canmat' FROM indumentaria WHERE centro='$centro' AND talle='$talle' AND indumentaria='$indumentaria'"; 
		$result_task = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result_task)) { 
		$canmat= $row['canmat'];
		}

		if ($canmat >= 1 && $canmat >= $cantidad)
		{

		///////////////////////////Se ejecuta la insercion a la tabla taskdm////////////////////////
		  $queryDesc=$conn->query("INSERT INTO entregaindumentaria (indumentaria, tecnico, fechaegre, centro, cantidad, talle) VALUES ('$indumentaria', '$tecnico', '$fechaegre', '$centro', '$cantidad', '$talle')");
		  if ($queryDesc==true)  ////////////////Si se ejecuta con exito se pasa a la actualizacion de la tabla indumentaria/////////////

		  {
		    $queryAsig=$conn->query("UPDATE indumentaria set  cantidad = cantidad - '$cantidad', tecnico = '$tecnico' WHERE centro = '$centro' AND talle='$talle' AND indumentaria = '$indumentaria'  ORDER BY id DESC LIMIT 1");
		  }
		  if ($queryAsig=true)   //////////////Si se ejecuta con exito se envia el mensaje///////////

		  {
		  	
		  /////////////////Mensaje en la variable _SESSION/////////////
		  $_SESSION['card'] = 1;
		  $_SESSION['message'] = "Se le entrego " .$cantidad ." " .$indumentaria ." a " .$tecnico ." del deposito " .$centro ;   ////////////////Mensaje//////////////
		  $_SESSION['message_type'] = 'success';   ////////////////Color///////////
		  header('Location: ../Basico/indumentaria.php'); ///////////////////////Despues enviar a....///////////////////
		  }
		  /////////////////Si la actualizacion de la tabla materiales no se realiza, aparece mensaje////////////////////////////
		    die("Error.");
		 
		}
		else
		{
		  /////////////////Mensaje en la variable _SESSION/////////////
		  $_SESSION['card'] = 1;
		  $_SESSION['message'] = "No hay suficiente " .$indumentaria ." talle " .$talle ." en el deposito de " .$centro .", solo tienes " .$canmat ;   ////////////////Mensaje//////////////
		  $_SESSION['message_type'] = 'danger';   ////////////////Color///////////
		  header('Location: ../Basico/indumentaria.php'); ///////////////////////Despues enviar a....///////////////////
		}
	
	}

	