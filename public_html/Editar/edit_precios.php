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
if($tipo != "Administrador")
{
header("location: ../index.php");
}

$dosplay = "";
$tresplay = "";
$stb = "";
$mudainter = "";
$bajas = "";
$garanjus = "";
$garaninterv = "";
$garancomp = "";
$sab = "";
$fer = "";
$sabmtto = "";
$fermtto = "";
$bajatec = "";
$bajadesmont = "";
$mttointer = "";
$mttoexter = "";
$desplani = "";
$desepp = "";
$desinst = "";
$descalidad = "";
$destoa = "";
$destotal = "";
$desbaja = "";
$mttoreacond = "";

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM precios WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $dosplay = $row['dosplay'];
    $tresplay = $row['tresplay'];
    $stb = $row['stb'];
    $mudainter = $row['mudainter'];
    $bajas = $row['bajas'];
    $garanjus = $row['garanjus'];
    $garaninterv = $row['garaninterv'];
    $garancomp = $row['garancomp'];
    $sab = $row['sab'];
    $fer = $row['fer'];
    $sabmtto = $row['sabmtto'];
    $fermtto = $row['fermtto'];
    $bajatec = $row['bajatec'];
    $bajadesmont = $row['bajadesmont'];
    $mttointer = $row['mttointer'];
    $mttoexter = $row['mttoexter'];
    $desplani = $row['desplani'];
    $desepp = $row['desepp'];
    $desinst = $row['desinst'];
    $descalidad = $row['descalidad'];
    $destoa = $row['destoa'];
    $destotal = $row['destotal'];
    $desbaja = $row['desbaja'];
    $mttoreacond = $row['mttoreacond'];
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
    'Precios',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $dosplay= $_POST['dosplay'];
  $tresplay = $_POST['tresplay'];
  $stb = $_POST['stb'];
  $mudainter = $_POST['mudainter'];
  $bajas = $_POST['bajas'];
  $garanjus = $_POST['garanjus'];
  $garaninterv = $_POST['garaninterv'];
  $garancomp = $_POST['garancomp'];
  $sab = $_POST['sab'];
  $fer = $_POST['fer'];
  $sabmtto = $_POST['sabmtto'];
  $fermtto = $_POST['fermtto'];
  $bajatec = $_POST['bajatec'];
  $bajadesmont = $_POST['bajadesmont'];
  $mttointer = $_POST['mttointer'];
  $mttoexter = $_POST['mttoexter'];
  $desplani = $_POST['bajas'];
  $desepp = $_POST['desepp'];
  $desinst = $_POST['desinst'];
  $descalidad = $_POST['descalidad'];
  $destoa = $_POST['destoa'];
  $destotal = $_POST['dosplay'];
  $desbaja = $_POST['desbaja'];
  $mttoreacond = $_POST['mttoreacond'];

  $query = "UPDATE precios set dosplay = '$dosplay', tresplay = '$tresplay', stb = '$stb', mudainter = '$mudainter', bajas = '$bajas', garanjus = '$garanjus', garaninterv = '$garaninterv', garancomp = '$garancomp', sab = '$sab', fer = '$fer', sabmtto = '$sabmtto', fermtto = '$fermtto', bajatec = '$bajatec', bajadesmont = '$bajadesmont', mttointer = '$mttointer', mttoexter = '$mttoexter', desplani = '$desplani', desepp = '$desepp', desinst = '$desinst', descalidad = '$descalidad', destoa = '$destoa', destotal = '$destotal', desbaja = '$desbaja', mttoreacond = '$mttoreacond' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "Los precios fueron actualizados";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/precios.php');
}

?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_precios.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar precios</p>
              <div class="card card-body">
                <p class="h5 mb-4 text-center"><small>Instalaciones</small></p>
                <div class="form-row">            
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Dos play</label >
                    <input type="number" name="dosplay" class="form-control" value="<?php echo $dosplay; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Tres play</label >
                    <input type="number" name="tresplay" class="form-control" value="<?php echo $tresplay; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">STB</label >
                    <input type="number" name="stb" class="form-control" value="<?php echo $stb; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Mudanza interna</label >
                    <input type="number" name="mudainter" class="form-control" value="<?php echo $mudainter; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Bajas</label >
                    <input type="number" name="bajas" class="form-control" value="<?php echo $bajas; ?>" autofocus>
                  </div>
                </div>
                <div class="form-row">  
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Garantias justificadas</label >
                    <input type="number" name="garanjus" class="form-control" value="<?php echo $garanjus; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Garantia sin inter</label >
                    <input type="number" name="garaninterv" class="form-control" value="<?php echo $garaninterv; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Garantia compañero</label >
                    <input type="number" name="garancomp" class="form-control" value="<?php echo $garancomp; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Sabados</label >
                    <input type="number" name="sab" class="form-control" value="<?php echo $sab; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Feriados</label >
                    <input type="number" name="fer" class="form-control" value="<?php echo $fer; ?>" autofocus>
                  </div>            
                </div>
              </div>
              <div class="card card-body">
                <p class="h5 mb-4 text-center"><small>Mantenimiento</small></p>
                <div class="form-row">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Baja tecnica</label >
                    <input type="number" name="bajatec" class="form-control" value="<?php echo $bajatec; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Baja desmonte</label >
                    <input type="number" name="bajadesmont" class="form-control" value="<?php echo $bajadesmont; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Mtto reacond</label >
                    <input type="number" name="mttoreacond" class="form-control" value="<?php echo $mttoreacond; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Mtto interno</label >
                    <input type="number" name="mttointer" class="form-control" value="<?php echo $mttointer; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Mtto externo</label >
                    <input type="number" name="mttoexter" class="form-control" value="<?php echo $mttoexter; ?>" autofocus>
                  </div> 
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Sabado mtto</label >
                    <input type="number" name="sabmtto" class="form-control" value="<?php echo $sabmtto; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Feriado mtto</label >
                    <input type="number" name="fermtto" class="form-control" value="<?php echo $fermtto; ?>" autofocus>
                  </div>
                </div>
              </div>
              <div class="card card-body">
                  <p class="h5 mb-4 text-center"><small>Descuentos</small></p>
                <div class="form-row">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Falta planilla</label >
                    <input type="number" name="desplani" class="form-control" value="<?php echo $desplani; ?>" autofocus readonly>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">EPP (%)</label >
                    <input type="number" name="desepp" class="form-control" value="<?php echo $desepp; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Instalacion (%)</label >
                    <input type="number" name="desinst" class="form-control" value="<?php echo $desinst; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Calidad (%)</label >
                    <input type="number" name="descalidad" class="form-control" value="<?php echo $descalidad; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">TOA (%)</label >
                    <input type="number" name="destoa" class="form-control" value="<?php echo $destoa; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Baja mal cerrada</label >
                    <input type="number" name="desbaja" class="form-control" value="<?php echo $desbaja; ?>" autofocus>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Descuento total</label >
                    <input type="number" name="destotal" class="form-control" value="<?php echo $destotal; ?>" autofocus readonly>
                  </div>


                </div>
              </div>
              <div class="form-row">
                <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar precios">
              </div>

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
