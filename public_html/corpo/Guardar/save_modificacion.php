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




if (isset($_POST['save_modificacion'])) {
  $id = $_POST['ID'];
  $ct = $_POST['CT'];
  $fecha = $_POST['FECHA'];
  $tarea = $_POST['TAREA'];
  $cliente = $_POST['CLIENTE'];
  $orden = $_POST['ORDEN'];
  $enlace = $_POST['ENLACE'];
  $asignado = $_POST['ASIGNADO'];
  $certificacion = $_POST['CERTIFICACION'];
  $link_sytex = $_POST['LINK_SYTEX'];

  $query = "UPDATE corpo SET 'ID'= $id,'CT'= $ct,'FECHA'= $fecha,'TAREA'= $tarea,'CLIENTE'= $cliente,'ORDEN'= $orden,'ENLACE'= $enlace,'ASIGNADO'= $asignado, 'CERTIFICACION'= $certificacion, 'LINK_SYTEX'= '$link_sytex' WHERE 1)";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La modificacion fue guardada.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../corpo/Basico/modificacion.php');

}