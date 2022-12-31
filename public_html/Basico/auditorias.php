<?php include("../db.php"); ?>
<!-----Supervisor---->
<?php
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
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$supervisor = $nombre ." " .$apellido;
}

?>


<?php include('../includes/header.php'); ?>
<?php
$mes = "20" .date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = "20" .date ('y-m', strtotime($mes1));
}
?>

<!-----Supervisor---->
<div class="col-12 col-sm-12">
  <div class="form-row justify-content-center">
    <div class="col-5 col-sm-5">
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-success m-4" href="../Basico/auditorias2.php" role="button">Herramientas <i class="fas fa-camera"></i></a>
      </div>
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-info m-4" href="../Basico/auditorias_instalaciones2.php" role="button">Instalaciones <i class="fas fa-camera"></i></a>
      </div>
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-primary m-4" href="../Basico/auditorias_vehiculo2.php" role="button">Vehiculos <i class="fas fa-camera"></i></a>
      </div>
    </div>
  </div>
</div>
<?php if ($tipo == 'Supervisor'){ ?> 
<main class="container p-2">
  <div class="row">
    <div class="col-lg">

      <!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->
      <div class="card card-body">
        <form action="../Guardar/save_auditorias.php" method="POST">
          <p class="h4 mb-4 text-center">Auditoria de herramientas</p>
          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Tecnico</label>
               <select type="text" name="tecnico" class="form-control" required>                
                  <option selected value="" disabled>Tecnicos...</option>                
                  <?php
                  $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
            </div>
              <div class="form-group col">
              <label for="exampleFormControlSelect1">Fecha</label>
              <input type="text" id="fecha" name="fecha" readonly="" class="form-control" required>
            </div>
          </div>
          
          <div class="card card-body border-info">

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Aire comprimido</b></label>
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Alargue</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Alcohol isopropilico</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Alicate</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Arnes</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Bolso kit</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Bolso del cleaver</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Campera</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Caja de herramientas</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Casco</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Celular</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Chomba</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Cinta pasacable</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Cleaver</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Conos</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Crimpeadora</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Destornillador phillips</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Destornillador plano</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Detector de tension</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Espatula y enduido</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Escalera chica</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Escalera grande</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Escoba</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Fibron</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Gafas</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Gorra</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Guante de alta tension</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Guante de trabajo</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Lapiz limpiador</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Lapiz optico</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Linga</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Martillo</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Mecha del 6"</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Mecha pasante</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Pala</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Pantalon</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Paños</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Peladora FO</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Peladora universal</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Percutora</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Pinza</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Pistola de silicona</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Power meter</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Telefono de prueba</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Tester de RJ45</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Tijera</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>

            <div class="card card-body">
              <label for="exampleFormControlSelect1"><b>Zapatos</b></label >
              <div class="form-row align-items-center">
                  <div class="form-group col-xs-2">
                    <legend class="col-form-label col">Estado</legend>
                  </div>
                  <div class="form-group col-xs-10">
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="BIEN" checked>
                      <label class="form-check-label" for="customRadioInline1">Bien</label>
                    </div>
                    <div class="form-check custom-control-inline">
                      <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="MAL">
                      <label class="form-check-label" for="customRadioInline2">Mal</label>
                    </div>
                  </div>
              </div>         
            </div>
          <br>
            <div class="col">
              <label for="exampleFormControlSelect1"><b>Observaciones (Max 255 caracteres)</b></label >
              <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
            </div> 
          </div>
          <br>
          <input type="submit" name="save_auditoria" class="btn btn-success btn-block" value="Guardar auditoria">
        </form>
      </div>
    </div>
  </div>  
</main>

<?php } ?>

<style type="text/css">
  .table .sticky{
    position: sticky;
    left: 0;
  }
  .table tbody tr .sticky {
    background: #f2f2f2;
  }
  .table tbody tr:nth-child(2n) .sticky {    
    background: white;
  }
</style>


