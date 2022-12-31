<?php
include("../../db.php");
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
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}

$formatos = array('.jpg', '.jpeg', '.png', '.JPG', '.JPEG', '.PNG');

$nombrea= '';
$apellidoa= '';
$dnia= '';
$tela= '';
$tareaa= '';
$maila= '';
$usuarioa= '';
$passa= '';
$operativoa= '';
$enlacea = '';
$colora = '';
$num_empleado = '';
$inicioa = '';
$fina = '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $qq = "SELECT * FROM tecnicosatc WHERE id=$id";
  $aa = mysqli_query($conn, $qq);
  if (mysqli_num_rows($aa) == 1)
  {
    $row = mysqli_fetch_array($aa);
    $nombree = $row['nombre'];
    $apellidoe = $row['apellido'];
    $dnie = $row['dni'];
    $tele = $row['tel'];
    $tareae = $row['tarea'];
    $maile = $row['mail'];
    $usuarioe = $row['usuario'];
    $passe = $row['pass'];
    $operativoe = $row['operativo'];
    $enlacee = $row['enlace'].".jpg";
    $colore = $row['color'];
    $num_empleadoe = $row['num_empleado'];
    $inicioe = $row['inicio'];
    $fine = $row['fin'];
  }
}

if (isset($_POST['update']))
{
  $id = $_GET['id'];
  $nombrea = $_POST['nombrea'];
  $apellidoa = $_POST['apellidoa'];
  $dnia = $_POST['dnia'];
  $tela = $_POST['tela'];
  $tareaa = $_POST['tareaa'];
  $usuarioa = $_POST['usuarioa'];
  $maila = $_POST['maila'];
  $passa = $_POST['passa'];
  $operativoa = $_POST['operativoa'];
  $colora = $_POST['colora'];
  $num_empleadoa = $_POST['num_empleadoa'];
  $inicioa = $_POST['inicioa'];
  $fina = $_POST['fina'];

  if ($_FILES['archivo']['name'] != null)
  {
    $enlacea = $_POST['nombrea'] ."_" .$_POST['apellidoa'];
    /////ACTUALIZAR ARCHIVO//////     
    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
    $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
    $jpg = $_POST['nombrea'] ."_" .$_POST['apellidoa'];
    if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
    {
      if ($_FILES['archivo']['size']<800000)
      {
        if (move_uploaded_file($nombreTmpArchivo, "../Archivos/tecnicos/$jpg" .".jpg"))
        {        
                          
          $msg = "Los datos de " .$nombrea ." " .$apellidoa ." fueron actualizados"; 
          $msgColor = "warning";      

          $ss = "UPDATE tecnicosatc set nombre = '$nombrea', apellido = '$apellidoa', dni = '$dnia', tel = '$tela', tarea = '$tareaa', mail = '$maila', usuario = '$usuarioa', pass = '$passa', operativo = '$operativoa', enlace = '$enlacea', color = '$colora', num_empleado = '$num_empleadoa', inicio = '$inicioa', fin = '$fina' WHERE id=$id";
          $result = mysqli_query($conn, $ss);

          $jpg = $row['archivo'].".jpg";
          $filename = "../Archivos/tecnicos/$enlacee";
          if (file_exists($filename))
          {
            $success = unlink($filename);           
          }


          if(!$result) 
          {
            $msg ="Error en el servidor, recuerde subir correctamente el archivo.";
            $msgColor = "danger";
          }
        }
        else
        {
        $msg = "Error, intentamente nuevamente";
        $msgColor = "danger";
        }
      }
      else
      {
        $msg = "El archivo que intenta subir es muy pesado";
        $msgColor = "danger";
      }
    }
    else
    {
    $msg = "Falta la imagen de la credencial.";
    $msgColor = "danger";
    }   
      /////ACTUALIZAR ARCHIVO//////
      $_SESSION['card'] = 1;
      $_SESSION['message'] = $msg;
      $_SESSION['message_type'] = $msgColor;
      header('Location: ../../ATC/Basico/tecnicosatc.php');
  }
  else
  {
    $zz = "UPDATE tecnicosatc set nombre = '$nombrea', apellido = '$apellidoa', dni = '$dnia', tel = '$tela', tarea = '$tareaa', mail = '$maila', usuario = '$usuarioa', pass = '$passa', operativo = '$operativoa', color = '$colora', num_empleado = '$num_empleadoa', inicio = '$inicioa', fin = '$fina' WHERE id=$id";
    mysqli_query($conn, $zz);
    $msg = "Los datos de " .$nombrea ." " .$apellidoa ." fueron actualizados a excepcion de la credencial";
    $msgColor = "warning";
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../../ATC/Basico/tecnicosatc.php');
  }
}
?>

<?php include('../../ATC/includesatc/headeratc.php'); ?>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../../ATC/Editar/edit_tecnicosatc.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
          <p class="h4 mb-4 text-center">Actualizar el tecnico<?php echo " " .$nombree ." " .$apellidoe ; ?></p>
          <div class="form-row align-items-center">           
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Nombre</label >
              <input type="text" name="nombrea" class="form-control" value="<?php echo $nombree; ?>"  autofocus>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Apellido</label >
              <input type="text" name="apellidoa" class="form-control" value="<?php echo $apellidoe; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Operativo</label >
              <select type="text" name="operativoa" class="form-control">
              <option selected><?php echo $operativoe; ?></option>
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Num ATC</label >
              <input type="number" name="num_empleadoa" class="form-control" value="<?php echo $num_empleadoe; ?>" >
            </div>         
          </div>

          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="tecnicoatc">DNI</label>
              <input type="number" name="dnia" maxlength="11" value="<?php echo $dnie; ?>" class="form-control" >
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Telefono</label>
              <input type="number" name="tela" maxlength="11" value="<?php echo $tele; ?>" class="form-control" >
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Tareas</label>
              <input type="text" name="tareaa" maxlength="80" value="<?php echo $tareae; ?>" class="form-control" >
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Inicio</label>
              <input type="date" name="inicioa" value="<?php echo $inicioe; ?>" class="form-control" >
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Fin</label>
              <input type="date" name="fina" value="<?php echo $fine; ?>" class="form-control">
            </div>
          </div>

          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="tecnicoatc">Actualizar cedencial</label>
              <input type="file" accept="image/jpeg" class="form-control-file" name="archivo" id="archivo">
          </div>
          <div class="form-group col-4">
              <div class="form-row justify-content-center">
                <input class="p-0" name="colora" id="colora" type="color" value="<?php echo $colore; ?>">
              </div>
            </div>
          </div>

          <div class="form-row align-items-center">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Usuario</label >
              <input type="text" name="usuarioa" class="form-control" value="<?php echo $usuarioe; ?>" autofocus>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Contraseña</label >
              <input type="text" name="passa" class="form-control" value="<?php echo $passe; ?>" autofocus>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Mail</label >
              <input type="text" name="maila" class="form-control" value="<?php echo $maile; ?>" autofocus>
            </div>
          </div>
          <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar tecnico">
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>















