<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$quien_notas = $nombre_us .' ' .$apellido_us ;
$tipo_us = $_SESSION['tipo_us'];
$usuarios_permitidos = array("Administrador", "Despacho");
if (in_array($tipo_us, $usuarios_permitidos))
{ $usu = 1; }
else
{ $usu = 0; }

if($usu != 1)
{
  header("location: /index.php");
}
if (isset($_POST['guardar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Nueva consulta portal tecnicos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = uniqid();
  $padre = $_POST['padre'];
  $texto = trim($_POST['texto']);
  $tipo = $_POST['tipo'];
  if($_POST['copiable'] == 'Si')
  {
    $copiable = 'Si';
  }
  else
  {
    $copiable = 'No';
  }
  $nivel = 'Inicial';
  $con_tec = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE token = '$padre'");
  while($row = mysqli_fetch_array($con_tec))
  {
    $nivel = $row['nivel'] +1;
  }

  /////////////IMAGEN 1////////////////////
    $formatos = array('.jpg', '.jpeg', '.png');
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $token;
      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos))
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/consultas/" .$imagen1 .$ext1))
          {   
            $texto = $imagen1 .$ext1;
          }
          else
          {
            $texto = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $texto = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $texto = "Error de formato"; ///Fomrato
      }
    }
  /////////////IMAGEN 1////////////////////

  if($texto == '' || $texto == ' ')
  {
    $titulo_toast = "Error";
    $msj_toast = "El campo estaba vacio, no se pudo guardar";
    $color_toast = "danger";
  }
  else
  {
    $r = mysqli_query($conn, "INSERT INTO consultas_tec(token, quien, texto, padre, nivel, tipo, copiable) VALUES ('$token', '$quien_notas', '$texto', '$padre', '$nivel', '$tipo', '$copiable')");
    if(!$r)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al guardar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "El texto fue guardado correctamente.";
      $color_toast = "success";
    }
  }
  
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/portal_tec.php');
}

if (isset($_POST['borrar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Borrado', 'Consulta portal tecnicos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = $_POST['token'];
  $borr = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE token = '$token'");
	if (mysqli_num_rows($borr) == 1)
	{
    $row = mysqli_fetch_array($borr);
    $imagen = $row['texto'];
  }

  $filename1 = "../Archivos/consultas/$imagen";
  if (file_exists($filename1))
  {
    unlink($filename1);
  }

	$b = mysqli_query($conn, "DELETE FROM consultas_tec WHERE token = '$token'");
	if(!$b)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al borrar el texto";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Eliminado";
    $msj_toast = "El texto fue borrado correctamente.";
    $color_toast = "danger";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/portal_tec.php');
}

if (isset($_POST['editar']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Editado', 'Consulta portal tecnicos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = $_POST['token'];
  $texto = trim($_POST['texto']);
  if($_POST['copiable'] == 'Si')
  {
    $copiable = 'Si';
  }
  else
  {
    $copiable = 'No';
  }

  /////////////IMAGEN 1////////////////////
    $edit = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE token = '$token'");
    if (mysqli_num_rows($edit) == 1)
    {
      $row = mysqli_fetch_array($edit);
      $tex = $row['texto'];
    }
    $formatos = array('.jpg', '.jpeg', '.png');
    if ($_FILES['archivo']['name'] != null)
    {     
      $imagen = $token .'x';
      $nombreArchivo = $_FILES['archivo']['name'];
      $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
      $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
      if (in_array($ext, $formatos))
      {
        if($_FILES['archivo']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo, "../Archivos/consultas/" .$imagen .$ext))
          {   
            $texto = $imagen .$ext;
            $filename = "../Archivos/consultas/$tex";
            if (file_exists($filename))
            {
              unlink($filename);
            }
          }
          else
          {
            $texto = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $texto = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $texto = "Error de formato"; ///Fomrato
      }
    }
  /////////////IMAGEN 1////////////////////

  if($texto == '' || $texto == ' ')
  {
    $titulo_toast = "Error";
    $msj_toast = "El campo estaba vacio, no se pudo editar";
    $color_toast = "danger";
  }
  else
  {
    $e = mysqli_query($conn, "UPDATE consultas_tec SET texto = '$texto', copiable = '$copiable' WHERE token = '$token'");
    if(!$e)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al editar el texto";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Eliminado";
      $msj_toast = "El texto fue editado correctamente.";
      $color_toast = "success";
    }
  }
	
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/portal_tec.php');
}
?>