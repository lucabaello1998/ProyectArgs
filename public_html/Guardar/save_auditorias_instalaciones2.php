<?php
include('../db.php');
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
  header("location: ../index.php");   /////Visor - Deposito/////
}

$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$relevador = strtoupper(substr($nombre, 0, 1)) .strtoupper(substr($apellido, 0, 1));

function generarCodigo($longitud)
{
  $key = '';
  $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $max = strlen($pattern)-1;
  for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
  return $key;
}

$idem = generarCodigo(6);
$identificador = "I" .$relevador ."-" .$idem;

$msg = '';
$msgColor = '';
$msg1 = '';
$msg2 = '';
$msg3 = '';
$msg4 = '';

$formatos = array('.jpg', '.jpeg', '.png');
if (isset($_POST['save_auditoria_instalaciones2']))
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
  $obs = Reemplazo($_POST['obs']);

  /////////////IMAGEN 1////////////////////
    
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $identificador ."-" ."imagen1";

      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/instalaciones2/" .$imagen1 .$ext1))
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
      $imagen2 = $identificador ."-" ."imagen2";

      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/instalaciones2/" .$imagen2 .$ext2))
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

  /////////////IMAGEN 3////////////////////
    
    if ($_FILES['imagen3']['name'] != null)
    {     
      $imagen3 = $identificador ."-" ."imagen3";

      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../Archivos/instalaciones2/" .$imagen3 .$ext3))
          {   
              $imagenter = $imagen3 .$ext3;
              $msg3 = "1";
          }
          else
          {
            $msg3 = "E-I";
          }
        }
        else
        {
          $msg3 = "E-P";
        }
      }
      else
      {
        $msg3 = "E-F";
      }
    }
    else
    {
      $imagenter = "";
      $msg3 = '';
    }
  /////////////IMAGEN 3////////////////////

  /////////////IMAGEN 4////////////////////
    
    if ($_FILES['imagen4']['name'] != null)
    {     
      $imagen4 = $identificador ."-" ."imagen4";

      $nombreArchivo4 = $_FILES['imagen4']['name'];
      $nombreTmpArchivo4 = $_FILES['imagen4']['tmp_name'];
      $ext4 = substr($nombreArchivo4, strrpos($nombreArchivo4, '.'));
      if (in_array($ext4, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen4']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo4, "../Archivos/instalaciones2/" .$imagen4 .$ext4))
          {   
              $imagencuar = $imagen4 .$ext4;
              $msg4 = "1";
          }
          else
          {
            $msg4 = "E-I";
          }
        }
        else
        {
          $msg4 = "E-P";
        }
      }
      else
      {
        $msg4 = "E-F";
      }
    }
    else
    {
      $imagencuar = "";
      $msg4 = '';
    }
  /////////////IMAGEN 4////////////////////
  $imagenes = $msg1 + $msg2 + $msg3 + $msg4;

  $result = mysqli_query($conn, "INSERT INTO auditoria_instalaciones(identificador, supervisor, tecnico, fecha, ot, instalacion_externa, foto_nomenclador, cadena, altura_acometida, punto_retencion, curva_goteo, ingreso_domicilio, engrampado_interior, ont, residuos, trato_cliente, uso_herramientas, epp, imagenpri, imagenseg, imagenter, imagencuar, obs) VALUES ('$identificador', '$supervisor', '$tecnico', '$fecha', '$ot', '$instalacion_externa', '$foto_nomenclador', '$cadena', '$altura_acometida', '$punto_retencion', '$curva_goteo', '$ingreso_domicilio', '$engrampado_interior', '$ont', '$residuos', '$trato_cliente', '$uso_herramientas', '$epp', '$imagenpri', '$imagenseg', '$imagenter', '$imagencuar', '$obs')");
  if(!$result) 
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
    header('Location: ../Basico/auditorias_instalaciones2.php');
  }
  else
  {
    if (isset($_POST['realizado']))
    {
      $token_calendario = $_POST['token_calendario'];
      mysqli_query($conn, "UPDATE calendario set color = '#7ED321', estado = 'Finalizado', id_auditoria = '$identificador', tomado_por = '' WHERE token = '$token_calendario'");


      /* MSJ */
        $tec_sup = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token_calendario' LIMIT 1");
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


      $titulo_toast = "Guardado";
      $msj_toast = "La auditoria de " .$tecnico ." en la OT " .$ot ." fue cargado correctamente con " .$imagenes ." imagenes";
      $color_toast = "success";
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;
      header('Location: ../Basico/auditorias_instalaciones2.php');
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La auditoria de " .$tecnico ." en la OT " .$ot ." fue cargado correctamente con " .$imagenes ." imagenes";
      $color_toast = "success";
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;
      header('Location: ../Basico/auditorias_instalaciones2.php');
    }
  }
}
?>