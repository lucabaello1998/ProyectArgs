<?php
include("../db.php");
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

if (isset($_POST['actualizar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token,
    quien,
    movimiento,
    pag,
    inicio,
    tipo,
    zona) VALUES ('$token_movi',
    '$quien_notas',
    'Editado',
    'cierre',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id= $_POST['id'];
  $ot = $_POST['ot'];
  $fecha = $_POST['fecha'];
  $zona = $_POST['zona'];
  $obs = $_POST['obs'];

  $re = mysqli_query($conn, "UPDATE cierre_tarea set ot = '$ot', fecha = '$fecha', zona = '$zona', obs = '$obs' WHERE id = '$id'");
  if(!$re)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al actualizar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Actualizado";
      $msj_toast = "La orden " .$ot ." de fue actualizada correctamente";
      $color_toast = "warning";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/cierres_tareas.php');
}
?>
