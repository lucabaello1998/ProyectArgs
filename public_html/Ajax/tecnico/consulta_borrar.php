<?php
  include("../../db.php");
  $id = $_POST['id'];

  $delete = mysqli_query($conn, "DELETE FROM mensajes_tec WHERE id = '$id'");
  if($delete)
  {
    echo 'ok';
  }
?>