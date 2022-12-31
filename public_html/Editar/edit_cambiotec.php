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
$tecnico = '';
$ot= '';
$direccion= '';
$calendario= '';
$mac_ont= '';
$sn_ont= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM cambiotecnologia WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $direccion = $row['direccion'];
    $calendario = $row['calendario'];
    $mac_ont = $row['mac_ont'];
    $sn_ont = $row['sn_ont'];
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
    'Cambio de tecnologia',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $calendario = $_POST['calendario'];
  $mac_ont = $_POST['mac_ont'];
  $sn_ont = $_POST['sn_ont'];

  $query = "UPDATE cambiotecnologia set tecnico = '$tecnico', ot = '$ot', direccion = '$direccion', calendario = '$calendario', mac_ont = '$mac_ont', sn_ont = '$sn_ont' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La orden " .$ot ." de " .$tecnico ." fue actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/cambiotec.php');
}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_cambiotec.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar orden</p>
              <div class="form-row">
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">                
                    <option selected="0"><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="text" name="ot" class="form-control" value="<?php echo $ot; ?>" placeholder="Actualice el numero de OT" autofocus>
                </div>
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" placeholder="Actualice la direccion" autofocus>
                </div>
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="calendario" value="<?php echo $calendario; ?>" class="form-control">
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC ONT</label >
                  <input type="text" name="mac_ont" class="form-control" value="<?php echo $mac_ont; ?>" placeholder="Actualice la MAC del modem" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN ONT</label >
                  <input type="text" name="sn_ont" class="form-control" value="<?php echo $sn_ont; ?>" placeholder="Actualice el numero de serie del modem" autofocus>
                </div>
              </div>         
                <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar orden">

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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
</body>
</html>
