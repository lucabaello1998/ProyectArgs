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

if  (isset($_GET['id'])) {
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
  $localidada = $_POST['localidada'];
  if ($_POST['localidada']== "Caseros" || $_POST['localidada']== "Ciudad Jardín" || $_POST['localidada']== "Ciudadela" || $_POST['localidada']== "Martin Coronado" || $_POST['localidada']== "Santos Lugares" || $_POST['localidada']== "Jose Ingeniero" || $_POST['localidada']== "Saenz Peña" || $_POST['localidada']== "Villa Bosch" || $_POST['localidada']== "Villa Raffo" )
  {
    $partidoa = "Tres de Febrero";
    $zonaa = "Oeste";
  }
  if ($_POST['localidada']== "Villa Sarmiento" || $_POST['localidada']== "Moron" || $_POST['localidada']== "Castelar" || $_POST['localidada']== "El Palomar" || $_POST['localidada']== "Haedo" )
  {
    $partidoa = "Moron";
    $zonaa = "Oeste";
  }
  if ($_POST['localidada']== "Hurlingham" || $_POST['localidada']== "Villa Tesei" || $_POST['localidada']== "Williams Morris")
  {
    $partidoa = "Hurlingham";
    $zonaa = "Oeste";
  }
  if ($_POST['localidada']== "Vicente Lopez" || $_POST['localidada']== "Carapachay" || $_POST['localidada']== "Florida" || $_POST['localidada']== "Florida Oeste" || $_POST['localidada']== "La Lucila" || $_POST['localidada']== "Munro" || $_POST['localidada']== "Olivos" || $_POST['localidada']== "Villa Adelina" || $_POST['localidada']== "Villa Martelli")
  {
    $partidoa = "Vicente Lopez";
    $zonaa = "Norte";
  }
  if ($_POST['localidada']== "San Fernando" || $_POST['localidada']== "TigreSF" || $_POST['localidada']== "Victoria" || $_POST['localidada']== "Virreyes")
  {
    $partidoa = "San Fernando";
    $zonaa = "Norte";
  }
  if ($_POST['localidada']== "Localidad...")
  {
    $partidoa = "";
    $zonaa = "";
  }
  if ($_POST['localidada']== "Benavidez" || $_POST['localidada']== "General pacheco" || $_POST['localidada']== "Garin" || $_POST['localidada']== "Ingeniero Maschwitz" || $_POST['localidada']== "Don Torcuato" || $_POST['localidada']== "El Talar" || $_POST['localidada']== "Ricardo Rojas" || $_POST['localidada']== "Toncos del Talar" )
  {
    $partidoa = "Tigre";
    $zonaa = "Norte";
  }
  if ($_POST['localidada']== "Billinghurst" || $_POST['localidada']== "Jose Leon Suarez" || $_POST['localidada']== "Lomas Hermosa" || $_POST['localidada']== "San Andres" || $_POST['localidada']== "San Martin Centro" || $_POST['localidada']== "Villa Ballester" || $_POST['localidada']== "Villa Libertad" || $_POST['localidada']== "Villa Lynch" || $_POST['localidada']== "Villa Maipu" )
  {
    $partidoa = "San Martin";
    $zonaa = "Oeste";
  }
  if ($_POST['localidada']== "Escobar" )
  {
    $partidoa = "Escobar";
    $zonaa = "Norte";
  }

  $ordena = $_POST['ordena'];
  $kma = $_POST['kma'];
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

          $query = "UPDATE atcmapas set nombre = '$nombrea', zona = '$zonaa', partido = '$partidoa', localidad = '$localidada', orden = '$ordena', km = '$kma', tarea = '$tareaa',estado = '$estadoa', enlace = '$enlacea', color = '$colora' WHERE id=$id";
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
    $query_m = "UPDATE atcmapas set nombre = '$nombrea', zona = '$zonaa', zona = '$zonaa', partido = '$partidoa', localidad = '$localidada', orden = '$ordena', km = '$kma', estado = '$estadoa', enlace = '$enlacee', color = '$colora' WHERE id=$id";
    $update_map = mysqli_query($conn, $query_m);
    if (!$update_map)
    {
      $msg ="Error en el servidor.";
      $msgColor = "danger";
    }
    else
    {
      $msg = "Los datos de " .$tareae ." fueron actualizados a excepcion del mapa";
      $msgColor = "warning";
    }
  }
  
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../Basico/mapas.php');
}
?>

