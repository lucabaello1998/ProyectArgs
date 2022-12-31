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

if (isset($_POST['save_tecnicos'])) {
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Tecnicos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = uniqid();
  $tecnico = Renombre($_POST['tecnico']);
  $dni = $_POST['dni'];
  if (!$_POST['chomba'])
  {
    $chomba = "";
  }
  else
  {
    $chomba = $_POST['chomba'];
  }
  if (!$_POST['pantalon'])
  {
    $pantalon = "";
  }
  else
  {
    $pantalon = $_POST['pantalon'];
  }
  if (!$_POST['zapato'])
  {
    $zapato = "";
  }
  else
  {
    $zapato = $_POST['zapato'];
  }
  $ingreso = $_POST['ingreso'];

  if (!$_POST['modelo'])
  {
    $modelo = "";
  }
  else
  {
    $modelo = $_POST['modelo'];
  }
  if (!$_POST['sn'])
  {
    $sn = "";
  }
  else
  {
    $sn = $_POST['sn'];
  }
  if (!$_POST['flota'])
  {
    $flota = "";
  }
  else
  {
    $flota = $_POST['flota'];
  }
  if (!$_POST['tel'])
  {
    $tel = "";
  }
  else
  {
    $tel = $_POST['tel'];
  }
  if (!$_POST['mail'])
  {
    $mail = "";
  }
  else
  {
    $mail = $_POST['mail'];
  }
  if (!$_POST['tusu'])
  {
    $tusu = "";
  }
  else
  {
    $tusu = $_POST['tusu'];
  }
  if (!$_POST['tcon'])
  {
    $tcon = "";
  }
  else
  {
    $tcon = $_POST['tcon'];
  }
  if (!$_POST['sgtusu'])
  {
    $sgtusu = "";
  }
  else
  {
    $sgtusu = $_POST['sgtusu'];
  }
  if (!$_POST['sgtcon'])
  {
    $sgtcon = "";
  }
  else
  {
    $sgtcon = $_POST['sgtcon'];
  }
  $tipo = $_POST['tipo'];
  $zona = $_POST['zona'];
  $deposito = $_POST['deposito'];

  $result = mysqli_query($conn, "INSERT INTO tecnicos(token, tecnico, dni, chomba, pantalon, zapato, ingreso, modelo, sn, flota, tel, mail, tusu, tcon, sgtusu, sgtcon, tipo, zona, deposito) VALUES ( '$token', '$tecnico', '$dni', '$chomba', '$pantalon', '$zapato', '$ingreso', '$modelo', '$sn', '$flota', '$tel', '$mail', '$tusu', '$tcon', '$sgtusu', '$sgtcon', '$tipo', '$zona', '$deposito')");
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "Los datos de " .$tecnico ." fueron guardados correctamente.";
    $color_toast = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;

  if($tipo == 'Tecnico')
  {
    /* MSJ */
      $link = '/Basico/datos.php';
      $icono="https://argentseal.online/images/icon_512.png";

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = 'Damian' AND apellido = 'Duarte' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Nuevo tecnico',
          'body'=>'Fue agregado el tecnico: ' .$tecnico,
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
    /* MSJ */
  }
  header('Location: ../Basico/datos.php');
}
?>