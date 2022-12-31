<?php
include("../db.php");
session_start();
if(!$_SESSION['tipo_us'])
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
if($tipo == "Visor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$tecnico = '';
$fechaegre= '';
$centro= '';
$cantidad= '';
$material= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM entregamaterial WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fechaegre = $row['fechaegre'];
    $centro = $row['centro'];
    $cantidad = $row['cantidad'];
    $material = $row['material'];
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
    'Egreso herramientas',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id = $_GET['id'];
  $tecnico = $row['tecnico'];
  $fechaaegre = $row['fechaaegre'];
  $centro = $row['centro'];
  $cantidad = $row['cantidad'];
  $material = $row['material'];

  $query = "UPDATE entregamaterial set tecnico = '$tecnico', fechaegre = '$fechaaegre', centro = '$centro', centidad = '$centidad', material = '$material' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = 'Entrega actualizada';
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
            <form action="edit_herramienta_egreso.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar entrega de material</p>
              <div class="form-row">
                <div class="form-group col-sm">
                    <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">                
                      <option selected><?php echo $tecnico; ?></option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>
                      <?php endforeach ?>
                  </select>
                </div> 
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha de entrega</label >
                  <input type="date" name="fechaaegre" value="<?php echo $fechaegre; ?>" class="form-control" >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Centro deposito</label >
                  <select type="text" name="centro" class="form-control" value="<?php echo $centro; ?>">
                    <option selected><?php echo $centro; ?></option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Cantidad</label >
                  <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" autofocus>
                </div>
                <div class="form-group col">
                      <label for="exampleFormControlSelect1">Herramienta</label >
                      <select type="text" name="material" class="form-control">                
                        <option selected=<?php echo '"' .$material .'"'; ?>><?php echo $material; ?></option>                
                        <?php
                          $ejecutar=mysqli_query($conn,"SELECT * FROM materiales GROUP BY material ORDER BY material asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option value="<?php echo $opciones['material'] ?>"><?php echo $opciones['material'] ?></option>                    
                        <?php endforeach ?>

                      </select>  
                      </div>
              </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar entrega">
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

<!-- Calendario -->
<script src="../../jquery-3.3.1.min.js"></script>
<script src="../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fechaegre").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechaegre" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
