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


$formatos = array('.kml');
if (isset($_POST['save_mapa_lineal']))
{
  if (!$_POST['nombre'])
  {
    $nombre = "";
  }
  else
  {
    $nombre = $_POST['nombre'];
  }
  $partido = $_POST['partido'];

  if ( $_POST['partido']== "La Matanza"  || $_POST['partido']== "Moreno"  || $_POST['partido']== "Ituzaingo"  || $_POST['partido']== "Hurlingham"  || $_POST['partido']== "Merlo"  || $_POST['partido']== "Moron"  || $_POST['partido']== "Tres de Febrero" )
  {
    $zona = "Oeste";
  }
  else
  {
    $zona = "Norte";
  }

  $localidad = "";

  if (!$_POST['orden'])
  {
    $orden = "";
  }
  else
  {
    $orden = $_POST['orden'];
  }

  if (!$_POST['km'])
  {
    $km = "";
  }
  else
  {
    $km = $_POST['km'];
  }
  $tarea = "Lineal";
  $color = $_POST['color'];

  
  if ($_FILES['archivo']['name'] != null)
  {
    $kml = uniqid();    

    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
    $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
    if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
    {
      if ($_FILES['archivo']['size']<2000000)
      {
        if (move_uploaded_file($nombreTmpArchivo, "../Archivos/mapas/$kml" .".kml"))
        {
            $msg = "El mapa de " .$tarea ." fue cargado correctamente"; 
            $msgColor = "success";      
            
            $query = "INSERT INTO atcmapas(nombre, zona, partido, localidad, orden, km, tarea, estado, enlace, color) VALUES ('$nombre', '$zona', '$partido', '$localidad', '$orden', '$km', '$tarea', 'Pendiente', '$kml', '$color')";
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
      $msg = "Formato no permitido, debe ser KML.";
      $msgColor = "danger";
    }
  }
  else
  {
    $msg = "Los datos de " .$tarea ." fue cargado correctamente, solo falta el mapa."; 
    $msgColor = "success";
    $kml = "";
    $query = "INSERT INTO atcmapas(nombre, zona, partido, localidad, orden, km, tarea, estado, enlace, color) VALUES ('$nombre', '$zona', '$partido', '$localidad', '$orden', '$km', '$tarea', 'Pendiente', '$kml', '$color')";
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
  header('Location: ../../ATC/Basico/mapas.php');

}



////GPON////
$formatos = array('.kml');
if (isset($_POST['save_mapa_gpon']))
{
  if (!$_POST['nombre'])
  {
    $nombre = "";
  }
  else
  {
    $nombre = $_POST['nombre'];
  }
  if ($_POST['localidad']== "Caseros" || $_POST['localidad']== "Ciudad Jardin" || $_POST['localidad']== "Ciudadela" || $_POST['localidad']== "Martin Coronado" || $_POST['localidad']== "Santos Lugares" || $_POST['localidad']== "Jose Ingeniero" || $_POST['localidad']== "Saenz Peña" || $_POST['localidad']== "Villa Bosch" || $_POST['localidad']== "Villa Raffo" )
  {
    $partido = "Tres de Febrero";
    $zona = "Oeste";
  }
  if ($_POST['localidad']== "Villa Sarmiento" || $_POST['localidad']== "Moron" || $_POST['localidad']== "Castelar" || $_POST['localidad']== "El Palomar" || $_POST['localidad']== "Haedo" )
  {
    $partido = "Moron";
    $zona = "Oeste";
  }
  if ($_POST['localidad']== "Hurlingham" || $_POST['localidad']== "Villa Tesei" || $_POST['localidad']== "Williams Morris")
  {
    $partido = "Hurlingham";
    $zona = "Oeste";
  }
  if ($_POST['localidad']== "Vicente Lopez" || $_POST['localidad']== "Carapachay" || $_POST['localidad']== "Florida" || $_POST['localidad']== "Florida Oeste" || $_POST['localidad']== "La Lucila" || $_POST['localidad']== "Munro" || $_POST['localidad']== "Olivos" || $_POST['localidad']== "Villa Adelina" || $_POST['localidad']== "Villa Martelli")
  {
    $partido = "Vicente Lopez";
    $zona = "Norte";
  }
  if ($_POST['localidad']== "San Fernando" || $_POST['localidad']== "TigreSF" || $_POST['localidad']== "Victoria" || $_POST['localidad']== "Virreyes")
  {
    $partido = "San Fernando";
    $zona = "Norte";
  }
  if ($_POST['localidad']== "Localidad...")
  {
    $partido = "";
    $zona = "";
  }
  if ($_POST['localidad']== "Benavidez" || $_POST['localidad']== "General pacheco" || $_POST['localidad']== "Garin" || $_POST['localidad']== "Ingeniero Maschwitz"  || $_POST['localidad']== "Don Torcuato" || $_POST['localidad']== "El Talar" || $_POST['localidad']== "Ricardo Rojas" || $_POST['localidad']== "Toncos del Talar" )
  {
    $partido = "Tigre";
    $zona = "Norte";
  }

  if ($_POST['localidad']== "Billinghurst" || $_POST['localidad']== "Jose Leon Suarez" || $_POST['localidad']== "Lomas Hermosa" || $_POST['localidad']== "San Andres" || $_POST['localidad']== "San Martin Centro" || $_POST['localidad']== "Villa Ballester" || $_POST['localidad']== "Villa Libertad" || $_POST['localidad']== "Villa Lynch" || $_POST['localidad']== "Villa Maipu" )
  {
    $partido = "San Martin";
    $zona = "Oeste";
  }

    if ($_POST['localidad']== "Escobar" )
  {
    $partido = "Escobar";
    $zona = "Norte";
  }

  $localidad = $_POST['localidad'];
  if (!$_POST['orden'])
  {
    $orden = "";
  }
  else
  {
    $orden = $_POST['orden'];
  }
  if (!$_POST['km'])
  {
    $km = "";
  }
  else
  {
    $km = $_POST['km'];
  }

  $tarea = "Gpon";
  $color = $_POST['color'];
  

  
  if ($_FILES['archivo']['name'] != null)
  {
    $kml = uniqid();    

    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
    $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
    if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
    {
      if ($_FILES['archivo']['size']<2000000)
      {
        if (move_uploaded_file($nombreTmpArchivo, "../Archivos/mapas/$kml" .".kml"))
        {
            $msg = "El mapa de " .$tarea ." fue cargado correctamente"; 
            $msgColor = "success";      
            
            $query = "INSERT INTO atcmapas(nombre, zona, partido, localidad, orden, km, tarea, estado, enlace, color) VALUES ('$nombre', '$zona', '$partido', '$localidad', '$orden', '$km', '$tarea', 'Pendiente', '$kml', '$color')";
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
      $msg = "Formato no permitido, debe ser KML.";
      $msgColor = "danger";
    }
  }
  else
  {
    $msg = "Los datos de " .$tarea ." fue cargado correctamente, solo falta el mapa.";
    $msgColor = "success";
    $kml = "";
    $query = "INSERT INTO atcmapas(nombre, zona, partido, localidad, orden, km, tarea, estado, enlace, color) VALUES ('$nombre', '$zona', '$partido', '$localidad', '$orden', '$km', '$tarea', 'Pendiente', '$kml', '$color')";
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
  header('Location: ../../ATC/Basico/mapas.php');

}

?>
