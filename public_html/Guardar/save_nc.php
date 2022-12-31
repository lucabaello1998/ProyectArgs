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

$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien = $nombre .' ' . $apellido;
$relevador = strtoupper(substr($nombre, 0, 1)) .strtoupper(substr($apellido, 0, 1));

function generarCodigo($longitud)
{
  $key = '';
  $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $max = strlen($pattern)-1;
  for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
  return $key;
}

$idem = generarCodigo(6);
$identificador = "NC" .$relevador ."-" .$idem;

$msg = '';
$msgColor = '';
$msg1 = '';
$msg2 = '';
$msg3 = '';
$formatos = array('.jpg', '.jpeg', '.png');


if (isset($_POST['save_nc'])) {
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'No conformidad', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $supervisor = $_POST['supervisor'];
  $id_nc = $_POST['id_nc'];
  $obs = $_POST['obs'];

  /////////////IMAGEN 1////////////////////
    
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $identificador ."-" ."imagen1";
      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/no_conformidad/" .$imagen1 .$ext1))
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
      $imagen2 = $identificador ."-" ."imagen2";
      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/no_conformidad/" .$imagen2 .$ext2))
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
      $imagen3 = $identificador ."-" ."imagen3";
      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../Archivos/no_conformidad/" .$imagen3 .$ext3))
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

  $imagenes = $msg1 + $msg2 + $msg3;

  $query = "INSERT INTO no_conformidades(quien, tecnico, fecha, id_nc, supervisor, problema, imagenpri, imagenseg, imagenter) VALUES ('$quien','$tecnico', '$fecha', '$id_nc', '$supervisor', '$obs', '$imagenpri', '$imagenseg', '$imagenter')";
  $result = mysqli_query($conn, $query);
  if(!$result) 
  {
    $msg ="Error en el servidor";
    $msgColor = "danger";
  }
  else
  {
    $msg = "La no conformidad de " .$tecnico ." fue cargado correctamente con " .$imagenes ." imagenes" ;
    $msgColor = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../Basico/no_conformidad.php');

}

?>
