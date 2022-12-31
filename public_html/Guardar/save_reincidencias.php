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
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['save_reincidencias']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Reincidencias', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $tecnico = $_POST['tecnico'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $fechaint = $_POST['fechaint'];
  $ot = $_POST['ot'];
  $nim = $_POST['nim'];
  $fecharep = $_POST['fecharep'];
  $otdos = $_POST['otdos'];
  $abonado = $_POST['abonado'];
  $primercierre = $_POST['primercierre'];
  $motivo = $_POST['motivo'];  
  $primeranota = $_POST['primeranota'];


  $query = "INSERT INTO reincidencias(tecnico, ot, direccion, zona, fechaint, fecharep, otdos, abonado, primercierre, motivo, primeranota, nim) VALUES ('$tecnico', '$ot', '$direccion', '$zona', '$fechaint', '$fecharep', '$otdos', '$abonado', '$primercierre', '$motivo', '$primeranota', '$nim')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
    echo $tecnico ."-" .$ot ."-" .$direccion ."-" .$zona ."-" .$fechaint ."-" .$fecharep ."-" .$otdos ."-" .$abonado ."-" .$primercierre ."-" .$motivo ."-" .$primeranota;
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La reincidencias " .$ot ." de " .$tecnico ." fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/reincidencias.php');

}

if (isset($_POST['menos']))
{
  $ultima_fecha = $_POST['ultima_fecha'];
  $encriptado = date ('Y-m', strtotime($ultima_fecha."- 1 month"));
  $fechaa = base64_encode($encriptado);
  header('Location: ../Basico/reincidencias.php?mes='.$fechaa);
}

if (isset($_POST['mas']))
{
  $ultima_fecha = $_POST['ultima_fecha'];
  $encriptado = date ('Y-m', strtotime($ultima_fecha."+ 1 month"));
  $fechaa = base64_encode($encriptado);
  header('Location: ../Basico/reincidencias.php?mes='.$fechaa);
}
?>
