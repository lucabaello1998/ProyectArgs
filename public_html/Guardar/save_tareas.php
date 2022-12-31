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
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

if (isset($_POST['guardar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Tareas', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $formatos = array('.jpg', '.jpeg', '.png', '.PDF', '.pdf', '.JPG', '.JPEG', '.PNG', '.doc', '.docx', '.xls', '.xlsx', '.csv', '.kml', '.KML', '.kmz', '.KMZ');

  $token = uniqid();
  $quien = $nombre .' ' .$apellido;
  $titulo = Reemplazo($_POST['titulo']);
  $tarea = $_POST['tarea'];
  switch($tarea)
  {
    case 'Administrativo': $abreviado = 'Adm';
    break;
    case 'ATC': $abreviado = 'ATC';
    break;
    case 'Web': $abreviado = 'Web';
    break;
    case 'Otro': $abreviado = 'Otro';
    break;
    case 'Deposito': $abreviado = 'Depo';
    break;
  }
  $inicio = date('Y-m-d');
  $fin = $_POST['fin'];
  $a_quien = implode(", ", $_POST['a_quien']);
  $descripcion = Reemplazo($_POST['descripcion']);
  $color = 'warning';
  $estado = 'Backlog';
  $prioridad = $_POST['prioridad'];
  $subtarea = $_POST['item'];
  $sub_estado = 'Pendiente';

  /////////////IMAGEN 1////////////////////
    
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $token ."_" ."1";

      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/tareas/" .$imagen1 .$ext1))
          {   
              $imagenpri = $imagen1 .$ext1;
              $msg1 = "1";
          }
          else
          {
            $imagenpri = "";
            $msg1 = "ES"; ///servidor
          }
        }
        else
        {
          $imagenpri = "";
          $msg1 = "ET"; ///Tamaño
        }
      }
      else
      {
        $imagenpri = "";
        $msg1 = "EF"; ///Fomrato
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
      $imagen2 = $token ."_" ."2";

      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/tareas/" .$imagen2 .$ext2))
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
      $imagen3 = $token ."_" ."3";

      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../Archivos/tareas/" .$imagen3 .$ext3))
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

  $imagenes = $msg1 + $msg2 + $msg3;

    while(true)
    {
      //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
      $item1 = current($subtarea);
      
      ////// ASIGNARLOS A VARIABLES ///////////////////
      $subtareasubtarea = (( $item1 !== false) ? $item1 : ", &nbsp;");

      if($subtareasubtarea !== '')
      {
        //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
        $valores='("'.$token.'","'.$quien.'","'.$subtareasubtarea.'","'.$sub_estado.'"),';

        //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
        $valoresQ= substr($valores, 0, -1);
        
        ///////// QUERY DE INSERCIÓN ////////////////////////////
        mysqli_query($conn, "INSERT INTO tareas(token, quien, sub_tarea, sub_estado) VALUES $valoresQ");
      }
      
      // Up! Next Value
      $item1 = next( $subtarea );
      
      // Check terminator
      if($item1 === false) break;
    }

    $r = mysqli_query($conn, "INSERT INTO tareas(token, quien, titulo, prioridad, tarea, abreviado, inicio, fin, a_quien, descripcion, color, estado, archivo_uno, nom_archivo_uno, archivo_dos, nom_archivo_dos, archivo_tres, nom_archivo_tres) VALUES ('$token', '$quien', '$titulo', '$prioridad', '$tarea', '$abreviado', '$inicio', '$fin', '$a_quien', '$descripcion', '$color', '$estado', '$imagenpri','$nombreArchivo1','$imagenseg', '$nombreArchivo2','$imagenter','$nombreArchivo3')");
    if(!$r)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al guardar la tarea";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La tarea fue guardada con " .$imagenes ." archivos";
      $color_toast = "success";
    }
  
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}

if (isset($_POST['menos']))
{
	if(isset($_POST['menos']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $encriptado = date ('Y-m', strtotime($ultima_fecha."- 1 month"));
    $fechaa = base64_encode($encriptado);
  }
  header('Location: ../Basico/tareas.php?mes='.$fechaa);
}

if (isset($_POST['mas']))
{
	if(isset($_POST['mas']))
 {
	 $ultima_fecha = $_POST['ultima_fecha'];
   $encriptado = date ('Y-m', strtotime($ultima_fecha."+ 1 month"));
   $fechaa = base64_encode($encriptado);
 }
  header('Location: ../Basico/tareas.php?mes='.$fechaa);
}

if (isset($_GET['backlog']))
{
  $token = $_GET['backlog'];
  $backlog = mysqli_query($conn, "UPDATE tareas set estado = 'Backlog', color = 'warning' WHERE token = '$token'");
  if(!$backlog)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al iniciar la tarea";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Iniciado";
    $msj_toast = "La tarea fue puesta en el backlog";
    $color_toast = "success";
  }

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}

