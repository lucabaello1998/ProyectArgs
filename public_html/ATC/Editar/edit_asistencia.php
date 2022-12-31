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




if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM asistenciaatc WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombree = $row['nombre'];
    $fecha = $row['fecha'];
    $hora = $row['hora'];
    $dia = $row['dia'];
 

  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  
  $fechaa = $_POST['fechaa'];
  $horaa = $_POST['horaa'];
  $diaa = $_POST['diaa'];

  

  $query = "UPDATE asistenciaatc set nombre = '$nombree', fecha = '$fechaa', hora = '$horaa', dia = '$diaa' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El dia de " .$nombree ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../../ATC/Basico/asistencia.php');


}

?>

<?php include('../includesatc/headeratc.php'); ?>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../../ATC/Editar/edit_asistencia.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <p class="h4 mb-4 text-center">Actualizar el dia de <?php echo " " .$nombree; ?></p>
          <div class="form-row align-items-center">           
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Fecha</label >
              <input type="text" id="fecha" value="<?php echo $fecha; ?>" name="fechaa" readonly="" class="form-control">
            </div>
            <div class="form-group col">
                <label for="exampleFormControlSelect1">Inicio (<?php echo $hora; ?>)</label >
                <input type="text" class="form-control clockpicker" value="<?php echo $hora; ?>" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horaa" required>
            </div>
         
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Dia</label >
              <select type="text" name="diaa" class="form-control">
              <option selected><?php echo $dia; ?></option>
              <option>Presente</option>
              <option>Ausente</option>  
              <option>Justificado</option>
              <option>Ya no trabaja</option>
              <option>Aun no ingresa</option>
            </select>
            </div>
          </div>
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















