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
if($usu != 1)
{
  header("location: ../index.php");
}
$tecnico = '';
$rf= '';
$ot= '';
$fechains= '';
$fechamail= '';
$direccion= '';
$telefono= '';
$problema= '';
$fechasolu= '';
$solucion= '';
$gasto= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM reclamos WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $rf = $row['rf'];
    $ot = $row['ot'];
    $fechains = $row['fechains'];
    $fechamail = $row['fechamail'];
    $direccion = $row['direccion'];
    $telefono = $row['telefono'];
    $problema = $row['problema'];
    $fechasolu = $row['fechasolu'];
    $solucion = $row['solucion'];
    $gasto = $row['gasto'];
  }
}

if (isset($_POST['updaterecla']))
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
    'Reclamos',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $rf = $_POST['rf'];
  $ot = $_POST['ot'];
  $fechains = $_POST['fechains'];
  $fechamail = $_POST['fechamail'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];
  $problema = $_POST['problema'];
  $fechasolu = $_POST['fechasolu'];
  $solucion = $_POST['solucion'];
  $gasto = $_POST['gasto'];

  $query = "UPDATE reclamos set tecnico = '$tecnico', rf = '$rf', ot = '$ot', fechains = '$fechains', fechamail = '$fechamail', direccion = '$direccion', telefono = '$telefono', problema = '$problema', fechasolu = '$fechasolu', solucion = '$solucion', gasto = '$gasto' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El reclamo " ."RF" .$rf ." de " .$tecnico ." fua actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/reclamos.php');
}
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_reclamos.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizacion de reclmaos</p>
              <div class="form-row align-items-end">
                <div class="form-group col-2">
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
                <div class="form-group col-2">
                  <label for="exampleFormControlSelect1">Numero de RF</label >
                  <input type="text" name="rf" class="form-control" value="<?php echo $rf; ?>" placeholder="Ingrese el numero de RF" autofocus>
                </div>
                <div class="form-group col-2">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="text" name="ot" class="form-control" value="<?php echo $ot; ?>" placeholder="Ingrese el numero de OT" autofocus>
                </div>
                <div class="form-group col-2">
                  <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
                  <input type="text" id="fechains" name="fechains" readonly="" value="<?php echo $fechains; ?>" class="form-control">
                </div>
                  <div class="form-group col-2">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" maxlength="255" class="form-control" value="<?php echo $direccion; ?>" placeholder="Ingrese la direccion del reclamo" autofocus>
                </div>
                <div class="form-group col-2">
                  <label for="exampleFormControlSelect1">Telefono</label >
                  <input type="numb" name="telefono" maxlength="255" class="form-control" value="<?php echo $telefono; ?>" placeholder="Ingrese un telefono de contacto" autofocus>
                </div>
              </div>
              
              <div class="form-row align-items-end">
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Fecha del mail</label >
                  <input type="text" maxlength="255" id="fechamail" name="fechamail" readonly="" value="<?php echo $fechamail; ?>" class="form-control">
                </div>
                  <div class="form-group col-md-9">
                  <label for="exampleFormControlSelect1">Descripcion del problema</label >
                  <textarea type="text" maxlength="255" name="problema" class="form-control" autofocus><?php echo $problema; ?></textarea>
                </div>            
              </div>        

              <div class="form-row">
                <div class="form-group col-3">
                  <label for="exampleFormControlSelect1">Fecha de la solucion</label >
                  <input type="text" maxlength="255" id="fechasolu" name="fechasolu" readonly="" class="form-control" value="<?php echo $fechasolu; ?>">
                </div>
                <div class="form-group col-md-9">
                  <label for="exampleFormControlSelect1">Como se soluciono</label >
                  <textarea type="text" maxlength="255" name="solucion" class="form-control" autofocus><?php echo $solucion; ?></textarea> 
                </div>
              </div>

              <div class="form-row align-items-end">
                
                <div class="form-group col-6">
                  <label for="exampleFormControlSelect1">Gasto</label >
                  <input type="text" name="gasto" class="form-control" value="<?php echo $gasto; ?>" placeholder="Ingrese el gasto" autofocus>
                </div> 
                <div class="form-group col-6">
                  <input type="submit" name="updaterecla" class="btn btn-success btn-block" value="Actualizar reclamo">     
                </div>      
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
<!-- fechains -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fechains").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechains" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<script type="text/javascript">
  $(function() {
    $("#fechamail").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechamail" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<script type="text/javascript">
  $(function() {
    $("#fechasolu").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechasolu" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
