<?php include('../db.php');
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
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['save_asistenciaindividual'])) {

  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Asistencia individual ayudantes', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $nombre = $_POST['tecnico'];
  $fechaa = $_POST['fechaa'];
  $horaa = $_POST['horaa'];
  $diaa = $_POST['diaa'];
  
  


  $query = "INSERT INTO asistenciaayudantes(nombre, fecha, hora, dia) VALUES ('$nombre', '$fechaa', '$horaa', '$diaa')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del tecnico " .$nombre ." fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/ayudantes.php');

}

?>
