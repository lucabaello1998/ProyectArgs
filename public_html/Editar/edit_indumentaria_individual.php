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

$indumentaria= '';
$talle= '';
$cantidad= '';
$sap= '';
$pedido= '';
$fecha= '';
$centro= '';


if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM indumentaria WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $indumentaria = $row['indumentaria'];
    $talle = $row['talle'];
    $cantidad = $row['cantidad'];
    $sap = $row['sap'];
    $pedido = $row['pedido'];
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
    'Indumentaria individual',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id = $_GET['id'];
  $indumentaria= $_POST['indumentaria'];
  $talle = $_POST['talle'];
  $cantidad = $_POST['cantidad'];
  $sap = $_POST['sap'];
  $pedido = $_POST['pedido'];
  $fecha = $_POST['fecha'];
  $centro = $_POST['centro'];

  $query = "UPDATE indumentaria set indumentaria = '$indumentaria', talle = '$talle', cantidad = '$cantidad', sap = '$sap', pedido = '$pedido', fecha = '$fecha', centro = '$centro' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La " .$indumentaria ." talle " .$talle  ." fue actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/indumentaria.php');
}
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_indumentaria_individual.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar indumentaria</p>
              <div class="form-row align-items-end">
                <div class="form-group col">
                    <label for="exampleFormControlSelect1">Indumentaria ya ingresada</label >
                    <select type="text" name="indumentaria" class="form-control">                
                      <option selected=<?php echo '"' .$indumentaria .'"' ; ?>><?php echo $indumentaria; ?></option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM indumentaria GROUP BY indumentaria ORDER BY indumentaria asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['indumentaria'] ?>"><?php echo $opciones['indumentaria'] ?></option>                    
                      <?php endforeach ?>                    
                    </select>  
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Talle</label >
                  <input type="text" name="talle" class="form-control" value="<?php echo $talle; ?>" placeholder="Actualice el talle" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Codigo SAP</label >
                  <input type="text" name="sap" class="form-control" value="<?php echo $sap; ?>" placeholder="Actualice el codigo SAP" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Pedido</label >
                  <input type="text" name="pedido" class="form-control" value="<?php echo $pedido; ?>" placeholder="Actualice numero de pedido" autofocus>
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
</body>
</html>
s