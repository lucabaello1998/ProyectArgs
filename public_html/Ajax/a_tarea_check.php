<?php
include("../db.php");
$id = $_POST['id'];

$s = mysqli_query($conn, "SELECT * FROM tareas WHERE id = '$id'");
while($r = mysqli_fetch_assoc($s))
{
  if($r['sub_estado'] == 'Finalizado')
  {
    mysqli_query($conn, "UPDATE tareas set sub_estado = 'Pendiente' WHERE id = '$id'");
  }
  else
  {
    mysqli_query($conn, "UPDATE tareas set sub_estado = 'Finalizado' WHERE id = '$id'");
  }
}

echo 'checking';
?>