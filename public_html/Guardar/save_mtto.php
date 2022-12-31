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
if (isset($_POST['save_mtto']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Mantenimineto', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $fecha = $_POST['fecha'];
  
  if (!$_POST['ont_mac'])
  {
    $ont_mac = "";
  }
  else
  {
    $ont_mac = $_POST['ont_mac'];
  }
  if (!$_POST['ont_sn'])
  {
    $ont_sn = "";
  }
  else
  {
    $ont_sn = $_POST['ont_sn'];
  }
  if (!$_POST['stb_mac_uno'])
  {
    $stb_mac_uno = "";
  }
  else
  {
    $stb_mac_uno = $_POST['stb_mac_uno'];
  }
  if (!$_POST['stb_sn_uno'])
  {
    $stb_sn_uno = "";
  }
  else
  {
    $stb_sn_uno = $_POST['stb_sn_uno'];
  }
  if (!$_POST['stb_mac_dos'])
  {
    $stb_mac_dos = "";
  }
  else
  {
    $stb_mac_dos = $_POST['stb_mac_dos'];
  }
  if (!$_POST['stb_sn_dos'])
  {
    $stb_sn_dos = "";
  }
  else
  {
    $stb_sn_dos = $_POST['stb_sn_dos'];
  }
  if (!$_POST['stb_mac_tres'])
  {
    $stb_mac_tres = "";
  }
  else
  {
    $stb_mac_tres = $_POST['stb_mac_tres'];
  }
  if (!$_POST['stb_sn_tres'])
  {
    $stb_sn_tres = "";
  }
  else
  {
    $stb_sn_tres = $_POST['stb_sn_tres'];
  }
  $motivo = $_POST['motivo'];
  $obs = $_POST['obs'];


  $query = "INSERT INTO mtto(tecnico, ot, direccion, zona, fecha, ont_mac, ont_sn, stb_mac_uno, stb_sn_uno, stb_mac_dos, stb_sn_dos, stb_mac_tres, stb_sn_tres, motivo, obs) VALUES ('$tecnico', '$ot', '$direccion', '$zona', '$fecha', '$ont_mac', '$ont_sn', '$stb_mac_uno', '$stb_sn_uno', '$stb_mac_dos', '$stb_sn_dos', '$stb_mac_tres', '$stb_sn_tres', '$motivo', '$obs')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El mantenimiento " .$ot ." de " .$tecnico ." fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/mtto.php');

}

?>