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
  header("location: ../index.php");   /////Visor - Deposito/////
}

$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
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
$identificador = "DES" .$relevador ."-" .$idem;

$msg = '';
$msgColor = '';
$msg1 = '';
$msg2 = '';

$formatos = array('.jpg', '.jpeg', '.png');


if (isset($_POST['save_descuentos']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Penalizaciones', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $ot = $_POST['ot'];
  $falla = $_POST['falla'];
  $obs = $_POST['obs'];
  $monto = $_POST['monto'];

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
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/penalizaciones/" .$imagen1 .$ext1))
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
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/penalizaciones/" .$imagen2 .$ext2))
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

  $imagenes = $msg1 + $msg2;

  $query = "INSERT INTO descuentos(identificador, tecnico, fecha, ot, falla, monto, obs, imagenpri, imagenseg) VALUES ('$identificador','$tecnico', '$fecha', '$ot', '$falla', '$monto', '$obs', '$imagenpri', '$imagenseg')";
  $result = mysqli_query($conn, $query);
  if(!$result) 
  {
    $msg ="Error en el servidor";
    $msgColor = "danger";
  }
  else
  {
    $msg = "La penalizacion de " .$tecnico ." en la OT " .$ot ." fue cargado correctamente con " .$imagenes ." imagenes" ;
    $msgColor = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../Basico/descuentos.php');

}

?>
