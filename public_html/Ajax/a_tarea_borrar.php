<?php
include("../db.php");
$id = $_POST['id'];
mysqli_query($conn, "DELETE FROM tareas WHERE id = '$id'");
echo 'ok';
?>