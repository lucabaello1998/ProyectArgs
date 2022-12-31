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
          <input type="hidden" name="link" value="../Basico/auditorias_vehiculo2.php">
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
          <input type="hidden" name="link" value="../Basico/auditorias_vehiculo2.php">
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
            <a class="btn btn-success m-4" href="../Basico/auditorias2.php" role="button">Herramientas <i class="fas fa-camera"></i></a>
          </div>
        </div>
      </div>

      <?php if ($tipo_us == 'Supervisor'){ ?> 
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <div class="card card-body">
              <form action="../Guardar/save_auditorias_vehiculo2.php" method="POST" enctype="multipart/form-data">
                <p class="h4 mb-4 text-center">Auditoria de vehiculos</p>
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

                  <p class="h4 mb-4 text-center">Datos del vehiculo</p>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Dominio</b></label >
                    <div class="form-row align-items-center">                  
                        <input type="text" maxlength="255" name="dv_dominio" class="form-control" autofocus>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Color</b></label >
                    <div class="form-row align-items-center">                  
                        <input type="text" maxlength="255" name="dv_color" class="form-control" autofocus>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Modelo</b></label >
                    <div class="form-row align-items-center">                  
                        <input type="text" maxlength="255" name="dv_modelo" class="form-control" autofocus>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cedula</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Chasis</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Criquet</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Llave cruz</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Matafuego</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Motor</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Rueda de auxilio</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  </div>





                <div class="card card-body border-warning">

                  <p class="h4 mb-4 text-center">Instrumental</p>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Aire</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Bocina</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Calefaccion</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Encendedor</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Giro delantero lado acompañante</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Giro delantero lado conductor</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Giro trasero lado acompañante</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Giro trasero lado conductor</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Limpiaparabrisa</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Luces altas</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Luces bajas</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Luces de freno</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Sapito</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Stereo</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Tapa fusilera</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Medidor temperatura</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Medidor velocimetro</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Llave</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  </div>




                <div class="card card-body border-primary">

                <p class="h4 mb-4 text-center">Torpedo</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manijas de giro</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manijas de luces</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Pulsadores</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Rejilla ventilacion</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>            

                </div>




                <div class="card card-body border-info">

                <p class="h4 mb-4 text-center">Exterior frente</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Capot</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Parabrisa</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Parrilla</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Portaescalera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>         
                  </div>         

                </div>





                <div class="card card-body border-warning">

                <p class="h4 mb-4 text-center">Exterior trasero</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Baul</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Caño escape</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Luneta</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>         

                </div>







                <div class="card card-body border-success">

                <p class="h4 mb-4 text-center">Interior lado acompañante</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                </div>






                <div class="card card-body border-danger">

                <p class="h4 mb-4 text-center">Interior lado conductor</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                </div>









                <div class="card card-body border-success">

                <p class="h4 mb-4 text-center">Exterior lado acompañante</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Higuiene interior</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Higuiene exterior</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>    

                </div>
















                <div class="card card-body border-danger">

                <p class="h4 mb-4 text-center">Exterior lado conductor</p>


                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Espejo retrovisor</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>  

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div> 

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Tapa del tanque</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="card card-body">
                    <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                    <div class="form-row align-items-center">
                        <div class="form-group col-xs-2">
                          <legend class="col-form-label col">Estado</legend>
                        </div>
                        <div class="form-group col-xs-10">
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                          </div>
                          <div class="form-check custom-control-inline">
                            <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="MAL">
                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                          </div>
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
                    <label for="exampleFormControlSelect1"><b>Observaciones (Max 1000 caracteres)</b></label >
                    <textarea type="text" name="obs" maxlength="1000" class="form-control" placeholder="Ingrese una observacion"></textarea>
                  </div> 
                
                <br>
                <input type="submit" name="save_auditoria_vehiculo" class="btn btn-success btn-block" value="Guardar auditoria">
              </form>
            </div>
          </div>
        </div>
      <?php } ?>

      <style>
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
      <?php if ($tipo_us == 'Administrador' OR $tipo_us == 'Despacho'){ ?>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">         
          <a class="btn btn-success" href="../Basico/auditoriasanalisis.php" role="button">Ver analisis</a>        
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-info" href="../BaseDatos/dtauditoria_vehiculo.php" role="button">Ver todas las auditorias de vehiculos</a>
        </div>
      </div>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Auditorias vehiculo vista de <?php echo $tipo_us; ?></p>
          <table id="auditorias_1" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th colspan="5">Auditoria</th>
                <th colspan="11" class="bg-info">Datos</th>
                <th colspan="19" class="bg-warning text-dark">Instrumental</th>
                <th colspan="4" class="bg-primary">Torpedo</th>
                <th colspan="8" class="bg-info">Exterior frente</th>
                <th colspan="8" class="bg-warning text-dark">Exterior trasero</th>
                <th colspan="19" class="bg-success">Interior lado conductor</th>
                <th colspan="19" class="bg-danger">Interior lado acompañante</th>
                <th colspan="11" class="bg-success">Exterior lado conductor</th>
                <th colspan="11" class="bg-danger">Exterior lado acompañante</th>
                <th colspan="1" class="bg-dark"></th>
              </tr>
              <tr>
                <th>Acciones</th>
                <th>Supervisor</th>
                <th>Fecha auditoria</th>
                <th class="sticky pl-0">Tecnico</th>
                <th>Fecha</th>
                <th class="bg-info">Dominio</th>
                <th class="bg-info">Modelo</th>              
                <th class="bg-info">Color</th>
                <th class="bg-info">Motor</th>
                <th class="bg-info">Cedula</th>
                <th class="bg-info">Auxilio</th>
                <th class="bg-info">Criquet</th>
                <th class="bg-info">Llave Cruz</th>
                <th class="bg-info">Balizas</th>
                <th class="bg-info">Chasis</th>
                <th class="bg-info">Matafuego</th>
                <th class="bg-warning text-dark">Aire</th>
                <th class="bg-warning text-dark">Balizas</th>
                <th class="bg-warning text-dark">Bocina</th>
                <th class="bg-warning text-dark">Calefaccion</th>
                <th class="bg-warning text-dark">Encendedor</th>
                <th class="bg-warning text-dark">Giro delantero acomp</th>
                <th class="bg-warning text-dark">Giro delantero conduc</th>
                <th class="bg-warning text-dark">Giro trasero acomp</th>
                <th class="bg-warning text-dark">Giro trasero acomp</th>
                <th class="bg-warning text-dark">Limpia parabrisas</th>
                <th class="bg-warning text-dark">Luz alta</th>
                <th class="bg-warning text-dark">Luz baja</th>
                <th class="bg-warning text-dark">Luz de freno</th>
                <th class="bg-warning text-dark">Sapito</th>
                <th class="bg-warning text-dark">Stereo</th>
                <th class="bg-warning text-dark">Tapa de fusilera</th>
                <th class="bg-warning text-dark">Medidor temperatura</th>
                <th class="bg-warning text-dark">Medidor velocimetro</th>
                <th class="bg-warning text-dark">Llave</th>
                <th class="bg-primary">Manija giro</th>
                <th class="bg-primary">Manija luces</th>
                <th class="bg-primary">Pulsadores</th>
                <th class="bg-primary">Rejilla ventilacion</th>
                <th class="bg-info">Capot</th>
                <th class="bg-info">Cubiertas</th>
                <th class="bg-info">Llantas</th>
                <th class="bg-info">Opticas</th>
                <th class="bg-info">Parabrisas</th>
                <th class="bg-info">Paragolpe</th>
                <th class="bg-info">Parrilla</th>
                <th class="bg-info">Portaescalera</th>
                <th class="bg-warning">Baul</th>
                <th class="bg-warning">Caño de escape</th>
                <th class="bg-warning">Cerradura</th>
                <th class="bg-warning">Cubiertas</th>
                <th class="bg-warning">Llantas</th>
                <th class="bg-warning">Luneta</th>
                <th class="bg-warning">Opticas</th>
                <th class="bg-warning">Paragolpe</th>
                <th class="bg-success">Alfombra delantera</th>
                <th class="bg-success">Alfombra trasera</th>
                <th class="bg-success">Apoya brazo delantero</th>
                <th class="bg-success">Apoya brazo trasero</th>
                <th class="bg-success">Butaca delantera</th>
                <th class="bg-success">Butaca trasera</th>
                <th class="bg-success">Cerradura delantera</th>
                <th class="bg-success">Cerradura trasera</th>
                <th class="bg-success">Manija puerta delantera</th>
                <th class="bg-success">Manija puerta trasera</th>
                <th class="bg-success">Manija ventanilla delantera</th>
                <th class="bg-success">Manija ventanilla trasera</th>
                <th class="bg-success">Panel puerta delantera</th>
                <th class="bg-success">Panel puerta trasera</th>
                <th class="bg-success">Panel techo</th>
                <th class="bg-success">Polarizado delantero</th>
                <th class="bg-success">Polarizado trasero</th>
                <th class="bg-success">Seguro puerta delantera</th>
                <th class="bg-success">Seguro puerta trasera</th>
                <th class="bg-danger">Alfombra delantera</th>
                <th class="bg-danger">Alfombra trasera</th>
                <th class="bg-danger">Apoya brazo delantero</th>
                <th class="bg-danger">Apoya brazo trasero</th>
                <th class="bg-danger">Butaca delantera</th>
                <th class="bg-danger">Butaca trasera</th>
                <th class="bg-danger">Cerradura delantera</th>
                <th class="bg-danger">Cerradura trasera</th>
                <th class="bg-danger">Manija puerta delantera</th>
                <th class="bg-danger">Manija puerta trasera</th>
                <th class="bg-danger">Manija ventanilla delantera</th>
                <th class="bg-danger">Manija ventanilla trasera</th>
                <th class="bg-danger">Panel puerta delantera</th>
                <th class="bg-danger">Panel puerta trasera</th>
                <th class="bg-danger">Panel techo</th>
                <th class="bg-danger">Polarizado delantero</th>
                <th class="bg-danger">Polarizado trasero</th>
                <th class="bg-danger">Seguro puerta delantera</th>
                <th class="bg-danger">Seguro puerta trasera</th>
                <th class="bg-success">Bagueta delantera</th>
                <th class="bg-success">Bagueta trasera</th>
                <th class="bg-success">Cerradura delantera</th>
                <th class="bg-success">Cerradura trasera</th>
                <th class="bg-success">Espejo lateral</th>
                <th class="bg-success">Espejo retrovisor</th>
                <th class="bg-success">Manija puerta delantera</th>
                <th class="bg-success">Manija puerta trasera</th>
                <th class="bg-success">Tapa del tanque</th>
                <th class="bg-success">Ventanilla delantera</th>
                <th class="bg-success">Ventanilla trasera</th>              
                <th class="bg-danger">Bagueta delantera</th>
                <th class="bg-danger">Bagueta trasera</th>
                <th class="bg-danger">Cerradura delantera</th>
                <th class="bg-danger">Cerradura trasera</th>
                <th class="bg-danger">Espejo lateral</th>
                <th class="bg-danger">Manija puerta delantera</th>
                <th class="bg-danger">Manija puerta trasera</th>
                <th class="bg-danger">Ventanilla delantera</th>
                <th class="bg-danger">Ventanilla trasera</th>
                <th class="bg-danger">Higiene interior</th>
                <th class="bg-danger">Higiene exterior</th>
                <th>Observaciones</th>
                <th>Fotos</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
              $query = "SELECT * FROM auditoria_vehiculo WHERE fecha LIKE '%$mes%' ORDER BY id desc LIMIT 60";
              $result = mysqli_query($conn, $query);
              while($row = mysqli_fetch_assoc($result)) {
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
                    <a href="../Ver/ver_auditoria_vehiculos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-eye p-2"></i>
                    </a>
                    <a href="../Editar/edit_auditoria_vehiculo.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_auditoria_vehiculo.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['supervisor']; ?></td>
                  <td><?php echo $row['fecha_relevo']; ?></td>
                  <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['fecha']; ?></td>
                  <td><?php echo $row['dv_dominio']; ?></td>
                  <td><?php echo $row['dv_modelo']; ?></td>
                  <td><?php echo $row['dv_color']; ?></td>
                  <td><?php if ($row['dv_motor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_motor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_cedula'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_cedula'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_auxilio'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_auxilio'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_criquet'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_criquet'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_llave_cruz'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_llave_cruz'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_balizas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_balizas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>   
                  <td><?php if ($row['dv_chasis'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_chasis'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['dv_matafuego'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['dv_matafuego'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>  
                  <td><?php if ($row['i_aire'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_aire'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_balizas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_balizas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_bocina'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_bocina'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_calefaccion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_calefaccion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_encendedor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_encendedor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_giro_del_acom'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_giro_del_acom'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_giro_del_conductor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_giro_del_conductor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_giro_tras_acom'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_giro_tras_acom'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_giro_tras_conductor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_giro_tras_conductor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_limpiaparabrisa'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_limpiaparabrisa'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_luz_alta'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_luz_alta'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                  <td><?php if ($row['i_luz_baja'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_luz_baja'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_luz_freno'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_luz_freno'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_sapito'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_sapito'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_stereo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_stereo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_tapa_fusilera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_tapa_fusilera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_temperatura'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_temperatura'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_velocimetro'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_velocimetro'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['i_llave'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['i_llave'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['tor_manijas_giro'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['tor_manijas_giro'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['tor_manijas_luces'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['tor_manijas_luces'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['tor_pulsadores'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['tor_pulsadores'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['tor_rejilla_ventilacion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['tor_rejilla_ventilacion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                  <td><?php if ($row['extfre_capot'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_capot'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_cubiertas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_cubiertas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_llantas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_llantas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_opticas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_opticas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_parabrisas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_parabrisas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_paragolpe'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_paragolpe'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                  <td><?php if ($row['extfre_parrilla'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_parrilla'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extfre_portaescalera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extfre_portaescalera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_baul'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_baul'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_cano_esc'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_cano_esc'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_cerradura'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_cerradura'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_cubiertas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_cubiertas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_llantas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_llantas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_luneta'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_luneta'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_opticas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_opticas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['exttras_paragolpe'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['exttras_paragolpe'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_alfombra_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_alfombra_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_alfombra_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_alfombra_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_apoya_brazo_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_apoya_brazo_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_apoya_brazo_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_apoya_brazo_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_butaca_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_butaca_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_butaca_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_butaca_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_manija_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_manija_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_manija_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_manija_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_panel_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_panel_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_panel_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_panel_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_panel_techo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_panel_techo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_polarizado_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_polarizado_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_polarizado_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_polarizado_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_seguro_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_seguro_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intcond_seguro_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intcond_seguro_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_alfombra_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_alfombra_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_alfombra_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_alfombra_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_apoya_brazo_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_apoya_brazo_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_apoya_brazo_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_apoya_brazo_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_butaca_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_butaca_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_butaca_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_butaca_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_manija_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_manija_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_manija_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_manija_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_panel_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_panel_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_panel_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_panel_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_panel_techo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_panel_techo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_polarizado_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_polarizado_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_polarizado_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_polarizado_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_seguro_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_seguro_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['intacom_seguro_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['intacom_seguro_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_bagueta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_bagueta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_bagueta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_bagueta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_espejo_lateral'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_espejo_lateral'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_espejo_retrovisor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_espejo_retrovisor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_tapa_tanque'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_tapa_tanque'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extcond_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extcond_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_bagueta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_bagueta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_bagueta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_bagueta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_espejo_lateral'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_espejo_lateral'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_higuiene_int'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_higuiene_int'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['extacom_higuiene_ext'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['extacom_higuiene_ext'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
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
              <p class="h4 mb-4 text-center">Auditorias vehiculo de <?php echo $supervisor; ?></p>
              <table id="auditorias" class="table table-responsive table-striped table-bordered table-sm">
                <thead class="thead-dark text-center">
                  <tr>
                    <th colspan="5">Auditoria</th>
                    <th colspan="11" class="bg-info">Datos</th>
                    <th colspan="19" class="bg-warning text-dark">Instrumental</th>
                    <th colspan="4" class="bg-primary">Torpedo</th>
                    <th colspan="8" class="bg-info">Exterior frente</th>
                    <th colspan="8" class="bg-warning text-dark">Exterior trasero</th>
                    <th colspan="19" class="bg-success">Interior lado conductor</th>
                    <th colspan="19" class="bg-danger">Interior lado acompañante</th>
                    <th colspan="11" class="bg-success">Exterior lado conductor</th>
                    <th colspan="11" class="bg-danger">Exterior lado acompañante</th>
                    <th colspan="1" class="bg-dark"></th>
                  </tr>
                  <tr>
                    <th>Acciones</th>
                    <th class="sticky pl-0">Tecnico</th>
                    <th>Fecha</th>
                    <th class="bg-info">Dominio</th>
                    <th class="bg-info">Modelo</th>              
                    <th class="bg-info">Color</th>
                    <th class="bg-info">Motor</th>
                    <th class="bg-info">Cedula</th>
                    <th class="bg-info">Auxilio</th>
                    <th class="bg-info">Criquet</th>
                    <th class="bg-info">Llave Cruz</th>
                    <th class="bg-info">Balizas</th>
                    <th class="bg-info">Chasis</th>
                    <th class="bg-info">Matafuego</th>
                    <th class="bg-warning text-dark">Aire</th>
                    <th class="bg-warning text-dark">Balizas</th>
                    <th class="bg-warning text-dark">Bocina</th>
                    <th class="bg-warning text-dark">Calefaccion</th>
                    <th class="bg-warning text-dark">Encendedor</th>
                    <th class="bg-warning text-dark">Giro delantero acomp</th>
                    <th class="bg-warning text-dark">Giro delantero conduc</th>
                    <th class="bg-warning text-dark">Giro trasero acomp</th>
                    <th class="bg-warning text-dark">Giro trasero acomp</th>
                    <th class="bg-warning text-dark">Limpia parabrisas</th>
                    <th class="bg-warning text-dark">Luz alta</th>
                    <th class="bg-warning text-dark">Luz baja</th>
                    <th class="bg-warning text-dark">Luz de freno</th>
                    <th class="bg-warning text-dark">Sapito</th>
                    <th class="bg-warning text-dark">Stereo</th>
                    <th class="bg-warning text-dark">Tapa de fusilera</th>
                    <th class="bg-warning text-dark">Medidor temperatura</th>
                    <th class="bg-warning text-dark">Medidor velocimetro</th>
                    <th class="bg-warning text-dark">Llave</th>
                    <th class="bg-primary">Manija giro</th>
                    <th class="bg-primary">Manija luces</th>
                    <th class="bg-primary">Pulsadores</th>
                    <th class="bg-primary">Rejilla ventilacion</th>
                    <th class="bg-info">Capot</th>
                    <th class="bg-info">Cubiertas</th>
                    <th class="bg-info">Llantas</th>
                    <th class="bg-info">Opticas</th>
                    <th class="bg-info">Parabrisas</th>
                    <th class="bg-info">Paragolpe</th>
                    <th class="bg-info">Parrilla</th>
                    <th class="bg-info">Portaescalera</th>
                    <th class="bg-warning">Baul</th>
                    <th class="bg-warning">Caño de escape</th>
                    <th class="bg-warning">Cerradura</th>
                    <th class="bg-warning">Cubiertas</th>
                    <th class="bg-warning">Llantas</th>
                    <th class="bg-warning">Luneta</th>
                    <th class="bg-warning">Opticas</th>
                    <th class="bg-warning">Paragolpe</th>
                    <th class="bg-success">Alfombra delantera</th>
                    <th class="bg-success">Alfombra trasera</th>
                    <th class="bg-success">Apoya brazo delantero</th>
                    <th class="bg-success">Apoya brazo trasero</th>
                    <th class="bg-success">Butaca delantera</th>
                    <th class="bg-success">Butaca trasera</th>
                    <th class="bg-success">Cerradura delantera</th>
                    <th class="bg-success">Cerradura trasera</th>
                    <th class="bg-success">Manija puerta delantera</th>
                    <th class="bg-success">Manija puerta trasera</th>
                    <th class="bg-success">Manija ventanilla delantera</th>
                    <th class="bg-success">Manija ventanilla trasera</th>
                    <th class="bg-success">Panel puerta delantera</th>
                    <th class="bg-success">Panel puerta trasera</th>
                    <th class="bg-success">Panel techo</th>
                    <th class="bg-success">Polarizado delantero</th>
                    <th class="bg-success">Polarizado trasero</th>
                    <th class="bg-success">Seguro puerta delantera</th>
                    <th class="bg-success">Seguro puerta trasera</th>
                    <th class="bg-danger">Alfombra delantera</th>
                    <th class="bg-danger">Alfombra trasera</th>
                    <th class="bg-danger">Apoya brazo delantero</th>
                    <th class="bg-danger">Apoya brazo trasero</th>
                    <th class="bg-danger">Butaca delantera</th>
                    <th class="bg-danger">Butaca trasera</th>
                    <th class="bg-danger">Cerradura delantera</th>
                    <th class="bg-danger">Cerradura trasera</th>
                    <th class="bg-danger">Manija puerta delantera</th>
                    <th class="bg-danger">Manija puerta trasera</th>
                    <th class="bg-danger">Manija ventanilla delantera</th>
                    <th class="bg-danger">Manija ventanilla trasera</th>
                    <th class="bg-danger">Panel puerta delantera</th>
                    <th class="bg-danger">Panel puerta trasera</th>
                    <th class="bg-danger">Panel techo</th>
                    <th class="bg-danger">Polarizado delantero</th>
                    <th class="bg-danger">Polarizado trasero</th>
                    <th class="bg-danger">Seguro puerta delantera</th>
                    <th class="bg-danger">Seguro puerta trasera</th>
                    <th class="bg-success">Bagueta delantera</th>
                    <th class="bg-success">Bagueta trasera</th>
                    <th class="bg-success">Cerradura delantera</th>
                    <th class="bg-success">Cerradura trasera</th>
                    <th class="bg-success">Espejo lateral</th>
                    <th class="bg-success">Espejo retrovisor</th>
                    <th class="bg-success">Manija puerta delantera</th>
                    <th class="bg-success">Manija puerta trasera</th>
                    <th class="bg-success">Tapa del tanque</th>
                    <th class="bg-success">Ventanilla delantera</th>
                    <th class="bg-success">Ventanilla trasera</th>              
                    <th class="bg-danger">Bagueta delantera</th>
                    <th class="bg-danger">Bagueta trasera</th>
                    <th class="bg-danger">Cerradura delantera</th>
                    <th class="bg-danger">Cerradura trasera</th>
                    <th class="bg-danger">Espejo lateral</th>
                    <th class="bg-danger">Manija puerta delantera</th>
                    <th class="bg-danger">Manija puerta trasera</th>
                    <th class="bg-danger">Ventanilla delantera</th>
                    <th class="bg-danger">Ventanilla trasera</th>
                    <th class="bg-danger">Higiene interior</th>
                    <th class="bg-danger">Higiene exterior</th>
                    <th>Observaciones</th>             
                  </tr>
                </thead>
                <tbody align="center">
                  <?php
                  $query = "SELECT * FROM auditoria_vehiculo WHERE supervisor = '$supervisor' AND fecha LIKE '%$mes%' ORDER BY id desc LIMIT 60";
                  $result = mysqli_query($conn, $query);
                  while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td>
                        <a href="../Editar/edit_auditoria_vehiculo.php?id=<?php echo $row['id']?>">
                          <i class="fas fa-pen p-2"></i>
                        </a>
                      </td>
                      <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                      <td><?php echo $row['fecha']; ?></td>
                      <td><?php echo $row['dv_dominio']; ?></td>
                      <td><?php echo $row['dv_modelo']; ?></td>
                      <td><?php echo $row['dv_color']; ?></td>
                      <td><?php if ($row['dv_motor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_motor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_cedula'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_cedula'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_auxilio'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_auxilio'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_criquet'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_criquet'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_llave_cruz'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_llave_cruz'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_balizas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_balizas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>   
                      <td><?php if ($row['dv_chasis'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_chasis'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['dv_matafuego'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['dv_matafuego'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>  
                      <td><?php if ($row['i_aire'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_aire'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_balizas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_balizas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_bocina'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_bocina'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_calefaccion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_calefaccion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_encendedor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_encendedor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_giro_del_acom'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_giro_del_acom'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_giro_del_conductor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_giro_del_conductor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_giro_tras_acom'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_giro_tras_acom'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_giro_tras_conductor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_giro_tras_conductor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_limpiaparabrisa'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_limpiaparabrisa'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_luz_alta'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_luz_alta'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                      <td><?php if ($row['i_luz_baja'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_luz_baja'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_luz_freno'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_luz_freno'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_sapito'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_sapito'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_stereo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_stereo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_tapa_fusilera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_tapa_fusilera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_temperatura'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_temperatura'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_velocimetro'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_velocimetro'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['i_llave'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['i_llave'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['tor_manijas_giro'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['tor_manijas_giro'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['tor_manijas_luces'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['tor_manijas_luces'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['tor_pulsadores'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['tor_pulsadores'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['tor_rejilla_ventilacion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['tor_rejilla_ventilacion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                      <td><?php if ($row['extfre_capot'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_capot'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_cubiertas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_cubiertas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_llantas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_llantas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_opticas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_opticas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_parabrisas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_parabrisas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_paragolpe'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_paragolpe'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                      <td><?php if ($row['extfre_parrilla'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_parrilla'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extfre_portaescalera'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extfre_portaescalera'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_baul'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_baul'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_cano_esc'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_cano_esc'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_cerradura'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_cerradura'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_cubiertas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_cubiertas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_llantas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_llantas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_luneta'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_luneta'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_opticas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_opticas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['exttras_paragolpe'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['exttras_paragolpe'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_alfombra_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_alfombra_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_alfombra_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_alfombra_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_apoya_brazo_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_apoya_brazo_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_apoya_brazo_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_apoya_brazo_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_butaca_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_butaca_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_butaca_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_butaca_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_manija_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_manija_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_manija_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_manija_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_panel_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_panel_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_panel_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_panel_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_panel_techo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_panel_techo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_polarizado_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_polarizado_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_polarizado_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_polarizado_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_seguro_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_seguro_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intcond_seguro_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intcond_seguro_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_alfombra_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_alfombra_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_alfombra_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_alfombra_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_apoya_brazo_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_apoya_brazo_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_apoya_brazo_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_apoya_brazo_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_butaca_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_butaca_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_butaca_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_butaca_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_manija_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_manija_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_manija_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_manija_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_panel_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_panel_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_panel_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_panel_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_panel_techo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_panel_techo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_polarizado_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_polarizado_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_polarizado_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_polarizado_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_seguro_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_seguro_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['intacom_seguro_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['intacom_seguro_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_bagueta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_bagueta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_bagueta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_bagueta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_espejo_lateral'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_espejo_lateral'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_espejo_retrovisor'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_espejo_retrovisor'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_tapa_tanque'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_tapa_tanque'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extcond_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extcond_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_bagueta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_bagueta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_bagueta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_bagueta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_cerradura_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_cerradura_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_cerradura_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_cerradura_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_espejo_lateral'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_espejo_lateral'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_manija_puerta_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_manija_puerta_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_manija_puerta_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_manija_puerta_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_ventanilla_del'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_ventanilla_del'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_ventanilla_tras'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_ventanilla_tras'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_higuiene_int'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_higuiene_int'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                      <td><?php if ($row['extacom_higuiene_ext'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                                if ($row['extacom_higuiene_ext'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>


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