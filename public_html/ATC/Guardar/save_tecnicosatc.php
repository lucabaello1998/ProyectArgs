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
if($tipo == "ATC") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   
}


$formatos = array('.jpg', '.jpeg');
if (isset($_POST['save_usuario']))
{
  $nombre = Renombre($_POST['nombre']);
  $apellido = Renombre($_POST['apellido']);
  if (!$_POST['mail'])
  {
    $mail = "";
  }
  else
  {
    $mail = $_POST['mail'];
  }
  if (!$_POST['usuario'])
  {
    $usuario = "";
  }
  else
  {
    $usuario = $_POST['usuario'];
  }
  if (!$_POST['pass'])
  {
    $pass = "";
  }
  else
  {
    $pass = $_POST['pass'];
  }
  if (!$_POST['tel'])
  {
    $tel = "";
  }
  else
  {
    $tel = $_POST['tel'];
  }
  $dni = $_POST['dni'];
  $num_empleado = $_POST['num_empleado'];
  $tarea = $_POST['tarea'];
  $operativo = $_POST['operativo'];
  $color = $_POST['color'];
  $inicio = $_POST['inicio'];
  
  if ($_FILES['archivo']['name'] != null)
  {
    $jpg = $_POST['nombre'] ."_" .$_POST['apellido'];    

    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
    $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
    if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
    {
      if ($_FILES['archivo']['size']<800000)
      {
        if (move_uploaded_file($nombreTmpArchivo, "../Archivos/tecnicos/$jpg" .".jpg"))
        {
            $msg = $nombre ." " .$apellido ." fue cargado correctamente"; 
            $msgColor = "success";      
            
              $query = "INSERT INTO tecnicosatc(nombre, apellido, mail, usuario, pass, tel, dni, tarea, enlace, operativo, color, num_empleado, inicio) VALUES ('$nombre', '$apellido', '$mail', '$usuario', '$pass', '$tel', '$dni', '$tarea', '$jpg', '$operativo', '$color', '$num_empleado', '$inicio')";
            $result = mysqli_query($conn, $query);
            if(!$result) 
            {
              $msg ="Error en el servidor, recuerde completar todos los campos.";
              $msgColor = "danger";
            }
        }
        else
        {
          $msg = "Error, intentamente nuevamente";
          $msgColor = "danger";
        }
      }
      else
      {
        $msg = "El archivo que intenta subir es muy pesado";
        $msgColor = "danger";
      }
    }
    else
    {
      $msg = "Formato no permitido, debe ser jpg.";
      $msgColor = "danger";
    }
  }
  else
  {
    $msg = $nombre ." " .$apellido ." fue cargado correctamente, solo falta la credencial."; 
    $msgColor = "success";
    $jpg = "";
    $query = "INSERT INTO tecnicosatc(nombre, apellido, mail, usuario, pass, tel, dni, tarea, enlace, operativo, color, num_empleado, inicio) VALUES ('$nombre', '$apellido', '$mail', '$usuario', '$pass', '$tel', '$dni', '$tarea', '$jpg', '$operativo', '$color', '$num_empleado', '$inicio')";
      $result = mysqli_query($conn, $query);
      if(!$result) 
      {
        $msg ="Error en el servidor.";
        $msgColor = "danger";
      }
    }
  
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../../ATC/Basico/tecnicosatc.php');

}
?>

<!--  $nombreArchivo = $_FILES['archivo']['name'];
  $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
  $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
  if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
  {
    if ($_FILES['archivo']['size']<400000)
    {
      if (move_uploaded_file($nombreTmpArchivo, "../Archivos/tecnicos/$jpg" .".jpg"))
      {
          $msg = $nombre ." " .$apellido ." fue cargado correctamente"; 
          $msgColor = "success";      
          
            $query = "INSERT INTO tecnicosatc(nombre, apellido, mail, usuario, pass, tel, dni, tarea, enlace, operativo) VALUES ('$nombre', '$apellido', '$mail', '$usuario', '$pass', '$tel', '$dni', '$tarea', '$jpg', '$operativo')";
          $result = mysqli_query($conn, $query);
          if(!$result) 
          {
            $msg ="Error en el servidor, recuerde completar todos los campos.";
            $msgColor = "danger";
          }
      }
      else
      {
        $msg = "Error, intentamente nuevamente";
        $msgColor = "danger";
      }
    }
    else
    {
      $msg = "El archivo que intenta subir es muy pesado";
      $msgColor = "danger";
    }
  }
  else
  {
    $msg = "Formato no permitido, debe ser jpg.";
    $msgColor = "danger";
  }
 -->