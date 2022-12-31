<?php include("../../db.php"); 
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "ATC") { $usu = 1; }
if($usu != 1)
{
  header("location: ../../inicio.php");
}
$formatos = array('.kml');
$nombrea= '';
$zonaa= '';
$partidoa= '';
$localidada= '';
$ordena= '';
$kma= '';
$enlacea = '';
$tareaa = '';
$estadoa = '';
$colora = '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM atcmapas WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombree = $row['nombre'];
    $partidoe = $row['partido'];    
    $ordene = $row['orden'];
    $kme = $row['km'];
    $localidade = $row['localidad'];
    $enlacee = $row['enlace'];
    $tareae = $row['tarea'];
    $estadoe = $row['estado'];
    $colore = $row['color'];
  }
}

if (isset($_POST['update']))
{
  $id = $_GET['id'];
  $nombrea = $_POST['nombrea'];
  $partidoa = $_POST['partidoa'];
  if ( $_POST['partidoa']== "La Matanza"  || $_POST['partidoa']== "Moreno"  || $_POST['partidoa']== "Ituzaingo"  || $_POST['partidoa']== "Hurlingham"  || $_POST['partidoa']== "Merlo"  || $_POST['partidoa']== "Moron"  || $_POST['partidoa']== "Tres de Febrero" )
  {
    $zonaa = "Oeste";
  }
  else
  {
    $zonaa = "Norte";
  }
  $ordena = $_POST['ordena'];
  $kma = $_POST['kma'];
  $localidada = $localidade;
  $tareaa = $tareae;
  $estadoa = $_POST['estadoa'];
  $colora = $_POST['colora'];

  if ($_FILES['archivo']['name'] != null)
  {

    if ($enlacee == "")
    {
      $enlacea = uniqid();
    }
    else
    {
      $enlacea = $enlacee;
    }
    /////ACTUALIZAR ARCHIVO//////     
      $nombreArchivo = $_FILES['archivo']['name'];
      $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
      $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
      $kml = $enlacea;
      if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
      {
        if ($_FILES['archivo']['size']<800000)
        {
          if (move_uploaded_file($nombreTmpArchivo, "../Archivos/mapas/$kml" .".kml"))
          {        
                            
            $msg = "Los datos de " .$tareae ." fueron actualizados."; 
            $msgColor = "warning";      

            $query = "UPDATE atcmapas set nombre = '$nombrea', zona = '$zonaa', partido = '$partidoa', localidad = '$localidada', orden = '$ordena', km = '$kma', tarea = '$tareaa' ,estado = '$estadoa', enlace = '$enlacea', color = '$colora' WHERE id=$id";
            $result = mysqli_query($conn, $query);

            $filename = "../Archivos/mapas/$enlacea";
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
          $msg = "Error, intentamente nuevamente.";
          $msgColor = "danger";
          }
        }
        else
        {
          $msg = "El archivo que intenta subir es muy pesado.";
          $msgColor = "danger";
        }
      }
      else
      {
      $msg = "Falta el mapa.";
      $msgColor = "danger";
      }   
    /////ACTUALIZAR ARCHIVO//////
  }
  else
  { 
    $query = "UPDATE atcmapas set nombre = '$nombrea', zona = '$zonaa', zona = '$zonaa', partido = '$partidoa', orden = '$ordena', km = '$kma',estado = '$estadoa', enlace = '$enlacee', color = '$colora' WHERE id=$id";
    mysqli_query($conn, $query);

    $msg = "Los datos de " .$tareae ." fueron actualizados a excepcion del mapa";
    $msgColor = "warning";  
  }
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../../ATC/Basico/mapas.php');
}
?>
<?php include('../includesatc/headeratc.php'); ?>

  <div class="container p-2">
    <div class="row">
      <div class="col-lg">
        <div class="card card-body">
          <form action="../../ATC/Editar/edit_mapa.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
            <p class="h4 mb-4 text-center">Actualizar el mapa de<?php echo " " .$nombree ; ?></p>
            <div class="form-row align-items-center">           
              <div class="form-group col-6">
                <label for="exampleFormControlSelect1">Nombre</label >
                <input type="text" name="nombrea" class="form-control" value="<?php echo $nombree; ?>"  autofocus>
              </div>
              <div class="form-group col-sm">
                <label for="exampleFormControlSelect1">Partido</label >
                <select type="text" name="partidoa" class="form-control">
                  <option selected><?php echo $partidoe; ?></option>
                  <option value="Campana">Campana</option>
                  <option value="Escobar">Escobar</option>
                  <option value="Hurlingham">Hurlingham</option>
                  <option value="Ituzaingo">Ituzaingo</option>
                  <option value="Jose C Paz">Jose C Paz</option>
                  <option value="La Matanza">La Matanza</option>
                  <option value="Malvinas Argentinas">Malvinas Argentinas</option>
                  <option value="Merlo">Merlo</option>
                  <option value="Moreno">Moreno</option>
                  <option value="Moron">Moron</option>
                  <option value="Pilar">Pilar</option>
                  <option value="San Fernando">San Fernando</option>
                  <option value="San Isidro">San Isidro</option>
                  <option value="San Martin">San Martin</option>
                  <option value="San Miguel">San Miguel</option>
                  <option value="Tigre">Tigre</option>
                  <option value="Tres de Febrero">Tres de Febrero</option>
                  <option value="Vicente Lopez">Vicente Lopez</option>
                </select>
              </div>         
            </div>

            <div class="form-row align-items-end">
              <div class="form-group col-4">
                <label for="tecnicoatc">Kilometros</label>
                <input type="number" name="kma" maxlength="80" pattern="[0-9_-.]{1-6}" step="0.001" value="<?php echo $kme; ?>" class="form-control" autofocus>
              </div>
              <div class="form-group col-4">
                <label for="tecnicoatc">Orden</label>
                <input type="number" name="ordena" maxlength="80" pattern="[0-9_-.]{1-6}" step="0.001" value="<?php echo $ordene; ?>" class="form-control" autofocus>
              </div>
              <div class="form-group col-sm">
                <label for="exampleFormControlSelect1">Estado</label >
                <select type="text" name="estadoa" class="form-control">
                  <option selected><?php echo $estadoe; ?></option>
                  <option value="Pendiente">Pendiente</option>
                  <option value="En proceso">En proceso</option>
                  <option value="Completado">Completado</option>                
                </select>
              </div>
              <div class="form-group col-4">
                <div class="form-row justify-content-center">
                  <input class="p-0" name="colora" id="colora" type="color" value="<?php echo $colore; ?>">
                </div>
              </div>
            </div>

            <div class="form-row align-items-end">
              <div class="form-group col">
                <label for="tecnicoatc">Actualizar mapa (kml)</label>
                <input type="file" accept=".kml" class="form-control-file" name="archivo" id="archivo">
              </div>
            </div>
            <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar mapa">
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bofechastrap -->
<script src="https://stackpath.bofechastrapcdn.com/bofechastrap/4.4.1/js/bofechastrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>