<!-----VISTA SUPERVISOR---->
<?php if ($tipo == 'Administrador' OR $tipo == 'Despacho'){ ?>  <!-- ($tipo == 'Administrador' OR $tipo == 'Despacho') -->
<br>
<div class="row align-items-start justify-content-center">         
  <a class="btn btn-info" href="../Basico/auditoriasanalisis.php" role="button">Ver analisis</a>        
</div>
<div class="container p-2">
  <div class="row vh-100 justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Auditorias vista de <?php echo $tipo; ?> </p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>Supervisor</th>
              <th>Fecha auditoria</th>
              <th class="sticky pl-0">Tecnico</th>
              <th>Fecha</th>
              <th>Aire compr</th>
              <th>Alargue</th>              
              <th>Alcohol</th>
              <th>Alicate</th>
              <th>Arnes</th>
              <th>Bolso kit</th>
              <th>Bolso cleaver</th>
              <th>Campera</th>
              <th>Caja de herramientas</th>
              <th>Casco</th>
              <th>Celular</th>
              <th>Chomba</th>
              <th>Cinta Pasacable</th>
              <th>Cleaver</th>
              <th>Conos</th>
              <th>Crimpeadora</th>
              <th>Destornillador phillips</th>
              <th>Destornillador plano</th>
              <th>Detector de tension</th>
              <th>Enduido/espatula</th>
              <th>Escalera chica</th>
              <th>Escalera grande</th>
              <th>Escoba</th>
              <th>Fibron</th>
              <th>Gafas</th>
              <th>Gorra</th>
              <th>Guante alta tension</th>
              <th>Guante de trabajo</th>
              <th>Lapiz limpiador</th>
              <th>Lapiz optico</th>
              <th>Linga</th>
              <th>Martillo</th>
              <th>Mecha del 6"</th>
              <th>Mecha pasante</th>
              <th>Pala</th>
              <th>Pantalon</th>
              <th>Paños</th>
              <th>Peladora FO</th>
              <th>Peladora universal</th>
              <th>Percutora</th>
              <th>Pinza</th>
              <th>Pistola de silicona</th>
              <th>Power meter</th>
              <th>Telefono de prueba</th>
              <th>Tester RJ45</th>
              <th>Tijera</th>
              <th>Zapatos</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM auditoria ORDER BY fecha desc LIMIT 30";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td>
                  <a href="../Editar/edit_auditoria.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_auditoria.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['supervisor']; ?></td>
                <td><?php echo $row['fecha_relevo']; ?></td>
                <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php if ($row['aire'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['aire'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alargue'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alargue'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['alcohol'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alcohol'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alicate'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alicate'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['arnes'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['arnes'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['bolso_kit'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['bolso_kit'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['bolso_cleaver'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['bolso_cleaver'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['campera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['campera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['caja'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['caja'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['casco'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['casco'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['celular'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['celular'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['chomba'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['chomba'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pasacable'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pasacable'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['cleaver'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['cleaver'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['conos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['conos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['crimpeadora'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['crimpeadora'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['dest_phillips'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['dest_phillips'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['dest_plano'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['dest_plano'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tension'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tension'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['enduido'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['enduido'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escalera_chica'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escalera_chica'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escalera_grande'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escalera_grande'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escoba'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escoba'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['fibron'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['fibron'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['gafas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['gafas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['gorra'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['gorra'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alta_tension'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alta_tension'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['guante_trabajo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['guante_trabajo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['lapiz_limpiador'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['lapiz_limpiador'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['lapiz_optico'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['lapiz_optico'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['linga'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['linga'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['martillo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['martillo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['mecha6'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['mecha6'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['mecha_pasante'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['mecha_pasante'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pala'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pala'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['pantalon'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pantalon'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['panos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['panos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['peladora_fo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['peladora_fo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['peladora_uni'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['peladora_uni'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['percutora'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['percutora'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pinza'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pinza'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['silicona'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['silicona'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['power'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['power'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tel'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tel'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tester_rj'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tester_rj'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tijera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tijera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['zapatos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['zapatos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php echo $row['obs']; ?></td>               
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="form-row justify-content-md-center">
          <div class="form-group col col-md-auto"> 
            <div class="container">
              <a class="btn btn-info" href="../BaseDatos/dtauditoria.php" role="button">Ver todas las auditorias de herramientas</a>
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="row align-items-start justify-content-center">
  <!-- <a class="btn btn-info" href="../BaseDatos/dtauditoria.php" role="button">Ver todas las auditorias</a> -->
</div>
</br>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="../Basico/auditorias.php" method="POST">
          <p class="h4 mb-4 text-center">Mes</p>
          <div class="form-row align-items-end">            
            <div class="col">             
              <select type="text" name="mes" class="form-control">
                <option selected>Mes...</option>
                <option value="-0 month">Mes actual</option>
                <option value="-1 month">Hace un mes</option>
                <option value="-2 month">Hace dos meses</option>
                <option value="-3 month">Hace tres meses</option>
              </select>
            </div>            
            <div class="col">
              <input type="submit" name="meses" class="btn btn-success btn-block" value="Cargar mes">
            </div>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  </div>
</div>

<?php } else {  ?>
<!-----VISTA SUPERVISOR---->


<div class="container p-2">
  <div class="row vh-100 justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Auditorias de <?php echo $supervisor; ?> </p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th class="sticky pl-0">Tecnico</th>
              <th>Fecha</th>
              <th>Aire compr</th>
              <th>Alargue</th>              
              <th>Alcohol</th>
              <th>Alicate</th>
              <th>Arnes</th>
              <th>Bolso kit</th>
              <th>Bolso cleaver</th>
              <th>Campera</th>
              <th>Caja de herramientas</th>
              <th>Casco</th>
              <th>Celular</th>
              <th>Chomba</th>
              <th>Cinta Pasacable</th>
              <th>Cleaver</th>
              <th>Conos</th>
              <th>Crimpeadora</th>
              <th>Destornillador phillips</th>
              <th>Destornillador plano</th>
              <th>Detector de tension</th>
              <th>Enduido/espatula</th>
              <th>Escalera chica</th>
              <th>Escalera grande</th>
              <th>Escoba</th>
              <th>Fibron</th>
              <th>Gafas</th>
              <th>Gorra</th>
              <th>Guante alta tension</th>
              <th>Guante de trabajo</th>
              <th>Lapiz limpiador</th>
              <th>Lapiz optico</th>
              <th>Linga</th>
              <th>Martillo</th>
              <th>Mecha del 6"</th>
              <th>Mecha pasante</th>
              <th>Pala</th>
              <th>Pantalon</th>
              <th>Paños</th>
              <th>Peladora FO</th>
              <th>Peladora universal</th>
              <th>Percutora</th>
              <th>Pinza</th>
              <th>Pistola de silicona</th>
              <th>Power meter</th>
              <th>Telefono de prueba</th>
              <th>Tester RJ45</th>
              <th>Tijera</th>
              <th>Zapatos</th>
              <th>Observaciones</th>              
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM auditoria WHERE supervisor = '$supervisor' ORDER BY fecha_relevo desc LIMIT 60";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td>
                  <a href="../Editar/edit_auditoria.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                </td>
                <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php if ($row['aire'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['aire'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alargue'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alargue'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['alcohol'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alcohol'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alicate'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alicate'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['arnes'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['arnes'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['bolso_kit'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['bolso_kit'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['bolso_cleaver'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['bolso_cleaver'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['campera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['campera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['caja'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['caja'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['casco'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['casco'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['celular'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['celular'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['chomba'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['chomba'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pasacable'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pasacable'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['cleaver'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['cleaver'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['conos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['conos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['crimpeadora'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['crimpeadora'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['dest_phillips'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['dest_phillips'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['dest_plano'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['dest_plano'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tension'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tension'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['enduido'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['enduido'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escalera_chica'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escalera_chica'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escalera_grande'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escalera_grande'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['escoba'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['escoba'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['fibron'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['fibron'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['gafas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['gafas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['gorra'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['gorra'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['alta_tension'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['alta_tension'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['guante_trabajo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['guante_trabajo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['lapiz_limpiador'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['lapiz_limpiador'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['lapiz_optico'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['lapiz_optico'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['linga'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['linga'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['martillo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['martillo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['mecha6'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['mecha6'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['mecha_pasante'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['mecha_pasante'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pala'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pala'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['pantalon'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pantalon'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['panos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['panos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['peladora_fo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['peladora_fo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['peladora_uni'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['peladora_uni'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['percutora'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['percutora'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['pinza'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['pinza'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['silicona'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['silicona'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['power'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['power'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tel'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tel'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tester_rj'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tester_rj'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['tijera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['tijera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['zapatos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['zapatos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php echo $row['obs']; ?></td>                            
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php } ?>


  <!-- PIE DE PAGINA -->

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- then Popper -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Calendario 1-->
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