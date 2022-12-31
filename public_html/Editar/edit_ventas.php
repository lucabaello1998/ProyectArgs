<?php include("../db.php");

if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}
$nombrea = '';
$apellidoa= '';
$dni= '';
$contacto= '';
$direccion= '';
$entrecallea= '';
$entrecalleb= '';
$provincia= '';
$localidad= '';
$fecha= '';
$turno= '';
$instalacion= '';
$obs= '';


if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM ventas WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombrea = $row['nombre'];
    $apellidoa = $row['apellido'];
    $dni = $row['dni'];
    $contacto = $row['contacto'];
    $direccion = $row['direccion'];
    $entrecallea = $row['entrecallea'];
    $entrecalleb = $row['entrecalleb'];
    $provincia = $row['provincia'];
    $localidad = $row['localidad'];
    $fecha = $row['fecha'];
    $turno = $row['turno'];
    $instalacion = $row['instalacion'];
    $obs = $row['obs'];
    
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $nombrea= $_POST['nombrea'];
  $apellidoa = $_POST['apellidoa'];
  $dni = $_POST['dni'];
  $contacto = $_POST['contacto'];
  $direccion = $_POST['direccion'];
  $entrecallea = $_POST['entrecallea'];
  $entrecalleb = $_POST['entrecalleb'];
  $provincia = $_POST['provincia'];
  $localidad = $_POST['localidad'];
  $fecha = $_POST['fecha'];
  $turno = $_POST['turno'];
  $instalacion = $_POST['instalacion'];
  $obs = $_POST['obs'];


  $query = "UPDATE ventas set nombre = '$nombrea', apellido = '$apellidoa', dni = '$dni', contacto = '$contacto', direccion = '$direccion', entrecallea = '$entrecallea', entrecalleb = '$entrecalleb', provincia = '$provincia', localidad = '$localidad', fecha = '$fecha', turno = '$turno', instalacion = '$instalacion', obs = '$obs' WHERE id=$id";
   $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La visita de " .$nombre .' ' .$apellido ." fue actualizada.";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/ventas.php');


}

?>
<?php include('../includes/header.php'); ?>



<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="edit_ventas.php?id=<?php echo $_GET['id']; ?>" method="POST" data-toggle="validator">
          <p class="h4 mb-4 text-center">Carga de visita</p>

          <div class="form-row">
            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Nombre</label >
              <input type="text" name="nombrea" maxlength="70" class="form-control" autofocus  value="<?php echo $nombrea; ?>">
            </div> 

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Apellido</label >
              <input type="text" name="apellidoa" maxlength="70" class="form-control" autofocus value="<?php echo $apellidoa; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">DNI</label >
              <input type="number" name="dni" maxlength="70" class="form-control" autofocus  value="<?php echo $dni; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Contacto</label >
              <input type="number" name="contacto" maxlength="70" class="form-control" autofocus value="<?php echo $contacto; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Direccion</label >
              <input type="text" name="direccion" maxlength="70" class="form-control" autofocus value="<?php echo $direccion; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Entrecalle A</label >
              <input type="text" name="entrecallea" maxlength="70" class="form-control" autofocus value="<?php echo $entrecallea; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Entrecalle B</label >
              <input type="text" name="entrecalleb" maxlength="70" class="form-control" autofocus value="<?php echo $entrecalleb; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Provincia</label >
              <input type="text" name="provincia" maxlength="70" class="form-control" autofocus value="<?php echo $provincia; ?>">
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Localidad</label >
              <input type="text" name="localidad" maxlength="70" class="form-control" autofocus value="<?php echo $localidad; ?>">
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
              <input type="date" name="fecha" class="form-control" value="<?php echo $fecha; ?>">
            </div>     
            
            <div class="col">
              <legend class="col-form-label col">Turno</legend>
              <div class="col-sm">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="gridRadios1" value="AM" <?php if( $turno == 'AM'){echo 'checked';} ?>>
                  <label class="form-check-label" for="gridRadios1">
                    AM
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="gridRadios2" value="PM" <?php if( $turno == 'PM'){echo 'checked';} ?>>
                  <label class="form-check-label" for="gridRadios2">
                    PM
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group col">
              <label for="exampleFormControlSelect1">Instalacion</label >
              <select type="text" name="instalacion" class="form-control">
                <option selected value="<?php echo $instalacion; ?>"><?php echo $instalacion; ?></option>
                <option value="2P">2P</option>
                <option value="3P">3P</option>
                <option value="3P1D">3P1D</option>
                <option value="3P2D">3P2D</option>
                <option value="1D">1D</option>
                <option value="2D">2D</option>
                <option value="3D">3D</option>
              </select>
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Observaciones</label >
              <textarea type="text" maxlength="255" name="obs" class="form-control" autofocus><?php echo $obs; ?></textarea>
            </div>
          </div>
          <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar visita">
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
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 


</body>
</html>
