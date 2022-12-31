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

if (isset($_POST['menos']))
  {if (isset($_POST['link']))
    {
      $ultima_fecha = $_POST['ultima_fecha'];
      $encriptado = date ('Y-m', strtotime($ultima_fecha."- 1 month"));
      $fechaa = base64_encode($encriptado);
      header('Location: ' .$_POST['link'] .'?mes='.$fechaa);
    }
    else
    {
      $menos = $_POST['ultima_fecha'];
      $encriptado = date ('Y-m', strtotime($menos."- 1 month"));
      $_SESSION['fecha'] = base64_encode($encriptado);
      echo '<script> window.history.back(); </script>';
    }
  
}

if (isset($_POST['mas']))
{
  if (isset($_POST['link']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $encriptado = date ('Y-m', strtotime($ultima_fecha."+ 1 month"));
    $fechaa = base64_encode($encriptado);
    header('Location: ' .$_POST['link'] .'?mes='.$fechaa);
  }
  else
  {
    $mas = $_POST['ultima_fecha'];
    $encriptado = date ('Y-m', strtotime($mas."+ 1 month"));
    $_SESSION['fecha'] = base64_encode($encriptado);
    echo '<script> window.history.back(); </script>';
  }
  
}
?>