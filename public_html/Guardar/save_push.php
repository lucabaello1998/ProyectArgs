<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
$quien_notas = $nombre_us .' ' .$apellido_us;
if($tipo_us == "Administrador") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

/* MOVIMIENTO INDIVIDUAL */
  $token_movi = uniqid();
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
  $hoy_movi = date("Y-m-j");
  mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Enviado', 'Notificacion Push', '$hoy_movi', '$tipo_us', '$zona_us')");
/* MOVIMIENTO INDIVIDUAL */

if (isset($_POST['guardar']))
{
	$mensaje = Reemplazo($_POST['mensaje']);
	$link = 'https://argentseal.online/inicio_administrador.php';
	$tokenId=$_POST['token'];
	$icono="https://argentseal.online/images/icon_512.png";

	$msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE token = '$tokenId' LIMIT 1");
	if (mysqli_num_rows($msj) == 1)
	{
		$row = mysqli_fetch_array($msj);
		$nombreold = $row['nombre'];
		$apellidoold = $row['apellido'];
		$firebase = $row['firebase'];  
	}

	$field=array(
			'data'=>array(
			'notification'=>array(
			'title'=>$quien_notas .' dice...',
			'body'=>$mensaje,
			'icon'=>$icono,
			'link'=>$link
			)
		),
	'to'=>$firebase
	);
	$fields=json_encode($field);

	$header=array(
    
		'Authorization: key=AAAAsHb0r4c:APA91bFnf2A8l7nYJ1ajJuQSy6SJHjiGcHFU3fzw2gHyLbu9C5dYfl7n7fQ4n8LOVr8y2vg2P65O0g8wuo7S-DHZkGgxF_m2DEh9vNMYsP7_83Qb4DNj_Rgj_e0I9xuYkjAGYiGHjQhY',
		'Content-Type: application/json'
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

	$result=curl_exec($ch);
	curl_close($ch);
	$_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = 'Enviado';
  $_SESSION['mensaje_toast'] = 'El mensaje se envio correctamente.';
  $_SESSION['color_toast'] = 'success';
  header('Location: ../Basico/push.php');
}
?>