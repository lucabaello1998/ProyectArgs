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
  if($usu != 1)
  {
    header("location: ../index.php");
  }else{
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $supervisor = $nombre ." " .$apellido;
  }
  include('../includes/header.php');
?>
<!-- MESSAGES -->
  <?php
    if ($_SESSION['card'] == 1) { ?>
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
          <?php switch($_SESSION['color_toast'])
            {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
            case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
            case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
          ?>
          <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
      </div>
    </div>
  <?php $_SESSION['card'] = 0; } ?>
  <script>
    $(document).ready(function(){
      $('.toast').toast('show');
    });
  </script>
<!-- MESSAGES -->
<!-- FECHA -->
  <?php
    $mes = date ('Y-m', strtotime('-0 month'));
    if(isset($_GET['mes']))
    {
      $desencriptado = $_GET['mes'];
      $mes = base64_decode($desencriptado);
    }

    $b = explode("-", $mes);
    switch ($b[1])
    {
      case '12': $mes_nom = "Diciembre";
      break;
      case '11': $mes_nom = "Noviembre";
      break;
      case '10': $mes_nom = "Octubre";
      break;
      case '09': $mes_nom = "Septiembre";
      break;
      case '08': $mes_nom = "Agosto";
      break;
      case '07': $mes_nom = "Julio";
      break;
      case '06': $mes_nom = "Junio";
      break;
      case '05': $mes_nom = "Mayo";
      break;
      case '04': $mes_nom = "Abril";
      break;
      case '03': $mes_nom = "Marzo";
      break;
      case '02': $mes_nom = "Febrero";
      break;
      case '01': $mes_nom = "Enero";
      break;
    }
  ?>
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/auditorias2.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/auditorias2.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="row justify-content-center p-1 pr-3">
            <a class="btn btn-info m-4" href="../Basico/auditorias_instalaciones2.php" role="button">Instalaciones <i class="fas fa-camera"></i></a>
          </div>
          <div class="row justify-content-center p-1 pr-3">
            <a class="btn btn-primary m-4" href="../Basico/auditorias_vehiculo2.php" role="button">Vehiculos <i class="fas fa-camera"></i></a>
          </div>
        </div>
      </div>

      <?php if ($tipo_us == 'Supervisor'){ ?> 
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <div class="card card-body">
              <form action="../Guardar/save_auditorias2.php" method="POST" enctype="multipart/form-data">
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
                    <input type="date" name="fecha" class="form-control" required>
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

                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label for="customRadioInline1">Subir 1° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                    </div>
                  </div>

                  <img id="mostrarImagen1" width="50%" height="50%"/>

                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label for="customRadioInline1">Subir 2° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                    </div>
                  </div>

                  <img id="mostrarImagen2" width="50%" height="50%"/>

                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label for="customRadioInline1">Subir 3° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                    </div>
                  </div>

                  <img id="mostrarImagen3" width="50%" height="50%"/>

                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label for="customRadioInline1">Subir 4° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                    </div>
                  </div>

                  <img id="mostrarImagen4" width="50%" height="50%"/>

                  <script type="text/javascript">
                    function previewImage(nb) {        
                        var reader = new FileReader();         
                        reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                        reader.onload = function (e) {             
                            document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                        };     
                    }
                  </script>
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

      <!-----VISTA ADMINISTRADOR---->
        <?php if ($tipo_us == 'Administrador' OR $tipo_us == 'Despacho'){ ?>
          <br>

          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <a class="btn btn-info" href="../Basico/auditoriasanalisis.php" role="button">Ver analisis</a>
            </div>
          </div>

          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <a class="btn btn-info" href="../BaseDatos/dtauditoria.php" role="button">Ver todas las auditorias de herramientas</a>
            </div>
          </div>

          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <p class="h4 mb-4 text-center">Auditorias vista de <?php echo $tipo_us; ?> </p>
              <table id="auditorias_1" class="table table-responsive table-striped table-bordered table-sm">
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
                    <th>Fotos</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <?php
                    $query = "SELECT * FROM auditoria WHERE fecha LIKE '%$mes%' ORDER BY id desc LIMIT 30";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result))
                    { 
                      $imagen1 = $row['imagenpri'];
                      $imagen2 = $row['imagenseg'];
                      $imagen3 = $row['imagenter'];
                      $imagen4 = $row['imagencuar'];
                      if($imagen1 == "")
                      {
                        $img1 = 0;
                      }
                      else
                      {
                        $img1 = 1;
                      }
                      if($imagen2 == "")
                      {
                        $img2 = 0;
                      }
                      else
                      {
                        $img2 = 1;
                      }
                      if($imagen3 == "")
                      {
                        $img3 = 0;
                      }
                      else
                      {
                        $img3 = 1;
                      }
                      if($imagen4 == "")
                      {
                        $img4 = 0;
                      }
                      else
                      {
                        $img4 = 1;
                      }
                  ?>
                    <tr>
                      <td>
                        <a href="../Ver/ver_auditoria.php?id=<?php echo $row['id']?>">
                          <i class="far fa-eye p-2 text-info"></i>
                        </a>
                        <a href="../Borrar/delete_auditoria.php?id=<?php echo $row['id']?>">
                          <i class="far fa-trash-alt text-danger p-2"></i>
                        </a>
                      </td>
                      <td><?php echo $row['supervisor']; ?></td>
                      <td><?php echo Fecha2($row['fecha_relevo']); ?></td>
                      <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                      <td><?php echo Fecha7($row['fecha']); ?></td>
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
                      <td><?php $fotos = $img1 + $img2 + $img3 + $img4; echo $fotos; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

        <?php } else {  ?>
      <!-----VISTA SUPERVISOR---->
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Auditorias de <?php echo $supervisor; ?> </p>
            <table id="auditorias" class="table table-responsive table-striped table-bordered table-sm">
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
                  $result = mysqli_query($conn, "SELECT * FROM auditoria WHERE supervisor = '$supervisor' AND fecha LIKE '%$mes%' ORDER BY fecha_relevo desc LIMIT 60");
                  while($row = mysqli_fetch_assoc($result))
                  {
                ?>
                  <tr>
                    <td>
                      <a href="../Editar/edit_auditoria.php?id=<?php echo $row['id']?>">
                        <i class="fas fa-pen p-2"></i>
                      </a>
                    </td>
                    <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                    <td><?php echo Fecha7($row['fecha']); ?></td>
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
        <?php } ?>
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
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
  <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#auditorias').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "scrollY":        "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "lengthMenu":     "Mostrar _MENU_ bajas por pagina...",
            "zeroRecords":    "No se encontro ninguna baja",
            "info":           "",
            "infoEmpty":      "No hay bajas disponibles",
            "infoFiltered":   "filtrado entre _MAX_ bajas",
            "loadingRecords": "Cargando...",
            },
            "ordering": false
        } );
    } );
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#auditorias_1').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "scrollY":        "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "lengthMenu":     "Mostrar _MENU_ bajas por pagina...",
            "zeroRecords":    "No se encontro ninguna baja",
            "info":           "",
            "infoEmpty":      "No hay bajas disponibles",
            "infoFiltered":   "filtrado entre _MAX_ bajas",
            "loadingRecords": "Cargando...",
            },
            "ordering": false
        } );
    } );
  </script>
</body>
</html>