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
$ot= '';
$direccion= '';
$zona= '';
$fechaint= '';
$fecharep= '';
$tecrep= '';
$coment= '';
$repa= '';
$justificado= '';
$intervencion= '';
$obs= '';
$obs_supervisor= '';
$otdos= '';
$motivo= '';
$abonado= '';
$primercierre= '';
$primeranota= '';
$nim= '';
$responsabilidad= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $queryy = "SELECT * FROM reincidencias WHERE id=$id";
  $resultt = mysqli_query($conn, $queryy);
  if (mysqli_num_rows($resultt) == 1) {
    $row = mysqli_fetch_array($resultt);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $nim = $row['nim'];
    $direccion = $row['direccion'];
    $zona = $row['zona'];
    $fechaint = $row['fechaint'];
    $fecharep = $row['fecharep'];
    $tecrep = $row['tecrep'];
    $coment = $row['coment'];
    $repa = $row['repa'];
    $justificado = $row['justificado'];
    $intervencion = $row['intervencion'];
    $obs = $row['obs'];
    $obs_supervisor = $row['obs_supervisor'];
    $otdos= $row['otdos'];
    $motivo= $row['motivo'];
    $abonado= $row['abonado'];
    $primercierre= $row['primercierre'];
    $primeranota= $row['primeranota'];
    $responsabilidad = $row['responsabilidad'];
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
    'Reincidencias',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $fechaint = $_POST['fechaint'];
  $fecharep = $_POST['fecharep'];
  $tecrep = $_POST['tecrep'];
  $coment = $_POST['coment'];
  $repa = $_POST['repa'];
  $justificado = $_POST['justificado'];
  $intervencion = $_POST['intervencion'];
  $obs = $_POST['obs'];
  $obs_supervisor = $_POST['obs_supervisor'];
  $otdos = $_POST['otdos'];
  $motivo = $_POST['motivo'];
  $abonado = $_POST['abonado'];
  $primercierre = $_POST['primercierre'];
  $primeranota = $_POST['primeranota'];
  $nim = $_POST['nim'];
  $responsabilidad = $_POST['responsabilidad'];

  $query = "UPDATE reincidencias set tecnico = '$tecnico', ot = '$ot', direccion = '$direccion', zona = '$zona', fechaint = '$fechaint', fecharep = '$fecharep', tecrep = '$tecrep', coment = '$coment', repa = '$repa', justificado = '$justificado', intervencion = '$intervencion', obs = '$obs', obs_supervisor = '$obs_supervisor', otdos = '$otdos', motivo = '$motivo', abonado = '$abonado', primercierre = '$primercierre', primeranota = '$primeranota', nim = '$nim', responsabilidad = '$responsabilidad' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La reincidencia de " .$tecnico ." fue actualizada.";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/reincidencias.php');
}
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_reincidencias.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar la reincidencias de <?php echo $tecnico; ?></p>
              <div class="form-row align-items-end">
                <div class="form-group col-sm">
                    <label>Tecnico responsable</label >
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
                
                <div class="form-group col-sm">
                  <label>Direccion</label >
                  <input type="text" name="direccion" value="<?php echo $direccion; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col-sm">
                  <label>Zona</label >
                  <select type="text" name="zona" class="form-control">
                    <option selected><?php echo $zona; ?></option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
                <div class="form-group col-sm">
                  <label>NIM</label >
                  <input type="number" name="nim" value="<?php echo $nim; ?>" class="form-control" >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label>Fecha primera reparacion</label >
                  <input type="text" id="fechaint" name="fechaint" value="<?php echo $fechaint; ?>" readonly="" class="form-control" >
                </div>
                <div class="form-group col-sm">
                  <label>1° OT</label >
                  <input type="number" name="ot" value="<?php echo $ot; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label>Ultima Fecha</label >
                  <input type="text" id="fecharep" name="fecharep" value="<?php echo $fecharep; ?>" readonly="" class="form-control" >
                </div>
                <div class="form-group col-sm">
                  <label>Ultima OT</label >
                  <input type="number" name="otdos" value="<?php echo $otdos; ?>" class="form-control" autofocus >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label>Tecnico que lo reparo</label >
                  <select type="text" name="tecrep" class="form-control">                
                    <option selected><?php echo $tecrep; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col">
                  <label>Abonado</label >
                  <input type="text" name="abonado" value="<?php echo $abonado; ?>"  class="form-control" >
                </div>
                <div class="form-group col">
                  <label>Primer motivo de cierre</label >
                  <input type="text" name="primercierre" value="<?php echo $primercierre; ?>"  class="form-control" >
                </div>            
                <div class="form-group col">
                  <label>Motivo de asignacion</label >
                  <input type="text" name="motivo" value="<?php echo $motivo; ?>"  class="form-control" >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label>Primeras notas del tecnico</label >
                  <textarea type="text" maxlength="255" name="primeranota" class="form-control" autofocus ><?php echo $primeranota; ?></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="col">
                  <label>Reparado</label>
                  <div class="col-sm-10">
                    <select type="text" name="repa" class="form-control">
                    <option readonly="" selected><?php echo $repa; ?></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>              
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label>Justificado</label>
                  <div class="col-sm-10">
                    <select type="text" name="justificado" class="form-control">
                    <option readonly="" selected><?php echo $justificado; ?></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    </select>
                  </div>
                </div> 
                <div class="form-group col">
                    <label>Intervencion</label>
                    <div class="col-sm-10">
                    <select type="text" name="intervencion" class="form-control">
                    <option readonly="" selected><?php echo $intervencion; ?></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    </select>
                  </div>
                </div>
                <div class="form-group col">
                  <label>Responsabilidad</label>
                  <div class="col-sm-10">
                    <select type="text" name="responsabilidad" class="form-control">
                    <option value="<?php echo $responsabilidad; ?>" selected><?php echo $responsabilidad; ?></option>
                    <option value="Claro">Claro</option>
                    <option value="Cliente">Cliente</option>
                    <option value="Tecnico">Tecnico</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label>Cierre</label >
                  <textarea type="text" maxlength="255" name="coment"class="form-control" autofocus><?php echo $coment; ?></textarea>
                </div>       
                <div class="form-group col">
                  <label>Notas</label >
                  <textarea type="text" maxlength="255" name="obs" class="form-control" autofocus ><?php echo $obs; ?></textarea>
                </div>         
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label>Observaciones supervisor</label >
                  <textarea type="text" maxlength="255" name="obs_supervisor" class="form-control" autofocus ><?php echo $obs_supervisor; ?></textarea>
                </div>
              </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar reincidencia">
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

<!-- fechains -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fechaint").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechaint" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<script type="text/javascript">
  $(function() {
    $("#fecharep").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecharep" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
