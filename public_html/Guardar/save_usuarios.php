<?php
include('../db.php');
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo != "Administrador")
{
header("location: ../index.php");
}

if (isset($_POST['save_usuario']))
{
  $token = uniqid();
  $nombree = Renombre($_POST['nombre']);
  $nombreee = rtrim($nombree);
  $nombre = ltrim($nombreee);
  $apellidoo = Renombre($_POST['apellido']);
  $apellidooo = rtrim($apellidoo);
  $apellido = ltrim($apellidooo);
  $mail = $_POST['mail'];
  $tipo_us = $_POST['tipo_us'];
  $usuarioo = str_replace( " ", "", $_POST['usuario'] );
  $usuariooo = rtrim($usuarioo);
  $usuario = ltrim($usuariooo);
  $passs = str_replace( " ", "", $_POST['pass'] );
  $passss = rtrim($passs);
  $pass = ltrim($passss);
  $zona = $_POST['zona'];
  $arrayText = explode(" ", $zona);
  $acronym = "";
  foreach ($arrayText as $word)
  {
    $arrayLetters = str_split($word, 1);
    $acronym =  $acronym . $arrayLetters['0'];
  }
  $abreviatura = $acronym;
  
  $query = "INSERT INTO usuarios(token, nombre, apellido, mail, usuario, pass, tipo_us, zona, abreviatura) VALUES ('$token', '$nombre', '$apellido', '$mail', '$usuario', '$pass', '$tipo_us', '$zona', '$abreviatura')";
  $result = mysqli_query($conn, $query);
  if(!$result)
  {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El usuario de " .$nombre ." " .$apellido ." fue guardado.";
  $_SESSION['message_type'] = 'success';
  header('Location: ../Basico/usuarios.php');
}
?>