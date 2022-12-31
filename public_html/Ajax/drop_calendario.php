<?php
include("../db.php");
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien_notas = $nombre .' ' .$apellido;
if($_POST['tarea'] == 'nueva')
{
  $title = $_POST['title'];
  $start = $_POST['start'];
  $end = $_POST['end'];
  $token = uniqid();
  $a_quien = $_POST['a_quien'];
  $tecnico = $_POST['tecnico'];
  $_SESSION['show'] = $title;
  $nuevo = mysqli_query($conn, "INSERT INTO calendario (token, quien, a_quien, tecnico, titulo, inicio, fin, color, tarea) VALUES ('$token', '$quien_notas', '$a_quien', '$tecnico', '$title', '$start', '$end', '#FFAA16', '$title')");
  if ($nuevo)
  {
    /* MSJ */      
      $nomnom = explode(" ", $a_quien);
      $nombre_nota = $nomnom[0];
      $apellido_nota = $nomnom[1];

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Nueva tarea (' .$title .')',
          'body'=> 'Tecnico: ' .$tecnico,
          'icon'=> "https://argentseal.online/images/icon_512.png",
          'link'=> '/Basico/b_ver_calendario.php?token=' .$token,
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
    return true;
  }
  else
  {
    return false;
  }
}
if($_POST['tarea'] == 'tamanio')
{
  $start = $_POST['start'];
  $end = $_POST['end'];
  $token = $_POST['token'];
  $tamanio = mysqli_query($conn, "UPDATE calendario set  inicio = '$start', fin = '$end' WHERE token = '$token'");
  if ($tamanio)
  {
    return true;
  }
  else
  {
    return false;
  }
  
}
if($_POST['tarea'] == 'mover')
{
  $start = $_POST['start'];
  $end = $_POST['end'];
  $token = $_POST['token'];
  $mover = mysqli_query($conn, "UPDATE calendario set  inicio = '$start', fin = '$end' WHERE token = '$token'");
  if ($mover)
  {
    return true;
  }
  else
  {
    return false;
  }
  
}