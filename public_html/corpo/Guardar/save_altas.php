<?php
include('../../db.php');
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
  header("location: ../inicio.php");
}




if (isset($_POST['save_altas'])) {
  $ct = $_POST['CT'];
  $fecha = $_POST['FECHA'];
  $tarea = $_POST['TAREA'];
  $cliente = $_POST['CLIENTE'];
  $orden = $_POST['ORDEN'];
  $enlace = $_POST['ENLACE'];
  $asignado = $_POST['ASIGNADO'];
  $certificacion = $_POST['CERTIFICACION'];
  $link_sytex = $_POST['LINK_SYTEX'];

  $query = "INSERT INTO corpo(CT, FECHA, TAREA, CLIENTE, ORDEN, ENLACE, ASIGNADO, CERTIFICACION, LINK_SYTEX) VALUES ('$ct', '$fecha', '$tarea', '$cliente', '$orden', '$enlace', '$asignado', '$certificacion ', '$link_sytex')";
  //EJEMPLO DE FORMATO SQL "INSERT INTO corpo(CT, FECHA, TAREA, CLIENTE, ORDEN, ENLACE, ASIGNADO, CERTIFICACION, LINK_SYTEX) VALUES ('1', '7/7/2022', 'BAHA', 'COMPARCITA', '6010151518', '455263658', 'RUPERTO', 'UPS-58996655 ', 'https://c256.ferozo.com:2092')"
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del tecnico  fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../corpo/Basico/alta.php');

}