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
  header("location: ../index.php");   /////Visor/////
}
/////////////Consulta a las 2 tablas (taskas y descargamaterial)//////////////////////
$queryDescarga = $conn->query("SELECT tecnico, fecha, mat1, mat2, mat3 FROM descargamaterial");
$queryAsignacion = $conn->query("SELECT tecnico, fecha, mat1, mat2, mat3 FROM taskas");

if (isset($_POST['save_descargamaterial']))     /////////Si se presiona el boton "save_descargamaterial"///////////
{
///////////////////Conversion de variables////////////////////
  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha1'];
  $ot = $_POST['ot'];
  $mat1 = $_POST['mat1'];
  $mat2 = $_POST['mat2'];
  $mat3 = $_POST['mat3'];

///////////////////////////Se ejecuta la insercion a la tabla descargamaterial////////////////////////
  $queryDesc=$conn->query("INSERT INTO descargamaterial (tecnico, fecha, ot, mat1, mat2, mat3) VALUES ('$tecnico', '$fecha', '$ot', '$mat1', '$mat2', '$mat3')");
  if ($queryDesc==true)  ////////////////Si se ejecuta con exito se pasa a la actualizacion de la tabla taskas/////////////

  {
    $queryAsig=$conn->query("UPDATE asignacion set mat1 = mat1 - '$mat1', mat2 = mat2 - '$mat2', mat3 = mat3 - '$mat3' WHERE fecha = '$fecha' AND tecnico = '$tecnico'");
  }
  if ($queryAsig=true)   //////////////Si se ejecuta con exito se envia el mensaje///////////

  {
  /////////////////Mensaje en la variable _SESSION/////////////
  $_SESSION['card'] = 1;
  $_SESSION['message'] = 'Materiales descargados';   ////////////////Mensaje//////////////
  $_SESSION['message_type'] = 'success';   ////////////////Color///////////
  header('Location: ../Basico/asignacion_materiales.php'); ///////////////////////Despues enviar a....///////////////////
  }
  /////////////////Si la actualizacion de la tabla taskas no se realiza, aparece mensaje////////////////////////////
    die("Query Failed.");
 
}
?>




