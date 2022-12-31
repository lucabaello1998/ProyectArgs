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
$cantidad= '';
$zona= '';
$sap= '';

if(isset($_GET['id']))
{
  $id = $_GET['id'];
  $query_ma = "SELECT * FROM asignacion_material WHERE id=$id";
  $result_ma = mysqli_query($conn, $query_ma);
  if (mysqli_num_rows($result_ma) == 1) {
    $row = mysqli_fetch_array($result_ma);
    $material = $row['material'];
    $sap = $row['sap'];
    $cantidad = $row['cantidad'];
    $zona = $row['deposito'];
  }
}

if (isset($_POST['updateb']))
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
    'Precarga',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $mate = $_POST['material'];

  $result_mat = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE material = '$mate' LIMIT 1");
  if (mysqli_num_rows($result_mat) >= 1) {
    $row = mysqli_fetch_array($result_mat);
    $materiall = $row['material'];
    $sap = $row['sap'];
  }

  $cantidad= $_POST['cantidad'];
  $zona = $_POST['zona'];
  
  $query = "UPDATE asignacion_material set material = '$materiall', deposito = '$zona', cantidad = '$cantidad', sap = '$sap' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El material " .$material ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/precarga.php');
}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_precarga.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar material</p>
              <div class="form-row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Material</label >
                  <select type="text" name="material" class="form-control">                
                    <option selected disabled value=""><?php echo $material; ?></option>               
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM ingresomaterial WHERE seriado = '' GROUP BY material ORDER BY material asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['material']; ?>"><?php echo $opciones['material']; ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>          
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Cantidad</label >
                  <input type="number" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                </div>

                <?php if($tipo == 'Administrador' && $zona_us == 'Todo') { ?>            
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Zona</label>
                    <select type="text" name="zona" class="form-control">
                      <option selected value="<?php echo $zona ?>"><?php echo $zona ?></option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                <?php }else{ ?>
                  <input type="hidden" name="zona" value="<?php echo $zona_us; ?>"/>
                <?php } ?>

              </div>
              <input type="submit" name="updateb" class="btn btn-success btn-block" value="Actualizar orden">
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
