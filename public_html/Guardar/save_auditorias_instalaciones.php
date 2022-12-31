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
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

if (isset($_POST['save_auditoria_instalaciones']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Auditoria instalaciones', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $supervisor = $nombre ." " .$apellido ;
  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $ot = $_POST['ot'];
  $instalacion_externa = $_POST['instalacion_externa'];
  $foto_nomenclador = $_POST['foto_nomenclador'];
  $cadena = $_POST['cadena'];
  $altura_acometida = $_POST['altura_acometida'];
  $punto_retencion = $_POST['punto_retencion'];
  $curva_goteo = $_POST['curva_goteo'];
  $ingreso_domicilio = $_POST['ingreso_domicilio'];
  $engrampado_interior = $_POST['engrampado_interior'];
  $ont = $_POST['ont'];
  $residuos = $_POST['residuos'];
  $trato_cliente = $_POST['trato_cliente'];
  $uso_herramientas = $_POST['uso_herramientas'];
  $epp = $_POST['epp'];
  $obs = $_POST['obs'];



  


  $query = "INSERT INTO auditoria_instalaciones(supervisor, tecnico, fecha, ot, instalacion_externa, foto_nomenclador, cadena, altura_acometida, punto_retencion, curva_goteo, ingreso_domicilio, engrampado_interior, ont, residuos, trato_cliente, uso_herramientas, epp, obs) VALUES ('$supervisor', '$tecnico', '$fecha', '$ot', '$instalacion_externa', '$foto_nomenclador', '$cadena', '$altura_acometida', '$punto_retencion', '$curva_goteo', '$ingreso_domicilio', '$engrampado_interior', '$ont', '$residuos', '$trato_cliente', '$uso_herramientas', '$epp', '$obs')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    $msj = "Error en el servidor";
    $color = "danger";
  }else{
  $msj = "La auditoria de instalacion de " .$tecnico ." fue guardada.";
  $color = "success";
  }
}
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias_instalaciones.php');
?>
