<?php
include("../db.php");
session_start();
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien_notas = $nombre .' ' .$apellido;
$token = $_POST['token'];
if ($_FILES['adjunto']['name'] != null)
  {
    $mensaje = '00000';
  }
  else
  {
    $mensaje = Reemplazo($_POST['mensajes']);
  }
$quien = $_POST['quien'];
$titulo = $_POST['titulo'];
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
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$prioridad = $_POST['prioridad'];
if($mensaje !== '')
{
  mysqli_query($conn, "INSERT INTO tareas(token, mensaje, quien, titulo, prioridad, tarea, abreviado, inicio, fin) VALUES ('$token', '$mensaje', '$quien_notas', '$titulo', '$prioridad', '$tarea', '$abreviado', '$inicio', '$fin')");
}
echo 'ok';
?>