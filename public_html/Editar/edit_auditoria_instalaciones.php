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
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

$tecnico = '';
$fecha= '';
$ot = '';
$instalacion_externa = '';
$foto_nomenclador = '';
$cadena = '';
$altura_acometida = '';
$punto_retencion = '';
$curva_goteo = '';
$ingreso_domicilio = '';
$engrampado_interior = '';
$ont = '';
$residuos = '';
$trato_cliente = '';
$uso_herramientas = '';
$epp = '';
$obs = '';

if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM auditoria_instalaciones WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $ot = $row['ot'];
    $instalacion_externa = $row['instalacion_externa'];
    $foto_nomenclador = $row['foto_nomenclador'];
    $cadena = $row['cadena'];
    $altura_acometida = $row['altura_acometida'];
    $punto_retencion = $row['punto_retencion'];
    $curva_goteo = $row['curva_goteo'];
    $ingreso_domicilio = $row['ingreso_domicilio'];
    $engrampado_interior = $row['engrampado_interior'];
    $ont = $row['ont'];
    $residuos = $row['residuos'];
    $trato_cliente = $row['trato_cliente'];
    $uso_herramientas = $row['uso_herramientas'];
    $epp = $row['epp'];
    $obs = $row['obs'];
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
    'Auditoria instalaciones',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $ot = $_POST['ot'];
  $instalacion_externa = $_POST['instalacion_externa'];
  $foto_nomenclador = $_POST['foto_nomenclador'];
  $cadena = $_POST['cadena'];
  $altura_acometida = $_POST['altura_acometida'];
  $punto_retencion = $_POST['punto_retencion'];
  $curva_goteo = $_POST['curva_goteo'];
  $ingreso_domicilio = $_POST['ingreso_domicilio'];
  $engrampado_interior = $_POST['engrampado_interior'];
  $ont = $_POST['ont'];
  $residuos = $_POST['residuos'];
  $trato_cliente = $_POST['trato_cliente'];
  $uso_herramientas = $_POST['uso_herramientas'];
  $epp = $_POST['epp'];
  $obs = $_POST['obs'];

  $query = "UPDATE auditoria_instalaciones set tecnico = '$tecnico', fecha = '$fecha', ot = '$ot', instalacion_externa = '$instalacion_externa', foto_nomenclador = '$foto_nomenclador', cadena = '$cadena', altura_acometida = '$altura_acometida', punto_retencion = '$punto_retencion', curva_goteo = '$curva_goteo', ingreso_domicilio = '$ingreso_domicilio', engrampado_interior = '$engrampado_interior', ont = '$ont', residuos = '$residuos', trato_cliente = '$trato_cliente', uso_herramientas = '$uso_herramientas', epp = '$epp', obs = '$obs' WHERE id=$id";
  $resultado = mysqli_query($conn, $query);
  if(!$resultado) {
  $msj = "Recuerda que el comentario es como maximo de 255 caracteres.";
  $color = "danger";
  }else{
  $msj = "La auditoria de instalacion de " .$tecnico ." fue actualizada.";
  $color = "warning";
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias_instalaciones.php');
}
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_auditoria_instalaciones.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar auditoria</p>
              <div class="form-row align-items-end">            
                <div class="form-group col">
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
                  <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
                  <input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>" readonly="" class="form-control" >
                </div> 
              </div>

              <div class="card card-body border-info">

                <div class="col">
                  <label for="exampleFormControlSelect1"><b>OT</b></label >
                  <textarea type="text" name="ot" maxlength="255" class="form-control" placeholder="Ingrese una observacion"><?php echo $ot; ?></textarea>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Instalacion externa</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="BIEN" <?php if ($instalacion_externa == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="MAL" <?php if ($instalacion_externa == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Foto del nomenclador</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="BIEN" <?php if ($foto_nomenclador == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="MAL" <?php if ($foto_nomenclador == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cadena</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="BIEN" <?php if ($cadena == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="MAL" <?php if ($cadena == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Altura de la acometida</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="BIEN" <?php if ($altura_acometida == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="MAL" <?php if ($altura_acometida == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Punto de retencion</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="BIEN" <?php if ($punto_retencion == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="MAL" <?php if ($punto_retencion == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Curva de goteo</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="BIEN" <?php if ($curva_goteo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="MAL" <?php if ($curva_goteo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ingreso al domicilio</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="BIEN" <?php if ($ingreso_domicilio == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="MAL" <?php if ($ingreso_domicilio == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Engrampado interior</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="BIEN" <?php if ($engrampado_interior == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="MAL" <?php if ($engrampado_interior == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Amurado de ONT</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="BIEN" <?php if ($ont == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="MAL" <?php if ($ont == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Residuos</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="BIEN" <?php if ($residuos == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="MAL" <?php if ($residuos == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Trato con el cliente</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="BIEN" <?php if ($trato_cliente == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="MAL" <?php if ($trato_cliente == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Uso de las herramientas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="BIEN" <?php if ($uso_herramientas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="MAL" <?php if ($uso_herramientas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Uso de EPP</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="BIEN" <?php if ($epp == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="MAL" <?php if ($epp == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>
              
              <br>
                <div class="col">
                  <label for="exampleFormControlSelect1"><b>Observaciones (Max 255 caracteres)</b></label >
                  <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"><?php echo $obs; ?></textarea>
                </div> 
              </div>
              
              <br>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar auditoria">
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
<!-- Boapellidostrap -->
<script src="https://stackpath.boapellidostrapcdn.com/boapellidostrap/4.4.1/js/boapellidostrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
<!-- Calendario -->
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
