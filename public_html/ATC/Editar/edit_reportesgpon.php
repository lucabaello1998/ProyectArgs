<?php include("../../db.php"); ?>

<!-----Deposito---->
<?php
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
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}

if (isset($_POST['actualizar'])) {
  $id = $_GET['id'];
  $partido = $_POST['partido'];
  $localidad = $_POST['localidad'];
  $direccion_manual = $_POST['direccion_manual'];
  $prioridad = $_POST['prioridad'];
  $tarea = $_POST['tarea'];

  

  $query = "UPDATE atcreportesgpon set partido = '$partido', localidad = '$localidad', direccion_manual = '$direccion_manual', prioridad = '$prioridad' WHERE id=$id";
  $resultado = mysqli_query($conn, $query);
  if (!$resultado)
  {
    $msg ="Error en el servidor.";
    $msgColor = "danger";
  }
  else
  {
    $msg ="El reporte " .$tarea ." fue actualizado";
    $msgColor = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../../ATC/indexatc.php');


}

?>
















