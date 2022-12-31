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
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php"); 
}

$material = '';
$sap= '';
$centro= '';
$pedido= '';
$cantidad= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM materiales WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $material = $row['material'];
    $sap = $row['sap'];
    $centro = $row['centro'];
    $pedido = $row['pedido'];
    $cantidad = $row['cantidad'];
  }
}

if (isset($_POST['updatecm']))
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
    'Material',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $material= $_POST['material'];
  $sap = $_POST['sap'];
  $centro = $_POST['centro'];
  $pedido = $_POST['pedido'];
  $cantidad = $_POST['cantidad'];

  $query = "UPDATE materiales set material = '$material', sap = '$sap', centro = '$centro', pedido = '$pedido', cantidad = '$cantidad' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = 'Material actualizado';
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
            <form action="edit_materiales.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar orden</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Material</label >
                  <input type="text" name="material" class="form-control" value="<?php echo $material; ?>" placeholder="Actualice el material" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Numero de SAP</label >
                  <input type="text" name="sap" class="form-control" value="<?php echo $sap; ?>" placeholder="Actualice el numero de SAP" autofocus>
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
                  <label for="exampleFormControlSelect1">Pedido</label >
                  <input type="text" name="pedido" class="form-control" value="<?php echo $pedido; ?>" placeholder="Actualice el pedido" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Cantidad</label >
                  <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" placeholder="Actualice la cantidad" autofocus>
                </div>
                
              </div>
            
              <input type="submit" name="updatecm" class="btn btn-success btn-block" value="Actualizar orden">

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
</body>
</html>
