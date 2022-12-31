<?php
include("../db.php");
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
if($usu != 1)
{
  header("location: ../index.php");
}
$fecha= '';
$dosplay= '';
$tresplay= '';
$stb= '';
$mudanza= '';
$tcumplida= '';
$tareasmtto= '';
$garantec= '';
$garancom= '';
$reclamo= '';
$zona= '';
$bajas= '';
$obs= '';
$bajatec= '';
$baja_desmonte= '';
$mtto_int= '';
$mtto_ext= '';
$dia= '';
$mtto_reaco= '';


if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM produccion WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];    
    $fecha = $row['fecha'];   
    $dosplay = $row['dosplay'];
    $tresplay = $row['tresplay'];
    $stb = $row['stb'];
    $mudanza = $row['mudanza'];
    $tcumplida = $row['tcumplida']; 
    $tareasmtto = $row['tareasmtto']; 
    $garantec = $row['garantec'];   
    $garancom = $row['garancom'];
    $reclamo = $row['reclamo'];
    $zona = $row['zona']; 
    $bajas = $row['bajas'];   
    $obs = $row['obs'];
    $bajatec = $row['bajatec'];
    $baja_desmonte = $row['baja_desmonte'];
    $mtto_int = $row['mtto_int'];
    $mtto_ext = $row['mtto_ext'];
    $dia = $row['dia'];
    $mtto_reaco = $row['mtto_reaco'];
  }
}

if (isset($_POST['updateb'])) {
   $id = $_GET['id'];
  $fecha = $_POST['fecha'];  
  $dosplay = $_POST['dosplay'];
  $tresplay = $_POST['tresplay'];
  $stb = $_POST['stb'];
  $mudanza = $_POST['mudanza'];
  $tcumplida = $_POST['tcumplida'];
  $tareasmtto = $_POST['tareasmtto'];
  $garantec = $_POST['garantec'];  
  $garancom = $_POST['garancom'];
  $reclamo = $_POST['reclamo'];
  $zona = $_POST['zona'];  
  $bajas = $_POST['bajas']; 
  $obs = $_POST['obs'];
  $bajatec = $_POST['bajatec'];
  $baja_desmonte = $_POST['baja_desmonte'];
  $mtto_int = $_POST['mtto_int'];
  $mtto_ext = $_POST['mtto_ext'];
  $dia = $_POST['dia'];
  $mtto_reaco = $_POST['mtto_reaco'];

  $query = "UPDATE produccion set fecha = '$fecha', dosplay = '$dosplay', tresplay = '$tresplay', stb = '$stb', mudanza = '$mudanza', tcumplida = '$tcumplida', tareasmtto = '$tareasmtto', garantec = '$garantec', garancom = '$garancom', reclamo = '$reclamo', zona = '$zona', bajas = '$bajas', obs = '$obs', bajatec = '$bajatec', baja_desmonte = '$baja_desmonte', mtto_int = '$mtto_int', mtto_ext = '$mtto_ext', dia = '$dia', mtto_reaco = '$mtto_reaco' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La produccion de " .$tecnico ." fue actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/produccion.php');

}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_produccion.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Carga de <?php echo $tecnico; ?></p>
              <div class="form-row align-items-end">            
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="text" id="fecha" value="<?php echo $fecha; ?>" name="fecha" readonly="" class="form-control">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Dia</label >
                    <select type="text" name="dia" class="form-control">
                      <option selected><?php echo $dia; ?></option>
                      <option value="Normal">Normal</option> 
                      <option value="Ausente">Ausente</option>
                      <option value="Sabado">Sabado</option>
                      <option value="Feriado">Feriado</option>
                      <option value="Vacaciones">Vacaciones</option>
                      <option value="Licencia">Licencia</option>
                      <option value="Suspension">Suspension</option>
                      <option value="Dia libre">Dia libre</option>
                      <option value="Vehiculo roto">Vehiculo roto</option>
                    </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Zona</label >
                    <select type="text" name="zona" class="form-control">
                    <option selected><?php echo $zona; ?></option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
              </div>
              <div class="row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Doble play</label >
                  <input type="number" name="dosplay" class="form-control" value="<?php echo $dosplay; ?>">
                </div>

                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Triple play</label >
                  <input type="number" name="tresplay" class="form-control" value="<?php echo $tresplay; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Set to Box</label >
                  <input type="number" name="stb" class="form-control" value="<?php echo $stb; ?>">
                </div>

                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Mudanzas internas</label >
                  <input type="number" name="mudanza" class="form-control" value="<?php echo $mudanza; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Tareas cumplidas</label >
                  <input type="number" name="tcumplida" class="form-control" value="<?php echo $tcumplida; ?>">
                </div>
              </div>
              <div class="row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Bajas</label >
                  <input type="number" name="bajas" class="form-control" value="<?php echo $bajas; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Garantias del tecnico</label >
                  <input type="number" name="garantec" class="form-control" value="<?php echo $garantec; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Garantias compañero</label >
                  <input type="number" name="garancom" class="form-control" value="<?php echo $garancom; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Reclamos</label >
                  <input type="number" name="reclamo" class="form-control" value="<?php echo $reclamo; ?>">
                </div>
              </div>
              <div class="row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Bajas tecnica</label >
                  <input type="number" name="bajatec" class="form-control" value="<?php echo $bajatec; ?>">
                </div>           
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Bajas con desmonte</label >
                  <input type="number" name="baja_desmonte" class="form-control" value="<?php echo $baja_desmonte; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Reacondicionamiento</label >
                  <input type="number" name="mtto_reaco" class="form-control" value="<?php echo $mtto_reaco; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Mtto interno</label >
                  <input type="number" name="mtto_int" class="form-control" value="<?php echo $mtto_int; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Mtto externo</label >
                  <input type="number" name="mtto_ext" class="form-control" value="<?php echo $mtto_ext; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Mtto cumplidos</label >
                  <input type="number" name="tareasmtto" class="form-control" value="<?php echo $tareasmtto; ?>">
                </div>

              </div>
              <div class="row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Observaciones</label >
                  <textarea type="text" name="obs" class="form-control"><?php echo $obs; ?></textarea> 
                </div>
              </div>
              <input type="submit" name="updateb" class="btn btn-success btn-block" value="Actualizar dia">

            </form>
          </div>
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
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
<!------Timepicker 1---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
    var input = $('.clockpicker').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 2---->
    <script src="../clockpicker.js"></script>
    <script type="text/javascript">
     var input = $('.tarea').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 3---->
    <script src="../clockpicker.js"></script>
    <script type="text/javascript">
      var input = $('.fin').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'});
      </script>
      <!-- Calendario -->
      <script src="../jquery-3.3.1.min.js"></script>
      <script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
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
