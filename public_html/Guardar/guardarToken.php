<?php
  include('../db.php');
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];

  if  (isset($_POST['firebase']))
  {
    $firebase = $_POST['firebase'];
    $resultado_editar_token = mysqli_query($conn, "UPDATE usuarios set firebase = '$firebase' WHERE nombre = '$nombre' AND apellido = '$apellido'");
    if(!$resultado_editar_token)
    { die("resultado_editar_token Failed."); }  
  }
?>
