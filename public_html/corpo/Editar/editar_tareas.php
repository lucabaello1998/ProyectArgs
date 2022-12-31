<?php include("../../db.php"); ?>
<?php include('../include/header.php'); ?>
<!-----Deposito---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../indexcorpo.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
$CT= '';
$FECHA= '';
$TAREA= '';
$CLIENTE= '';
$ORDEN= '';
$ENLACE= '';
$ASIGNADO= '';
$CERTIFICACION= '';
$LINK_SYTEX= '';

if  (isset($_GET['ID'])) {
  $id = $_GET['ID'];
  $query = "SELECT * FROM corpo WHERE ID=$ID";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $CT = $row['CT'];
    $FECHA = $row['FECHA'];
    $TAREA = $row['TAREA'];
    $CLIENTE = $row['CLIENTE'];
    $ORDEN = $row['ORDEN'];
    $ENLACE = $row['ENLACE'];
    $ASIGNADO = $row['ASIGNADO'];    
    $CERTIFICACION = $row['CERTIFICACION'];
    $LINK_SYTEX = $row['LINK_SYTEX'];
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['ID'];
  
  $CT = $_POST['CT'];
  $FECHA = $_POST['FECHA'];
  $TAREA = $_POST['TAREA'];
  $CLIENTE = $_POST['CLIENTE'];
  $ORDEN = $_POST['ORDEN'];
  $ENLACE = $_POST['ENLACE'];
  $ASIGNADO = $_POST['ASIGNADO'];
  $CERTIFICACION = $_POST['CERTIFICACION'];
  $LINK_SYTEX = $_POST['LINK_SYTEX'];
  
  $query = "UPDATE corpo set CT = '$CT', FECHA = '$FECHA', TAREA = '$TAREA', CLIENTE = '$CLIENTE', ORDEN = '$ORDEN', ENLACE = '$ENLACE', ASIGNADO = '$ASIGNADO', CERTIFICACION = '$CERTIFICACION', LINK_SYTEX = '$LINK_SYTEX' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La orden " .$ORDEN ." fue actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/altas.php');


}

?>
<?php include('../includes/header.php'); ?>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <p class="h4 mb-4 text-center">Actualizar orden</p>
          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">ID</label >
              <select type="text" name="ID" class="form-control">                
                <option selected="0"><?php echo $tecnico; ?></option>                
                <?php
                  $ejecutar=mysqli_query($conn,"SELECT * FROM corpo WHERE 'ID'= $ID ORDER BY DESC");
                ?>
                <?php foreach ($ejecutar as $opciones): ?>   
                  <option value="<?php echo $opciones['ID'] ?>"><?php echo $opciones['ID'] ?></option>                                      
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">CT</label >
              <input type="text" name="CT" class="form-control" value="<?php echo $CT; ?>" placeholder="Actualice el numero de CT" autofocus>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">FECHA</label >
              <input type="text" name="FECHA" class="form-control" value="<?php echo $FECHA; ?>" placeholder="Actualice la FECHA" autofocus>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">LOCALIDAD</label >
              <select type="text" name="LOCALIDAD" class="form-control">
              <option selected><?php echo $TAREA; ?></option>
              <option value="CABA">CABA</option>
              <option value="Lomas de Zamora">Lomas de Zamora</option>
              <option value="Jose Leon Suarez">Jose Leon Suarez</option>
              <option value="San Nicolas">San Nicolas</option>
            </select>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">CLIENTE</label >
              <input type="text" name="id" name="CLIENTE" value="<?php echo $CLIENTE; ?>" placeholder="Actualice la CLIENTE" autofocus>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">ORDEN</label >
              <input type="text" name="ORDEN" class="form-control" value="<?php echo $ORDEN; ?>" placeholder="Actualice Nª DE ORDEN" autofocus>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">ENLACE</label >
              <input type="text" name="ENLACE" class="form-control" value="<?php echo $ENLACE; ?>" placeholder="Actualice el ENLACE" autofocus>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">ASIGNADO</label >
              <input type="text" name="ASIGNADO" class="form-control" value="<?php echo $ASIGNADO; ?>" placeholder="Actualice la ASIGNACION" autofocus>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">CERTIFICACION</label >
              <input type="text" name="CERTIFICACIION" class="form-control" value="<?php echo $CERTIFICACION; ?>" placeholder="Actualice el CERTIFICACION" autofocus>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">LINK_SYTEX</label >
              <input type="text" name="LINK_SYTEX" class="form-control" value="<?php echo $mac_uno_stb; ?>" placeholder="Actualice nº de SYTEX" autofocus>
            </div>
            <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar orden">

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
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<!-- Calendario -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#calendario").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#calendario" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
