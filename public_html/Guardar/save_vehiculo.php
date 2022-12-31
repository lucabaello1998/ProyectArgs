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
if($tipo == "Visor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}


$formatos = array('.pdf', '.PDF');

if (isset($_POST['save_auto']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Vehiculos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  if (!$_POST['patente'])
  {
    $patente = "";
  }
  else
  {
    $patente = $_POST['patente'];
  }
  if (!$_POST['auto'])
  {
    $auto = "";
  }
  else
  {
    $auto = $_POST['auto'];
  }
  if (!$_POST['color'])
  {
    $color = "";
  }
  else
  {
    $color = $_POST['color'];
  }
  if (!$_POST['vtv'])
  {
    $vtv = "";
  }
  else
  {
    $vtv = $_POST['vtv'];
  }
  if (!$_POST['seguro'])
  {
    $seguro = "";
  }
  else
  {
    $seguro = $_POST['seguro'];
  }
  $pdf = $_POST['patente'] ."-" .$_POST['auto'] ." " .$_POST['seguro'];

  $nombreArchivo = $_FILES['archivo']['name'];
  $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
  $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
  if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
  {
    if ($_FILES['archivo']['size']<4000000)
    {
      if (move_uploaded_file($nombreTmpArchivo, "../Archivos/vehiculos/$pdf" .".pdf"))
      {
        $pdfpdf = $pdf .".pdf"; //ultima modificacion
        $msg = "El " .$auto .", patente " .$patente ." " .$seguro ." fue subido correctamente"; 
        $msgColor = "success";      
        
        $query = "INSERT INTO vehiculos(patente, auto, color, vtv, seguro, archivo) VALUES ('$patente', '$auto', '$color', '$vtv', '$seguro', '$pdfpdf')";
        $result = mysqli_query($conn, $query);
        if(!$result) 
        {
          $msg ="Error en el servidor, recuerde completar todos los campos.";
          $msgColor = "danger";
        }
      }
      else
      {
        $msg = "Error, intentamente nuevamente";
        $msgColor = "danger";
      }
    }
    else
    {
      $msg = "El archivo que intenta subir es muy pesado";
      $msgColor = "danger";
    }
  }
  else
  {
    $msg = "Formato no permitido.";
    $msgColor = "danger";
  }
}
$_SESSION['card'] = 1;
$_SESSION['message'] = $msg;
$_SESSION['message_type'] = $msgColor;
header('Location: ../Basico/vehiculos.php');

?>