<?php include('../includesatc/headeratc.php'); ?>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../Editar/edit_mapa_gpon.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
          <p class="h4 mb-4 text-center">Actualizar el mapa de<?php echo " " .$nombree ; ?></p>
          <div class="form-row align-items-center">           
            <div class="form-group col-6">
              <label for="exampleFormControlSelect1">Nombre</label >
              <input type="text" name="nombrea" class="form-control" value="<?php echo $nombree; ?>"  autofocus>
            </div>
            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Localidad</label >
              <select type="text" name="localidada" class="form-control">
                <option selected><?php echo $localidade; ?></option>
                <option value="Caseros" class="alert-warning">Caseros</option>
                <option value="Ciudad Jardin" class="alert-warning">Ciudad Jardin</option>
                <option value="Ciudadela" class="alert-warning">Ciudadela</option>
                <option value="Jose Ingeniero" class="alert-warning">Jose Ingeniero</option>
                <option value="Martin Coronado" class="alert-warning">Martin Coronado</option>
                <option value="Saenz Peña" class="alert-warning">Saenz Peña</option>
                <option value="Santos Lugares" class="alert-warning">Santos Lugares</option>
                <option value="Villa Bosch" class="alert-warning">Villa Bosch</option>
                <option value="Villa Raffo" class="alert-warning">Villa Raffo</option>
                <option value="Castelar" class="alert-success">Castelar</option>
                <option value="El Palomar" class="alert-success">El Palomar</option>
                <option value="Haedo" class="alert-success">Haedo</option>
                <option value="Moron" class="alert-success">Moron</option>
                <option value="Villa Sarmiento" class="alert-success">Villa Sarmiento</option>                
                <option value="Benavidez" class="alert-danger">Benavidez</option>
                <option value="Garin" class="alert-danger">Garin</option>
                <option value="General pacheco" class="alert-danger">General pacheco</option>
                <option value="Ingeniero Maschwitz" class="alert-danger">Ingeniero Maschwitz</option>
                <option value="Don Torcuato" class="alert-danger">Don Torcuato</option>
                <option value="El Talar" class="alert-danger">El Talar</option>
                <option value="Ricardo Rojas" class="alert-danger">Ricardo Rojas</option>
                <option value="Toncos del Talar" class="alert-danger">Toncos del Talar</option>
                <option value="Hurlingham" class="alert-success">Hurlingham</option>
                <option value="Villa Tesei" class="alert-success">Villa Tesei</option>
                <option value="Williams Morris" class="alert-success">Williams Morris</option>
                <option value="San Fernando" class="alert-danger">San Fernando</option>
                <option value="TigreSF" class="alert-danger">TigreSF</option>
                <option value="Victoria" class="alert-danger">Victoria</option>
                <option value="Virreyes" class="alert-danger">Virreyes</option>
                <option value="Carapachay" class="alert-info">Carapachay</option>
                <option value="Florida" class="alert-info">Florida</option>
                <option value="Florida Oeste" class="alert-info">Florida Oeste</option>
                <option value="La Lucila" class="alert-info">La Lucila</option>
                <option value="Munro" class="alert-info">Munro</option>
                <option value="Olivos" class="alert-info">Olivos</option>
                <option value="Vicente Lopez" class="alert-info">Vicente Lopez</option>
                <option value="Villa Adelina" class="alert-info">Villa Adelina</option>
                <option value="Villa Martelli" class="alert-info">Villa Martelli</option>
                <option value="Escobar" class="alert-warning">Escobar</option>
                <option value="Billinghurst" class="alert-success">Billinghurst</option>
                <option value="Jose Leon Suarez" class="alert-success">Jose Leon Suarez</option>
                <option value="Lomas Hermosa" class="alert-success">Lomas Hermosa</option>
                <option value="San Andres" class="alert-success">San Andres</option>
                <option value="San Martin Centro" class="alert-success">San Martin Centro</option>
                <option value="Villa Ballester" class="alert-success">Villa Ballester</option>
                <option value="Villa Libertad" class="alert-success">Villa Libertad</option>
                <option value="Villa Lynch" class="alert-success">Villa Lynch</option>
                <option value="Villa Maipu" class="alert-success">Villa Maipu</option>            
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
            <div class="form-group col-4">
              <div class="form-row justify-content-center">
                <input class="p-0" name="colora" id="colora" type="color" value="<?php echo $colore; ?>">
              </div>
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