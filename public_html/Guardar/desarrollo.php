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
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['save_dev']))
{
  $formatos = array('.jpg', '.jpeg', '.png');
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Desarrollo', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $titulo = $_POST['titulo'];
  $fecha = $_POST['fecha'];
  $notas = $_POST['notas'];
  $fase = $_POST['fase'];
  $version_dev = $_POST['version_dev'];

  /////////////IMAGEN 1////////////////////
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $token_movi ."-" ."img1";
      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/desarrollo/" .$imagen1 .$ext1))
          {   
              $imagenpri = $imagen1 .$ext1;
              $msg1 = "1";
          }
          else
          {
            $msg1 = "E-I"; ///servidor
          }
        }
        else
        {
          $msg1 = "E-P"; ///Tamaño
        }
      }
      else
      {
        $msg1 = "E-F"; ///Fomrato
      }
    }
    else
    {
      $imagenpri = "";
      $msg1 = '';
    }
  /////////////IMAGEN 1////////////////////

  /////////////IMAGEN 2//////////////////// 
    if ($_FILES['imagen2']['name'] != null)
    {     
      $imagen2 = $token_movi ."-" ."img2";
      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/desarrollo/" .$imagen2 .$ext2))
          {   
              $imagenseg = $imagen2 .$ext2;
              $msg2 = "1";
          }
          else
          {
            $msg2 = "E-I";
          }
        }
        else
        {
          $msg2 = "E-P";
        }
      }
      else
      {
        $msg2 = "E-F";
      }
    }
    else
    {
      $imagenseg = "";
      $msg2 = '';
    }
  /////////////IMAGEN 2////////////////////

  /////////////IMAGEN 3//////////////////// 
    if ($_FILES['imagen3']['name'] != null)
    {     
      $imagen3 = $token_movi ."-" ."img3";
      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../Archivos/desarrollo/" .$imagen3 .$ext3))
          {   
              $imagenter = $imagen3 .$ext3;
              $msg3 = "1";
          }
          else
          {
            $msg3 = "E-I";
          }
        }
        else
        {
          $msg3 = "E-P";
        }
      }
      else
      {
        $msg3 = "E-F";
      }
    }
    else
    {
      $imagenter = "";
      $msg3 = '';
    }
  /////////////IMAGEN 3////////////////////

  /////////////IMAGEN 4////////////////////
    if ($_FILES['imagen4']['name'] != null)
    {     
      $imagen4 = $token_movi ."-" ."img4";
      $nombreArchivo4 = $_FILES['imagen4']['name'];
      $nombreTmpArchivo4 = $_FILES['imagen4']['tmp_name'];
      $ext4 = substr($nombreArchivo4, strrpos($nombreArchivo4, '.'));
      if (in_array($ext4, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen4']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo4, "../Archivos/desarrollo/" .$imagen4 .$ext4))
          {   
              $imagencuar = $imagen4 .$ext4;
              $msg4 = "1";
          }
          else
          {
            $msg4 = "E-I";
          }
        }
        else
        {
          $msg4 = "E-P";
        }
      }
      else
      {
        $msg4 = "E-F";
      }
    }
    else
    {
      $imagencuar = "";
      $msg4 = '';
    }
  /////////////IMAGEN 4////////////////////
  $imagenes = $msg1 + $msg2 + $msg3 + $msg4;

  $r = mysqli_query($conn, "INSERT INTO desarrollo(token, quien, titulo, fecha, notas, imagenpri, imagenseg, imagenter, imagencuar, fase, version_dev) VALUES ('$token_movi', '$quien_notas', '$titulo', '$fecha', '$notas', '$imagenpri', '$imagenseg', '$imagenter', '$imagencuar', '$fase', '$version_dev')");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    if($imagenes > 0)
    {
      $titulo_toast = "Guardado";
      $msj_toast = "El desarrollo fue guardado correctamente con " .$imagenes ." imagenes";
      $color_toast = "success";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "El desarrollo fue guardado correctamente";
      $color_toast = "success";
    }
    /* MSJ */
      $link = '/Basico/desarrollo.php';
      $icono="https://argentseal.online/images/icon_512.png";
      
      $result_msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us = 'Administrador'");
      while($row = mysqli_fetch_array($result_msj))
      {
        $firebase = $row['firebase'];
        $field=array(
            'data'=>array(
            'notification'=>array(
            'title'=>'Nueva mejora (' .$titulo .')',
            'body'=> $notas,
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
      }
    /* MSJ */
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/desarrollo.php');
}
?>