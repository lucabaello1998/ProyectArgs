<?php
include("../../db.php");
$tipo_us = $_SESSION['tipo_us'];
$deposito = $_SESSION['zona'];
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
$token_sesion = $_SESSION['token_sesion'];

$msn_c = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE token_sesion = '$token_sesion' LIMIT 1");
while($row = mysqli_fetch_array($msn_c))
{
  $quien = $row['tecnico'];
}

/////////////IMAGEN 1////////////////////
$formatos = array('.jpg', '.jpeg', '.png');
$token_movi = uniqid();
if ($_FILES['imagen']['name'] != null)
{     
  $imagen1 = $token_movi ."-" ."img1";
  $nombreArchivo1 = $_FILES['imagen']['name'];
  $nombreTmpArchivo1 = $_FILES['imagen']['tmp_name'];
  $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
  if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
  {
    if($_FILES['imagen']['size'] < 9000000 )
    {
      if (move_uploaded_file($nombreTmpArchivo1, "../../Archivos/mensajes/" .$imagen1 .$ext1))
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
/////////////IMAGEN 1////////////////////

$token = uniqid();
$consulta = Reemplazo($_POST['consulta']);

if($consulta !== '')
{
  if($_FILES['imagen1']['name'] != null)
  {
    $mm = mysqli_query($conn, "INSERT INTO mensajes_tec(token, token_sesion, consulta, quien, tecnico, tipo_us, estado, deposito, tomado, visto) VALUES ('$token', '$token_sesion', '$imagenpri', '$quien_notas', '$quien', '$tipo_us', 'Abierto', '$deposito', '$quien_notas', 'NO')");
  }
  else
  {
    $mm = mysqli_query($conn, "INSERT INTO mensajes_tec(token, token_sesion, consulta, quien, tecnico, tipo_us, estado, deposito, tomado, visto) VALUES ('$token', '$token_sesion', '$consulta', '$quien_notas', '$quien', '$tipo_us', 'Abierto', '$deposito', '$quien_notas', 'NO')");
  }
}
if($mm)
{
  echo 'ok';
}
?>