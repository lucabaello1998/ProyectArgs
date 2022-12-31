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




if (isset($_POST['save_bajas'])) {
  $id = $_POST['ID'];
  $F_Asignado = $_POST['F_Asignado'];
  $orden = $_POST['orden'];
  $enlace = $_POST['enlace'];
  $asignado_por = $_POST['asignado_por'];
  $cliente = $_POST['cliente'];
  $referente = $_POST['referente'];
  $domicilio = $_POST['domicilio'];
  $celular = $_POST['celular'];
  $email_contacto = $_POST['email_contacto'];

  $query = "SELECT * FROM corpo WHERE ID = '$ID'";
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del tecnico  fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../corpo/Basico/alta.php');

}