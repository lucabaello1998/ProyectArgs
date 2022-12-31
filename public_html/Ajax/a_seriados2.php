<?php
include("../db.php");
$html = '';
$key = $_POST['key'];
$result = mysqli_query($conn,"SELECT seriado FROM ingresomaterial WHERE seriado = '$key' AND cantidad = '1' ");
if(mysqli_num_rows($result) > 0)
{
  $html = 'si';
}
echo $html;