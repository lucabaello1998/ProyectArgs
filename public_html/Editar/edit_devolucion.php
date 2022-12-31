<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo_us = $_SESSION['tipo_us'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$contratista = '';
$referente= '';
$centro= '';
$almacen= '';
$sitio= '';

if(isset($_GET['remito']))
{
  $remito = $_GET['remito'];
  $result = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' GROUP BY num_remito");
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $contratista = $row['contratista'];
    $referente = $row['referente'];
    $centro = $row['centro'];
    $almacen = $row['almacen'];
    $sitio = $row['sitio'];
  }
}

if (isset($_POST['updateb']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us_us = $_SESSION['tipo_us'];
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
    'Devolucion',
    '$hoy_movi',
    '$tipo_us_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $remito = $_GET['remito'];
  $contratista = $_POST['contratista'];
  $referente = $_POST['referente'];
  $centro = $_POST['centro'];
  $almacen = $_POST['almacen'];
  $sitio = $_POST['sitio'];
  $num_remito = $_POST['num_remito'];

  $r = mysqli_query($conn, "UPDATE devolucion set contratista = '$contratista', referente = '$referente', centro = '$centro', almacen = '$almacen', sitio = '$sitio', num_remito = '$num_remito' WHERE num_remito = '$remito'");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al actualizar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Actualizado";
    $msj_toast = "Los datos fueron actualizados";
    $color_toast = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/devolucion.php');
}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_devolucion.php?remito=<?php echo $_GET['remito']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar datos del remito <?php echo ' ' .$_GET['remito']; ?></p>
              <div class="form-row">
                <div class="form-group col-md-4 col-12">
                  <label>Contratista</label >
                  <input type="text" name="contratista" value="<?php echo $contratista; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>Referente</label >
                  <input type="text" name="referente" value="<?php echo $referente; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>N° remito</label >
                  <input type="number" name="num_remito" value="<?php echo $remito; ?>" class="form-control">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4 col-12">
                  <label>Centro</label >
                  <input type="text" name="centro" value="<?php echo $centro; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>Almacen</label >
                  <input type="text" name="almacen" value="<?php echo $almacen; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>Sitio</label >
                  <input type="text" name="sitio" value="<?php echo $sitio; ?>" class="form-control">
                </div>
              </div>
              <input type="submit" name="updateb" class="btn btn-success btn-block" value="Actualizar datos">
            </form>
          </div>
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
</body>
</html>
