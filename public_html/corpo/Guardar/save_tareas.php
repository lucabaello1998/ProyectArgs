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




if (isset($_POST['save_tareas'])) {
  $id = $_POST['ID'];
  $F_Asignado = $_POST['F_Asignado'];
  $estado = $_POST['estado'];
  $orden = $_POST['orden'];
  $enlace = $_POST['enlace'];
  $asignado_por = $_POST['asignado_por'];
  $cliente = $_POST['cliente'];
  $referente = $_POST['referente'];
  $domicilio = $_POST['domicilio'];
  $celular = $_POST['celular'];
  $email_contacto = $_POST['email_contacto'];
  $imagen_1 = $_POST['imagen_1'];
  $imagen_2 = $_POST['imagen_2'];
  $imagen_3 = $_POST['imagen_3'];
  $imagen_4 = $_POST['imagen_4'];
  $imagen_5 = $_POST['imagen_5'];
  $imagen_6 = $_POST['imagen_6'];
  
  
  $query = "INSERT INTO corpo_tareas(F_Asignado, estado, orden, enlace, asignado_por, cliente, referente, domicilio, celular, email_contacto) VALUES ('$F_Asignado', '$estado', '$orden', '$enlace', '$asignado_por', '$cliente', '$referente', '$domicilio', '$celular', '$email_contacto')";  
  
  //EJEMPLO DE FORMATO SQL "INSERT INTO `corpo_tareas`(`F_Asignado`, `orden`, `enlace`, `asignado_por`, `cliente`, `referente`, `domicilio`, `celular`, `email_contacto`) VALUES ('2022-07-22', '202255', '225588', 'mati', 'roterte', 'juan carlos', 'Nazar 373', '1122558844', 'buenis@jfur.com')"
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia del tecnico  fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../../corpo/Basico/tareas.php');
}