<?php include("../db.php");
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
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$material= '';
$cantidad= '';
$fecha= '';
$centro= '';


if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM materiales WHERE id=$id";
 $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $material = $row['material'];
    $cantidad = $row['cantidad'];
    $fecha = $row['fecha'];
    $centro = $row['centro'];
  }
}

if (isset($_POST['update']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token,
    quien,
    movimiento,
    pag,
    inicio,
    tipo,
    zona) VALUES ('$token_movi',
    '$quien_notas',
    'Editado',
    'Carga herramientas',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id = $_GET['id'];
  $material= $_POST['material'];
  $cantidad = $_POST['cantidad'];
  $fecha = $_POST['fecha'];
  $centro = $_POST['centro'];

  $query = "UPDATE materiales set material = '$material', cantidad = '$cantidad', fecha = '$fecha', centro = '$centro' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El " .$material  ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/cargam.php');
}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_cargam_individual.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar material</p>
              <div class="form-row align-items-end">
              <div class="form-group col">
                  <label for="exampleFormControlSelect1">Material</label >
                  <input type="text" name="material" class="form-control" value="<?php echo $material; ?>" placeholder="Actualice la material" autofocus>
                </div>

              </div>
              
              <div class="form-row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Cantidad</label >
                  <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" placeholder="Actualice el numeto de interaccion" autofocus>
                </div>
          
              <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Centro</label >
                  <select type="text" name="centro" class="form-control">
                  <option selected><?php echo $centro; ?></option>
                  <option value="Lomas de Zamora">Lomas de Zamora</option>
                  <option value="Jose Leon Suarez">Jose Leon Suarez</option>             
                </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="fecha" class="form-control" value="<?php echo $fecha; ?>" placeholder="Actualice la fecha" autofocus>
                </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar ingreso">
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
<!-- cantec -->
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
