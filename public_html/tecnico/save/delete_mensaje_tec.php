<?php
include('../../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: /index.php");
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
if($tipo_us == "Tecnico") { $usu = 1; }
if($usu != 1)
{
  header("location: /index.php");
}

if (isset($_POST['cerrar']))
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
    'Cierre',
    'Chat',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token_sesion= $_POST['token_sesion'];

  $re = mysqli_query($conn, "UPDATE mensajes_tec set estado = 'Cerrado' WHERE token_sesion = '$token_sesion'");
  if(!$re)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al cerrar el chat";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Cerrado";
      $msj_toast = "El chat fue cerrado correctamente";
      $color_toast = "success";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
  header('Location: ../basic/mensajes.php');
}
?>