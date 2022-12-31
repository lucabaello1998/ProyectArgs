<?php
include("../../db.php");
$tipo_us = $_SESSION['tipo_us'];
$deposito = $_SESSION['zona'];
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
if($tipo_us == 'Tecnico')
{
  $quien_consultas = $quien_notas;
}
else
{
  $quien_consultas = $_SESSION['new_tec'];
}

$token = uniqid();
$quien = $_POST['quien'];
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
$consulta = Reemplazo($_POST['consulta']);

$consul = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE tecnico = '$quien_consultas' AND estado = 'Abierto'");
if (mysqli_num_rows($consul) >= 1)
{
  $row = mysqli_fetch_array($consul);
  $token_sesion = $row['token_sesion'];
  if($quien_notas == $row['tecnico'])
  {
    $tomado = '';
    $visto = '';
  }
  else
  {
    $tomado = $quien_notas;
    $visto = 'SI';
  }
}
else
{
  $token_sesion = uniqid();
  $row = mysqli_fetch_array($consul);
  if($quien_notas == $row['tecnico'])
  {
    $tomado = '';
    $visto = '';
  }
  else
  {
    $tomado = $quien_notas;
    $visto = 'SI';
  }
}

if($consulta !== '')
{
  $mm = mysqli_query($conn, "INSERT INTO mensajes_tec(token, token_sesion, consulta, quien, tecnico, tipo_us, estado, deposito, tomado, visto) VALUES ('$token', '$token_sesion', '$consulta', '$quien_notas', '$quien', '$tipo_us', 'Abierto', '$deposito', '$tomado', '$visto')");
}
if($mm)
{
  echo 'ok';
}
?>