if (isset($_GET['sprint']))
{
  $token = $_GET['sprint'];
  $sprint = mysqli_query($conn, "UPDATE tareas set estado = 'Sprint', color = 'primary' WHERE token = '$token'");
  if(!$sprint)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al iniciar la tarea";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Iniciado";
    $msj_toast = "La tarea fue puesta en sprint";
    $color_toast = "success";
  }

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}

if (isset($_GET['revision']))
{
  $token = $_GET['revision'];
  $revision = mysqli_query($conn, "UPDATE tareas set estado = 'En revision', color = 'info' WHERE token = '$token'");
  if(!$revision)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al procesar la tarea";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Finalizado";
    $msj_toast = "La tarea esta en proceso de revision";
    $color_toast = "success";
  }

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}

if (isset($_GET['finalizar']))
{
  $token = $_GET['finalizar'];
  $inicio = mysqli_query($conn, "UPDATE tareas set estado = 'Finalizado', color = 'success' WHERE token = '$token'");
  if(!$inicio)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al iniciar la tarea";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Finalizado";
    $msj_toast = "La tarea fue finalizada correctamente";
    $color_toast = "success";
  }

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}

if (isset($_GET['actualizar']))
{
  $token = $_GET['actualizar'];
  $quien = $nombre .' ' .$apellido;
  $titulo = Reemplazo($_POST['titulo']);
  $tarea = $_POST['tarea'];
  $prioridad = $_POST['prioridad'];
  switch($tarea)
  {
    case 'Administrativo': $abreviado = 'Adm';
    break;
    case 'ATC': $abreviado = 'ATC';
    break;
    case 'Web': $abreviado = 'Web';
    break;
    case 'Otro': $abreviado = 'Otro';
    break;
    case 'Deposito': $abreviado = 'Depo';
    break;
  }
  $fin = $_POST['fin']; 
  $a_quien = implode(", ", $_POST['a_quien']);
  $descripcion = Reemplazo($_POST['descripcion']);
  $id_sub = $_POST['id'];
  $sub = $_POST['sub'];
  $subtarea = $_POST['item_sub'];
  $sub_estado = 'Pendiente';
  $inicio = date('Y-m-d');

  if(isset($_POST['sub']))
  {
    while(true)
    {
      $ids = current($id_sub);
      $items = Reemplazo(current($sub));

      mysqli_query($conn, "UPDATE tareas set sub_tarea = '$items' WHERE id = '$ids'");

      $ids = next( $id_sub );
      $items = next( $sub );
      if($items === false && $ids === false) break;
    }
  }
  else
  {
    while(true)
    {
      //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
      $item1 = current($subtarea);
      
      ////// ASIGNARLOS A VARIABLES ///////////////////
      $subtareasubtarea = (( $item1 !== false) ? $item1 : ", &nbsp;");

      if($subtareasubtarea !== '')
      {
        //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
        $valores='("'.$token.'","'.$quien.'","'.$subtareasubtarea.'","'.$sub_estado.'","'.$inicio.'","'.$fin.'","'.$titulo.'","'.$prioridad.'","'.$tarea.'","'.$abreviado.'"),';

        //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
        $valoresQ= substr($valores, 0, -1);
        
        ///////// QUERY DE INSERCIÓN ////////////////////////////
        mysqli_query($conn, "INSERT INTO tareas(token, quien, sub_tarea, sub_estado, inicio, fin, titulo, prioridad, tarea, abreviado) VALUES $valoresQ");
      }
      
      // Up! Next Value
      $item1 = next( $subtarea );
      
      // Check terminator
      if($item1 === false) break;
    }
  }

  $act = mysqli_query($conn, "UPDATE tareas set titulo = '$titulo', prioridad = '$prioridad', tarea = '$tarea', abreviado = '$abreviado', fin = '$fin', a_quien = '$a_quien', descripcion = '$descripcion' WHERE token = '$token' AND mensaje = '' AND sub_tarea = ''");
  if(!$act)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al iniciar la tarea";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Actualizado";
    $msj_toast = "La tarea fue actualizada correctamente";
    $color_toast = "warning";
  }

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/tareas.php');
}
?>