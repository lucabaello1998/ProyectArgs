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
$tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien = $nombre ." " .$apellido;
if (isset($_POST['guardar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = uniqid();
  $titulo = $_POST['dia'] .' - ' .Reemplazo($_POST['titulo']);
  $inicio = $_POST['inicio'];
  if($_POST['inicio'] > $_POST['fin'])
  {
      $fin = $_POST['inicio'];
    }
    else
    {
      $fin = $_POST['fin'];
  }

  if($_POST['contenido'] !== '')
  {
    $contenido = Reemplazo($_POST['contenido']);
    }
    else
    {
    $contenido = '';
  };
  $a_quien = implode(",", $_POST['a_quien']);
  switch($_POST['dia'])
  {
    case 'Normal': $color_tarea = '#FFAA16';
    break;
    case 'Feriado': $color_tarea = '#17a2b8';
    break;
    case 'Libre': $color_tarea = '#28a745';
    break;
    case 'Vacaciones': $color_tarea = '#6610f2';
    break;
    case 'Licencia': $color_tarea = '#343a40';
    break;
    case 'Guardia': $color_tarea = '#fd7e14';
    break;
    case 'Administracion': $color_tarea = '#d63384';
    break;
  }

    $result_dupli = mysqli_query($conn, "SELECT * FROM calendario WHERE quien = '$quien' AND inicio = '$inicio' AND fin = '$fin' AND contenido = '$contenido' AND titulo = '$titulo' ");
    if (mysqli_num_rows($result_dupli) >= 1)
    {
      $alerta = "Guardado";
			$msj = "La tarea fue registrada.";
			$color = "warning";
    }
    else
    {
      $result_a = mysqli_query($conn, "INSERT INTO calendario (token, quien, titulo, contenido, color, inicio, fin, a_quien) VALUES ('$token', '$quien', '$titulo', '$contenido', '$color_tarea', '$inicio', '$fin', '$a_quien')");
      
      if(!$result_a)
      {
        $alerta = "Error";
        $msj = "Error en el servidor.";
        $color = "error";
      }
      else
      {
        $alerta = "Guardado";
        $msj = "La tarea fue registrada.";
        $color = "success";
        /* MSJ */
          $link = '/Basico/b_ver_calendario.php?token='.$token;
          $icono="/images/icon_512.png";
          
          $porciones = explode(",", $a_quien);
          foreach ($porciones as $quienes_nota)
          {
            $nomnom = explode(" ", $quienes_nota);
            $nombre_nota = $nomnom[0];
            $apellido_nota = $nomnom[1];
          
            $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
            if (mysqli_num_rows($result) == 1)
            {
              $row = mysqli_fetch_array($result);
              $firebase = $row['firebase'];  
            }

            $field=array(
                'data'=>array(
                'notification'=>array(
                'title'=>'Tarea programada (' .$titulo .')',
                'body'=>$contenido,
                'icon'=>$icono,
                'link'=>$link
                )
              ),
            'to'=>$firebase
            );
            $fields=json_encode($field);

            $header=array(
              'Authorization: key=AAAAsHb0r4c:APA91bFnf2A8l7nYJ1ajJuQSy6SJHjiGcHFU3fzw2gHyLbu9C5dYfl7n7fQ4n8LOVr8y2vg2P65O0g8wuo7S-DHZkGgxF_m2DEh9vNMYsP7_83Qb4DNj_Rgj_e0I9xuYkjAGYiGHjQhY',
              'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result=curl_exec($ch);
            curl_close($ch);
          }
        /* MSJ */
      }
    }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/b_calendario.php');
}

if (isset($_POST['finalizar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Finalizar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = $_GET['token'];
  $obs = Reemplazo($_POST['obs']);
  $estado = 'Finalizado';
  $color = '#7ED321';

  $consulta_fin = "UPDATE calendario set  obs = '$obs', estado = '$estado', color = '$color' WHERE token = '$token'";
  $resultado_fin = mysqli_query($conn, $consulta_fin);
  if(!$resultado_fin)
  {
			$alerta = "Error";
			$msj = "Error en el servidor.";
			$color = "error";
    }
    else
    {
      $alerta = "Actualizado";
      $msj = "La tarea fue finalizada.";
      $color = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/b_calendario.php');
}

if (isset($_POST['rechazar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Rechazar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $query_recha = "SELECT * FROM calendario WHERE token = '$token'";
    $result_recha = mysqli_query($conn, $query_recha);
    if (mysqli_num_rows($result_recha) == 1)
    {
      $row = mysqli_fetch_array($result_recha);
      $ini = $row['inicio'];
      $fifi = $row['fin'];
    }
  }
  $token = $_GET['token'];
  $obs = Reemplazo($_POST['obs']);
  
  $consulta_recha = "UPDATE calendario set  obs = '$obs', estado = 'Rechazado', color = '#FF1616' WHERE token = '$token'";
  $resultado_recha = mysqli_query($conn, $consulta_recha);
  if(!$resultado_recha)
    {
			$alerta = "Error";
			$msj = "Error en el servidor.";
			$color = "error";
    }
    else
    {
      if($estado == 'Pendiente'){
        $alerta = "Actualizado";
        $msj = "La tarea fue postergada.";
        $color = "warning";
      }
      else if ($estado == 'Rechazado')
      $alerta = "Actualizado";
      $msj = "La tarea fue rechazada.";
      $color = "warning";
    }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/b_calendario.php');
}

?>