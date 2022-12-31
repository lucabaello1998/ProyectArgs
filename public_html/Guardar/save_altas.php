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
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
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
  mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Altas', '$hoy_movi', '$tipo_us', '$zona_us')");
/* MOVIMIENTO INDIVIDUAL */

if (isset($_POST['save_altas']))
{
  $token = uniqid();
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $calendario = $_POST['calendario'];
  $mac_ont = $_POST['mac_ont'];
  $sn_ont = $_POST['sn_ont'];
  $mac_uno_stb = $_POST['mac_uno_stb'];
  $sn_uno_stb = $_POST['sn_uno_stb'];
  $mac_dos_stb = $_POST['mac_dos_stb'];
  $sn_dos_stb = $_POST['sn_dos_stb'];
  $mac_tres_stb = $_POST['mac_tres_stb'];
  $sn_tres_stb = $_POST['sn_tres_stb'];

  $ap_uno_mac = $_POST['ap_uno_mac'];
  $ap_uno_sn = $_POST['ap_uno_sn'];
  $ap_dos_mac = $_POST['ap_dos_mac'];
  $ap_dos_sn = $_POST['ap_dos_sn'];
  $ap_tres_mac = $_POST['ap_tres_mac'];
  $ap_tres_sn = $_POST['ap_tres_sn'];
  $completo = 'SI';

  $r = mysqli_query($conn, "INSERT INTO altas(token, quien, tecnico, ot, direccion, zona, calendario, mac_ont, sn_ont, mac_uno_stb, sn_uno_stb, mac_dos_stb, sn_dos_stb, mac_tres_stb, sn_tres_stb, ap_uno_mac, ap_uno_sn, ap_dos_mac, ap_dos_sn, ap_tres_mac, ap_tres_sn, completo) VALUES ('$token', '$quien_notas','$tecnico', '$ot', '$direccion', '$zona', '$calendario', '$mac_ont', '$sn_ont', '$mac_uno_stb', '$sn_uno_stb', '$mac_dos_stb', '$sn_dos_stb', '$mac_tres_stb', '$sn_tres_stb', '$ap_uno_mac', '$ap_uno_sn', '$ap_dos_mac', '$ap_dos_sn', '$ap_tres_mac', '$ap_tres_sn', '$completo')");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La orden " .$ot ." de " .$tecnico ." fue guardada correctamente.";
    $color_toast = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/altas.php');
}
?>