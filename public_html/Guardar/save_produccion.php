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

if (isset($_POST['save_produccion']))
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
    'Guardado',
    'Produccion',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $dia = $_POST['dia'];
  $horadep = $_POST['horadep'];
  $horatarea = $_POST['horatarea'];
  $dosplay = $_POST['dosplay'];
  $tresplay = $_POST['tresplay'];
  $stb = $_POST['stb'];
  $mudanza = $_POST['mudanza'];

  $tcumplida = $dosplay + $tresplay + $mudanza;  

  $bajas = $_POST['bajas'];
  $bajatec = $_POST['bajatec'];
  $garantec = $_POST['garantec'];
  $garancom = $_POST['garancom'];
  $fin = $_POST['fin'];
  $zona = $_POST['zona'];
  $obs = $_POST['obs'];
  $baja_desmonte = $_POST['baja_desmonte'];
  $mtto_int = $_POST['mtto_int'];
  $mtto_ext = $_POST['mtto_ext'];
  $mtto_reaco = $_POST['mtto_reaco'];

  $tareasmtto = $mtto_int + $mtto_ext + $mtto_reaco;

  $result = mysqli_query($conn, "INSERT INTO produccion(tecnico, fecha, dia, horadep, horatarea, dosplay, tresplay, stb, mudanza, tcumplida, tareasmtto, bajas, bajatec, garantec, garancom, fin, zona, obs, baja_desmonte, mtto_int, mtto_ext, mtto_reaco) VALUES ('$tecnico', '$fecha', '$dia', '$horadep', '$horatarea', '$dosplay', '$tresplay', '$stb', '$mudanza', '$tcumplida', $tareasmtto, '$bajas', '$bajatec', '$garantec', '$garancom', '$fin', '$zona', '$obs', '$baja_desmonte', '$mtto_int', '$mtto_ext', '$mtto_reaco')");
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La produccion de " .$tecnico ." fue guardada";
    $color_toast = "success";
    mysqli_query($conn, "UPDATE carga_dia set ingresado = 'SI' WHERE tecnico = '$tecnico' AND = '$fecha'");
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/produccion.php');
}

if (isset($_POST['second_produccion']))
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
    'Guardado',
    'Produccion',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $dia = $_POST['dia'];
  $horadep = $_POST['horadep'];
  $horatarea = $_POST['horatarea'];
  $dosplay = $_POST['dosplay'];
  $tresplay = $_POST['tresplay'];
  $stb = $_POST['stb'];
  $mudanza = $_POST['mudanza'];

  $tcumplida = $dosplay + $tresplay + $mudanza;  

  $bajas = $_POST['bajas'];
  $bajatec = $_POST['bajatec'];
  $garantec = $_POST['garantec'];
  $garancom = $_POST['garancom'];
  $fin = $_POST['fin'];
  $zona = $_POST['zona'];
  $obs = $_POST['obs'];
  $baja_desmonte = $_POST['baja_desmonte'];
  $mtto_int = $_POST['mtto_int'];
  $mtto_ext = $_POST['mtto_ext'];
  $mtto_reaco = $_POST['mtto_reaco'];

  $tareasmtto = $mtto_int + $mtto_ext + $mtto_reaco;

  $reclamo = '0';

  $result = mysqli_query($conn, "INSERT INTO produccion(tecnico, fecha, dia, horadep, horatarea, dosplay, tresplay, stb, mudanza, tcumplida, tareasmtto, bajas, bajatec, garantec, garancom, fin, zona, obs, baja_desmonte, mtto_int, mtto_ext, mtto_reaco, reclamo) VALUES ('$tecnico', '$fecha', '$dia', '$horadep', '$horatarea', '$dosplay', '$tresplay', '$stb', '$mudanza', '$tcumplida', $tareasmtto, '$bajas', '$bajatec', '$garantec', '$garancom', '$fin', '$zona', '$obs', '$baja_desmonte', '$mtto_int', '$mtto_ext', '$mtto_reaco', '$reclamo')");
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La produccion de " .$tecnico ." fue guardada";
    $color_toast = "success";
    mysqli_query($conn, "UPDATE carga_dia set ingresado = 'SI' WHERE tecnico = '$tecnico' AND fecha = '$fecha'");
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/produccion2.php');
}
?>