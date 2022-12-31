<?php
include('../db.php');
date_default_timezone_set("America/Argentina/Buenos_Aires");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['save_garantias']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Garantias', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $fechaint = $_POST['fechaint'];
  $fecharep = $_POST['fecharep'];
  $coment1 = rtrim($_POST['coment']);
  $coment = ltrim($coment1);
  $obs = $_POST['obs'];
  $nota_cliente = $_POST['nota_cliente'];
  $query = "INSERT INTO garantias(tecnico, ot, direccion, zona, fechaint, fecharep, coment, obs, nota_cliente) VALUES ('$tecnico', '$ot', '$direccion', '$zona', '$fechaint', '$fecharep', '$coment', '$obs', '$nota_cliente')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La garantia " .$ot ." de " .$tecnico ." fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/garantias.php');

}

?>
