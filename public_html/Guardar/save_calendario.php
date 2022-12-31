<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$tipo = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
$tipo_us = $_SESSION['tipo_us'];
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
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
if (isset($_POST['guardar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = uniqid();
  if($_POST['titulo'] == '')
  {
    $titulo = $_POST['tarea'];
  }
  else
  {
    $titulo = Reemplazo($_POST['titulo']);
  }
  $color_tarea = '#FFAA16';
  $inicio = $_POST['inicio'];
  $fin = $_POST['inicio'];
  $tecnico = $_POST['tecnico'];
  $tarea = $_POST['tarea'];
  if($_POST['contenido'] !== '')
    {
      $contenido = Reemplazo($_POST['contenido']);
    }else{
      $contenido = '';
    }
    if($tarea == 'Garantia')
    {
      if($_POST['id_garantia'] == '')
      {
        $ot_tarea = "No se encontro OT";
        $id_tarea = "No se encontro ID";
      }
      else
      {
        $ot_tarea = $_POST['ot_garantia'];
        $id_tarea = $_POST['id_garantia'];        
      }
    }
    if($tarea == 'Reclamo')
    {
      if($_POST['id_reclamo'] == '')
      {
        $ot_tarea = "No se encontro OT";
        $id_tarea = "No se encontro ID";
      }
      else
      {
        $id_tarea = $_POST['id_reclamo'];
        $ot_tarea = $_POST['ot_reclamo'];        
      }
    }

  $a_quien = implode(",", $_POST['a_quien']);

    $query_dupli = "SELECT * FROM calendario WHERE quien = '$quien' AND inicio = '$inicio' AND fin = '$fin' AND contenido = '$contenido' AND titulo = '$titulo'";
    $result_dupli = mysqli_query($conn, $query_dupli);
    if (mysqli_num_rows($result_dupli) >= 1)
    {
      $alerta = "Guardado";
			$msj = "La tarea fue registrada.";
			$color = "warning";
    }
    else
    {
      $entrada_a = "INSERT INTO calendario (token, quien, a_quien, titulo, contenido, color, inicio, fin, tecnico, tarea, id_tarea, ot_tarea) VALUES ('$token', '$quien', '$a_quien', '$titulo', '$contenido', '$color_tarea', '$inicio', '$fin', '$tecnico', '$tarea', '$id_tarea', '$ot_tarea')";
      $result_a = mysqli_query($conn, $entrada_a);
      
      if(!$result_a)
      {
        $alerta = "Error";
        $msj = "Error en el servidor.";
        $color = "error";
      }
      else
      {
        /* MSJ */
          if($tecnico == '')
          {
            $cuerpo_msj = $contenido;
          }
          else
          {
            if($contenido == '')
            {
              $cuerpo_msj = 'Tecnico: ' .$tecnico;
            }
            else
            {
              $cuerpo_msj = 'Tecnico: ' .$tecnico .' - ' .'Contenido: ' .$contenido;
            }
          }
          $link = '/Basico/b_ver_calendario.php?token='.$token;
          $icono="https://argentseal.online/images/icon_512.png";
          
          $porciones = explode(",", $a_quien);
          foreach ($porciones as $quienes_nota){
            $nomnom = explode(" ", $quienes_nota);
            $nombre_nota = $nomnom[0];
            $apellido_nota = $nomnom[1];

          $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
          if (mysqli_num_rows($msj) == 1)
          {
            $row = mysqli_fetch_array($msj);
            $firebase = $row['firebase'];  
          }

          $field=array(
              'data'=>array(
              'notification'=>array(
              'title'=>'Nueva tarea (' .$tarea .')',
              'body'=>$cuerpo_msj,
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
        $alerta = "Guardado";
        $msj = "La tarea fue guardada.";
        $color = "success";
      }
    }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/calendario_despacho.php');
}

if (isset($_POST['finalizar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Finalizar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = $_GET['token'];
  $obs = Reemplazo($_POST['obs']);
  $estado = 'Finalizado';
  $color_tarea = '#7ED321';

  $fifi = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token'");
    if (mysqli_num_rows($fifi) == 1)
    {
      $row = mysqli_fetch_array($fifi);
      $a_quien = $row['a_quien'];
    }

  $consulta_fin = "UPDATE calendario set  obs = '$obs', estado = '$estado', color = '$color_tarea', tomado_por = '$a_quien' WHERE token = '$token'";
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
  header('Location: ../Basico/calendario_despacho.php');
}

if (isset($_POST['rechazar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Rechazar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $obs = Reemplazo($_POST['obs']);

    $rere = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token'");
    if (mysqli_num_rows($rere) == 1)
    {
      $row = mysqli_fetch_array($rere);
      $a_quien = $row['a_quien'];
    }
  
    $consulta_recha = "UPDATE calendario set  obs = '$obs', estado = 'Rechazado', color = '#FF1616', tomado_por = '$a_quien' WHERE token = '$token'";
    $resultado_recha = mysqli_query($conn, $consulta_recha);
    if(!$resultado_recha)
      {
        $alerta = "Error";
        $msj = "Error en el servidor.";
        $color = "error";
      }
      else
      {
        $alerta = "Actualizado";
        $msj = "La tarea fue rechazada.";
        $color = "warning";
      }
  }
  
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/calendario_despacho.php');
}

if(isset($_GET['tomar']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Tomar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $token = $_GET['tomar'];    
    mysqli_query($conn, "UPDATE calendario set tomado_por = '$quien', color = '#50E3C2' WHERE token = '$token'");

    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = 'Tomado';
    $_SESSION['mensaje_toast'] = "La tarea fue tomada correctamente";
    $_SESSION['color_toast'] = 'success';
    header('Location: ../Basico/b_ver_calendario.php?token='.$token);
  }

if(isset($_GET['garant']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Finalizar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $token = $_GET['garant'];

    $result_recha = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token'");
    if (mysqli_num_rows($result_recha) == 1)
    {
      $row = mysqli_fetch_array($result_recha);
      $id_tarea = $row['id_tarea'];
    }
    $obs_supervisor = Reemplazo($_POST['obs_supervisor']);
    $quien = $nombre .' ' .$apellido;
    $cuando = date('Y-m-d H:i:s', time());
    $justificado= $_POST['justificada'];

    mysqli_query($conn, "UPDATE garantias set obs_supervisor = '$obs_supervisor', supervisor = '$quien', cuando = '$cuando', justificado = '$justificado' WHERE id = '$id_tarea'");
    mysqli_query($conn, "UPDATE calendario set color = '#7ED321', estado = 'Finalizado' WHERE token = '$token'");

    /* MSJ */
      $tec_sup = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token' LIMIT 1");
      if (mysqli_num_rows($tec_sup) == 1)
      {
        $row = mysqli_fetch_array($tec_sup);
        $quien_sup = $row['quien'];
        $tarea_sup = $row['tarea'];
        $tecnico_sup = $row['tecnico'];
        $contenido_sup = $row['contenido'];
      }
      $porciones = explode(" ", $quien_sup);
      $nombre_nota = $porciones[0];
      $apellido_nota = $porciones[1];
      
      $link = '/Basico/b_ver_calendario.php?token='.$token;
      $icono="/images/icon_512.png";

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      if($tecnico_sup == '')
        {
          $cuerpo_msj = $contenido_sup;
        }
        else
        {
          if($contenido_sup == '')
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup;
          }
          else
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup .' - ' .'Contenido: ' .$contenido_sup;
          }
        }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Tarea finalizada (' .$tarea_sup .')',
          'body'=>$cuerpo_msj,
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
    /* MSJ */

    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = 'Finalizado';
    $_SESSION['mensaje_toast'] = "La tarea fue finalizada correctamente";
    $_SESSION['color_toast'] = 'success';
    header('Location: ../Basico/calendario.php');
  }

if(isset($_GET['reclamo']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Finalizar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $token = $_GET['reclamo'];

    $recla = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token'");
    if (mysqli_num_rows($recla) == 1)
    {
      $row = mysqli_fetch_array($recla);
      $id_tarea = $row['id_tarea'];
    }
    $fechasolu = $_POST['fechasolu'];
    $solucion = Reemplazo($_POST['solucion']);

    mysqli_query($conn, "UPDATE reclamos set solucion = '$solucion', fechasolu = '$fechasolu' WHERE id = '$id_tarea'");
    mysqli_query($conn, "UPDATE calendario set color = '#7ED321', estado = 'Finalizado' WHERE token = '$token'");

    /* MSJ */
      $tec_sup = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token' LIMIT 1");
      if (mysqli_num_rows($tec_sup) == 1)
      {
        $row = mysqli_fetch_array($tec_sup);
        $quien_sup = $row['quien'];
        $tarea_sup = $row['tarea'];
        $tecnico_sup = $row['tecnico'];
        $contenido_sup = $row['contenido'];
      }
      $porciones = explode(" ", $quien_sup);
      $nombre_nota = $porciones[0];
      $apellido_nota = $porciones[1];
      
      $link = '/Basico/b_ver_calendario.php?token='.$token;
      $icono="/images/icon_512.png";

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      if($tecnico_sup == '')
        {
          $cuerpo_msj = $contenido_sup;
        }
        else
        {
          if($contenido_sup == '')
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup;
          }
          else
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup .' - ' .'Contenido: ' .$contenido_sup;
          }
        }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Tarea finalizada (' .$tarea_sup .')',
          'body'=>$cuerpo_msj,
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
    /* MSJ */

    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = 'Finalizado';
    $_SESSION['mensaje_toast'] = "La tarea fue finalizada correctamente";
    $_SESSION['color_toast'] = 'success';
    header('Location: ../Basico/calendario.php');
  }

if(isset($_GET['cerrar']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Finalizar tarea', 'Calendario', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $formatos = array('.jpg', '.jpeg', '.png');
    $token = $_GET['cerrar'];
    /////////////IMAGEN 1////////////////////
    
      if ($_FILES['imagen1']['name'] != null)
      {     
        $imagen1 = $token ."-" ."foto1";
  
        $nombreArchivo1 = $_FILES['imagen1']['name'];
        $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
        $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
        if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
        {
          if($_FILES['imagen1']['size'] < 9000000 )
          {
            if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/calendario/" .$imagen1 .$ext1))
            {   
                $imagenpri = $imagen1 .$ext1;
                $msg1 = "1";
            }
            else
            {
              $msg1 = "E-I"; ///servidor
            }
          }
          else
          {
            $msg1 = "E-P"; ///Tamaño
          }
        }
        else
        {
          $msg1 = "E-F"; ///Fomrato
        }
      }
      else
      {
        $imagenpri = "";
        $msg1 = '';
      }
    /////////////IMAGEN 1////////////////////
  
    /////////////IMAGEN 2////////////////////
      
      if ($_FILES['imagen2']['name'] != null)
      {     
        $imagen2 = $token ."-" ."foto2";
  
        $nombreArchivo2 = $_FILES['imagen2']['name'];
        $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
        $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
        if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
        {
          if($_FILES['imagen2']['size'] < 9000000 )
          {
            if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/calendario/" .$imagen2 .$ext2))
            {   
                $imagenseg = $imagen2 .$ext2;
                $msg2 = "1";
            }
            else
            {
              $msg2 = "E-I";
            }
          }
          else
          {
            $msg2 = "E-P";
          }
        }
        else
        {
          $msg2 = "E-F";
        }
      }
      else
      {
        $imagenseg = "";
        $msg2 = '';
      }
    /////////////IMAGEN 2////////////////////
    $obs_supervisor = Reemplazo($_POST['obs_supervisor']);

    mysqli_query($conn, "UPDATE calendario set color = '#7ED321', estado = 'Finalizado', obs_supervisor = '$obs_supervisor', archivo_uno = '$imagenpri', archivo_dos = '$imagenseg' WHERE token = '$token'");
    /* MSJ */
      $tec_sup = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token' LIMIT 1");
      if (mysqli_num_rows($tec_sup) == 1)
      {
        $row = mysqli_fetch_array($tec_sup);
        $quien_sup = $row['quien'];
        $tarea_sup = $row['tarea'];
        $tecnico_sup = $row['tecnico'];
        $contenido_sup = $row['contenido'];
      }
      $porciones = explode(" ", $quien_sup);
      $nombre_nota = $porciones[0];
      $apellido_nota = $porciones[1];
      
      $link = '/Basico/b_ver_calendario.php?token='.$token;
      $icono="/images/icon_512.png";

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      if($tecnico_sup == '')
        {
          $cuerpo_msj = $contenido_sup;
        }
        else
        {
          if($contenido_sup == '')
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup;
          }
          else
          {
            $cuerpo_msj = 'Tecnico: ' .$tecnico_sup .' - ' .'Contenido: ' .$contenido_sup;
          }
        }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Tarea finalizada (' .$tarea_sup .')',
          'body'=>$cuerpo_msj,
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
    /* MSJ */

    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = 'Finalizado';
    $_SESSION['mensaje_toast'] = "La tarea fue finalizada correctamente";
    $_SESSION['color_toast'] = 'success';
    header('Location: ../Basico/calendario.php');
  }
?>