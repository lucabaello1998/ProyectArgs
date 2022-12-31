<?php
include('../../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($tipo_us == "Tecnico") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

if($tipo_us == 'Tecnico')
{
  $quien_consultas = $quien_notas;
  $zona_tarea = $zona_us;
}
else
{
  $quien_consultas = $_SESSION['new_tec'];
  $consul_zona = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$quien_consultas'");
  while($row = mysqli_fetch_assoc($consul_zona))
  {
    $zona_tarea = $row['zona'];
  }
}

if(isset($_POST['save_orden']))
{
  $token_movi = uniqid();
  $formatos = array('.jpg', '.jpeg', '.png');
  $latitud = '';
  $longitud = '';
  $ot = $_POST['ot'];
  $fecha = $_POST['fecha'];
  $tipo_tarea = $_POST['tipo_tarea'];
  $obs = $_POST['obs'];

  /////////////IMAGEN 1////////////////////
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $token_movi ."-" ."equipos";
      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos))
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../../Archivos/cierre_tarea/exitoso/" .$imagen1 .$ext1))
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
      $imagen2 = $token_movi ."-" ."engrampado";
      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos))
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../../Archivos/cierre_tarea/exitoso/" .$imagen2 .$ext2))
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
      $imagen3 = $token_movi ."-" ."cometida";
      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos))
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../../Archivos/cierre_tarea/exitoso/" .$imagen3 .$ext3))
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
      $imagen4 = $token_movi ."-" ."fallida";
      $nombreArchivo4 = $_FILES['imagen4']['name'];
      $nombreTmpArchivo4 = $_FILES['imagen4']['tmp_name'];
      $ext4 = substr($nombreArchivo4, strrpos($nombreArchivo4, '.'));
      if (in_array($ext4, $formatos))
      {
        if($_FILES['imagen4']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo4, "../../Archivos/cierre_tarea/fallido/" .$imagen4 .$ext4))
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

  /* MOVIMIENTO INDIVIDUAL */
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $zona_us = $_SESSION['zona'];
    $movimiento = 'Cierre de tarea';
    $obs_movi = 'Se registro la tarea ' .$ot .' como ' .$tipo_tarea .' con ' .$imagenes .' imagenes';
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    mysqli_query($conn, "INSERT INTO movimiento_tecnico(token, quien, movimiento, zona, obs, latitud, longitud) VALUES ('$token_movi', '$quien_notas', '$movimiento', '$zona_us', '$obs_movi', '$latitud', '$longitud')");
  /* MOVIMIENTO INDIVIDUAL */

  if($tipo_tarea == 'Exitoso')
  {
    $cierre = mysqli_query($conn, "INSERT INTO cierre_tarea(token, quien, ot, tipo_tarea, fecha, zona, obs, imagenpri, imagenseg, imagenter, tecnico)VALUES('$token_movi', '$quien_notas', '$ot', '$tipo_tarea', '$fecha', '$zona_tarea', '$obs', '$imagenpri', '$imagenseg', '$imagenter', '$quien_consultas')");
    if(!$cierre)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al guardar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La tarea " .$ot ." fue registrada correctamente.";
      $color_toast = "success";
    }
  }
  elseif($tipo_tarea == 'Fallido')
  {
    $fallo = mysqli_query($conn, "INSERT INTO cierre_tarea(token, quien, ot, tipo_tarea, fecha, zona, obs, imagenpri, tecnico)VALUES('$token_movi', '$quien_notas', '$ot', '$tipo_tarea', '$fecha', '$zona_tarea', '$obs', '$imagencuar', '$quien_consultas')");
    if(!$fallo)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al guardar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La tarea " .$ot ." fue registrada correctamente.";
      $color_toast = "success";
    }
  }
  
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../index.php');
}
?>