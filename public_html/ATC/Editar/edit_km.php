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

$fecha= '';
$hora= '';
$dia= '';
$fin= '';
$partido= '';
$km= '';
$reportes = '';
$obs= '';

if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM atckilometros WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombree = $row['nombre'];
    $fecha = $row['fecha'];
    $hora = $row['hora'];
    $fin = $row['fin'];
    $dia = $row['dia'];
    $partido = $row['partido'];
    $km = $row['km'];
    $reportes = $row['reportes'];
    $obs = $row['obs'];
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];  
  $horaa = $_POST['horaa'];
  $fina = $_POST['fina'];
  $diaa = $_POST['diaa'];
  $partidoa = $_POST['partidoa'];
  $kma = $_POST['kma'];
  $reportesa = $_POST['reportesa'];
  $obsa = $_POST['obsa'];

  $query = "UPDATE atckilometros set nombre = '$nombree', hora = '$horaa', fin = '$fina', dia = '$diaa', partido = '$partidoa', km = '$kma', obs = '$obsa', reportes = '$reportesa' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia de " .$nombree ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../../ATC/Basico/km.php');


}

?>

<?php include('../includesatc/headeratc.php'); ?>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../../ATC/Editar/edit_km.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <p class="h4 mb-4 text-center">Actualizar los kilometros de <?php echo " " .$nombree ." del " .$fecha; ?></p>
          <div class="form-row align-items-end">           
            <div class="form-group col">
                <label for="exampleFormControlSelect1">Inicio (<?php echo $hora; ?>)</label >
                <input type="text" class="form-control clockpicker" value="<?php echo $hora; ?>" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horaa" required>
            </div>
            <div class="form-group col">
                <label for="exampleFormControlSelect1">Fin (<?php echo $fin; ?>)</label >
                <input type="text" class="form-control fin" value="<?php echo $fin; ?>" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="fina" required>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Dia</label >
              <select type="text" name="diaa" class="form-control">
              <option selected><?php echo $dia; ?></option>
              <option>Dia normal</option>
              <option>Sabado</option> 
              <option>Feriado</option>
              <option>Ausente</option>
              <option>Medio dia</option>	
            </select>
            </div>
            <div class="form-group col">
              <label class="col-form-label">Km</label >
              <input type="number" name="kma" step="0.01" class="form-control" placeholder="Km del dia" value="<?php echo $km; ?>">
            </div>
            <div class="form-group col">
              <label class="col-form-label">Partido</label>
              <select type="text" name="partidoa" class="form-control form-control">
                <option selected><?php echo $partido; ?></option>
                <option value="Tres de Febrero" class="alert-warning">Tres de Febrero</option>
                <option value="La Matanza" class="alert-success">La Matanza</option>
                <option value="Moreno" class="alert-success">Moreno</option>
                <option value="Ituzaingo" class="alert-success">Ituzaingo</option>
                <option value="Hurlingham" class="alert-success">Hurlingham</option>
                <option value="Merlo" class="alert-success">Merlo</option>
                <option value="Moron" class="alert-success">Moron</option>
                <option value="San Miguel" class="alert-danger">San Miguel</option>
                <option value="Jose C Paz" class="alert-danger">Jose C Paz</option>
                <option value="Escobar" class="alert-danger">Escobar</option>
                <option value="Pilar" class="alert-danger">Pilar</option>
                <option value="San Isidro" class="alert-danger">San Isidro</option>
                <option value="San Martin" class="alert-danger">San Martin</option>
                <option value="Vicente Lopez" class="alert-danger">Vicente Lopez</option>
                <option value="Malvinas Argentinas" class="alert-danger">Malvinas Argentinas</option>
                <option value="Tigre" class="alert-danger">Tigre</option>
                <option value="San Fernando" class="alert-danger">San Fernando</option>
                <option value="Campana" class="alert-danger">Campana</option>
              </select>
          </div>
        </div>
        <div class="form-row align-items-end">           
          <div class="form-group col-12">
            <label>Reportes </label >
            <input type="number" name="reportesa" class="form-control" value="<?php echo $reportes; ?>">
          </div>
        </div>
        <div class="form-row align-items-end">
            <div class="col">
              <label class="col-form-label">Observaciones</label>
              <textarea type="text" name="obsa" maxlength="255" class="form-control" placeholder="Ingrese una observacion"><?php echo $obs; ?></textarea>
            </div>
          </div>
          <br>
          <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar dia">
        </form>
      </div>
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<!------Timepicker 1---->
<script src="../../clockpicker.js"></script>
<script type="text/javascript">
    var input = $('.clockpicker').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
</script>

<script src="../../clockpicker.js"></script>
<script type="text/javascript">
    var input = $('.fin').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
</script>

<!-- Calendario -->
<script src="../../jquery-3.3.1.min.js"></script>
<script src="../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>















