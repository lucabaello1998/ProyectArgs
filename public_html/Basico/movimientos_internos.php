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
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
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
          <input type="hidden" name="link" value="../Basico/movimientos_internos.php">
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
          <input type="hidden" name="link" value="../Basico/movimientos_internos.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->

<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#movi">+</button> 
        </div>
      </div>
      <div class="modal fade" id="movi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" text-center>Carga de asistencias</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Guardar/save_asistencia_interna.php" method="POST">
                <div class="form-row">
                  <div class="form-group col-md-4 col-12">
                    <label>Usuario</label>
                    <select type="text" name="usuario" class="form-control" required>
                      <option selected disabled>Usuario...</option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM usuarios WHERE tipo_us <> 'ATC' ORDER BY nombre asc");
                        foreach ($ejecutar as $opciones):
                      ?>   
                        <option value="<?php echo $opciones['nombre'] . ' ' .$opciones['apellido']; ?>"><?php echo $opciones['nombre'] . ' ' .$opciones['apellido']; ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-12">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                  </div>
                  <div class="form-group col-md-4 col-12">
                    <label for="exampleFormControlSelect1">Dia</label >
                    <select type="text" name="dia" class="form-control" required>
                      <option selected disabled>Dia...</option>
                      <option value="Normal">Normal</option>
                      <option value="Ausente">Ausente</option>
                      <option value="Sabado">Sabado</option>
                      <option value="Feriado">Feriado</option>
                      <option value="Vacaciones">Vacaciones</option>
                      <option value="Licencia">Licencia</option>
                      <option value="Dia libre">Dia libre</option>
                      <option value="Suspension">Suspension</option>
                    </select>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col">
                    <label>Observaciones</label >
                    <textarea type="text" name="obs" class="form-control" placeholder="Ingrese observaciones" autofocus><?php echo $row['obs']; ?></textarea>
                  </div>
                </div>
                <input type="submit" name="nuevo" class="btn btn-success btn-block" value="Guardar asistencia">
              </form>
            </div>      
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Asistencia</p>
          <table class="table table-striped table-bordered table-md table-sm table-responsive" style="max-height: 40rem;">
            <thead class="thead-dark text-center">
              <tr>
                <th rowspan="2" class="border border-top-0 border-bottom-0 border-left-0 border-light">Quien</th>
                <?php
                  $a1 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY inicio ORDER BY inicio asc");    
                  while($row = mysqli_fetch_assoc($a1))
                  {
                    $fecha_num = Fecha11($row['inicio']);
                ?>
                  <th colspan="3" class="border border-top-0 border-left-0 border-light"><?php echo $fecha_num; ?></th>
                <?php } ?>
              </tr>
              <tr>
                <?php
                  $a2 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY inicio ORDER BY inicio asc");    
                  while($row = mysqli_fetch_assoc($a2))
                  {
                ?>
                  <th class="border border-top-0 border-bottom-0 border-left-0 border-light">Inicio</th>
                  <th class="border border-top-0 border-bottom-0 border-left-0 border-light">Fin</th>
                  <th class="border border-top-0 border-bottom-0 border-left-0 border-light">Horas</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody align="center">
                
              <?php
                $a3 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY quien ORDER BY quien asc");    
                while($row = mysqli_fetch_assoc($a3))
                {
                  $quien_as = $row['quien'];
              ?>
                <tr>
                  <td><?php echo $quien_as; ?></td>
                    <?php
                      
                      $a4 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY inicio ORDER BY inicio asc");    
                      while($row1 = mysqli_fetch_assoc($a4))
                      {
                        $fecha_as = $row1['inicio'];
                    ?>
                      <?php
                        $hora_inicio = '-';
                        $obs_inicio = '';
                        $a5 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien = '$quien_as' AND pag = '' AND inicio = '$fecha_as' AND movimiento = 'Inicio'");    
                        while($row2 = mysqli_fetch_assoc($a5))
                        {
                          $hora_inicio = Fecha13($row2['cuando']);
                          $hora_inicio_com = $row2['cuando'];
                          $obs_inicio = $row2['obs'];
                          $latitud_inicio = $row2['latitud'];
                          $longitud_inicio = $row2['longitud'];
                        }
                      ?>
                      <?php
                        $hora_fin = '-';
                        $obs_fin = '';
                        $a6 = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien = '$quien_as' AND pag = '' AND inicio = '$fecha_as' AND movimiento = 'Fin'");    
                        while($row3 = mysqli_fetch_assoc($a6))
                        {
                          $hora_fin = Fecha13($row3['cuando']);
                          $hora_fin_com = $row3['cuando'];
                          $obs_fin = $row3['obs'];
                          $latitud_fin = $row3['latitud'];
                          $longitud_fin = $row3['longitud'];
                        }
                      ?>
                      <?php
                        if($hora_fin !== '-' && $hora_inicio !== '-')
                        {
                          $datetime1 = date_create($hora_inicio_com);
                          $datetime2 = date_create($hora_fin_com);
                          $interval = date_diff($datetime1, $datetime2);
                          $hora_rest = $interval->format('%H:%I');
                          $clase = 'class="badge badge-pill badge-warning"';
                        }
                        else
                        {
                          $hora_rest = '-';
                          $clase = '';
                        }
                      ?>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo $obs_inicio; ?>"><a <?php if($latitud_inicio == '' || $latitud_inicio == 'No se obtuvo la coordenada'){echo '';}else {echo 'href="' ."https://maps.google.com/?q=" .$latitud_inicio ."," .$longitud_inicio .'"'; echo 'target="_blank"';}; ?> <?php if($hora_inicio !== '-'){echo 'class="badge badge-pill badge-success text-light"';}; ?>><?php echo $hora_inicio; ?></a></td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo $obs_fin; ?>"><a <?php if($latitud_fin == '' || $latitud_fin == 'No se obtuvo la coordenada'){echo '';}else {echo 'href="' ."https://maps.google.com/?q=" .$latitud_fin ."," .$longitud_fin .'"'; echo 'target="_blank"';}; ?><?php if($hora_fin !== '-'){echo 'class="badge badge-pill badge-info text-light"';}; ?>><?php echo $hora_fin; ?></a></td>
                        <td><span <?php echo $clase; ?>><?php echo $hora_rest; ?></span></td>
                    <?php } ?>
                  </tr>
              <?php } ?>  
                
            </tbody>
          </table>
        </div>
      </div>

        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Dias</p>
            <table class="table table-responsive table-striped table-bordered table-sm" style="height: 40rem">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Acciones</th>            
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Dia</th> 
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  $dias_asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio like '%$mes%' AND pag = '' ORDER BY inicio desc");   
                  while($row = mysqli_fetch_assoc($dias_asis))
                  {
                ?>
                  <tr> 
                    <td>
                    <a href="" data-toggle="modal" data-target="#edi_dia_<?php echo $row['token']; ?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <!-- Edicion -->
                      <div class="modal fade" id="edi_dia_<?php echo $row['token']; ?>" tabindex="-1" aria-labelledby="cambio_dia" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="cambio_dia"><?php echo $row['quien']; ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="../Guardar/save_asistencia_interna.php" method="POST">
                              <div class="modal-body">
    
                                <input type="hidden" name="token" value="<?php echo $row['token']; ?>">
                                <div class="form-row align-items-end">
                                  <div class="form-group col-md-6 col-12">
                                    <label>Cuando</label>
                                    <input type="text" class="form-control" value="<?php echo Fecha11($row['cuando']); ?>" readonly>
                                  </div>
                                  
                                  <div class="form-group col-md-6 col-12">
                                    <label for="exampleFormControlSelect1">Dia</label >
                                    <select type="text" name="dia" class="form-control" required>
                                      <option selected value="<?php echo $row['dia']; ?>"><?php echo $row['dia']; ?></option>
                                      <option value="Normal">Normal</option>
                                      <option value="Ausente">Ausente</option>
                                      <option value="Sabado">Sabado</option>
                                      <option value="Feriado">Feriado</option>
                                      <option value="Vacaciones">Vacaciones</option>
                                      <option value="Licencia">Licencia</option>
                                      <option value="Dia libre">Dia libre</option>
                                      <option value="Suspension">Suspension</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-row align-items-end">
                                  <div class="form-group col">
                                    <label>Observaciones</label >
                                    <textarea type="text" name="obs" class="form-control" placeholder="Ingrese observaciones" autofocus><?php echo $row['obs']; ?></textarea>
                                  </div>
                                </div>
    
                              </div>
                              <div class="modal-footer">
                                <input type="submit" name="edicion" class="btn btn-success btn-block" value="Actualizar movimiento">
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    <!-- Edicion -->
                    <?php if($nombre_us == 'Damian' && $apellido_us == 'Duarte') { ?>
                      <a href="../Borrar/delete_movimientos.php?token=<?php echo $row['token']?>">
                        <i class="far fa-trash-alt p-2"></i>
                      </a>
                    <?php } ?>
                    </td>               
                    <td><?php echo $row['quien']; ?></td>
                    <td><?php echo Fecha11($row['inicio']); ?></td>
                    <td>
                      <?php
                        switch($row['dia'])
                        {
                          case 'Normal': $clase_dia = 'class="badge badge-pill badge-success"';
                          break;
                          case 'Ausente': $clase_dia = 'class="badge badge-pill badge-danger"';
                          break;
                          case 'Sabado': $clase_dia = 'class="badge badge-pill badge-info"';
                          break;
                          case 'Feriado': $clase_dia = 'class="badge badge-pill badge-info"';
                          break;
                          case 'Vacaciones': $clase_dia = 'class="badge badge-pill badge-warning"';
                          break;
                          case 'Licencia': $clase_dia = 'class="badge badge-pill badge-warning"';
                          break;
                          case 'Dia libre': $clase_dia = 'class="badge badge-pill badge-secondary"';
                          break;
                          case 'Suspension': $clase_dia = 'class="badge badge-pill badge-secondary"';
                          break;
                        }
                        if($row['obs'] !== '')
                        {
                          $toltip = 'data-toggle="tooltip" data-placement="top" title="' .$row['obs'] .'"';
                        }
                        else
                        {
                          $toltip = '';
                        }
                      ?>
                        <span <?php echo $clase_dia .$toltip; ?>><?php echo $row['dia']; ?></span>
                    </td>   
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php if($nombre_us == 'Damian' && $apellido_us == 'Duarte') { ?>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <nav>
              <div class="nav justify-content-center nav-tabs" id="nav-tab" role="tablist">
                  <?php
                    $aaa = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY quien ORDER BY quien asc");
                    while($row = mysqli_fetch_assoc($aaa))
                    {
                      $usu = $row['quien'];
                      $usu_se = str_replace( " ", "", $usu );
                  ?>
                    <button class="nav-link" id="nav-<?php echo $usu_se; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $usu_se; ?>" type="button" role="tab" aria-controls="nav-<?php echo $usu_se; ?>" aria-selected="false"><?php echo $usu; ?></button>
                  <?php } ?>
                    <button class="nav-link" id="nav-hoy-tab" data-toggle="tab" data-target="#nav-hoy" type="button" role="tab" aria-controls="nav-hoy" aria-selected="false">Hoy</button>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <?php
                $aa = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us <> 'ATC' ORDER BY nombre asc");
                while($row = mysqli_fetch_assoc($aa))
                {
                  $usu1 = $row['nombre'] . ' ' .$row['apellido'];
                  $usu_se1 = $row['nombre'].$row['apellido'];
              ?>
                <div class="tab-pane fade" id="nav-<?php echo $usu_se1; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $usu_se1; ?>-tab">
                  <div class="row justify-content-center p-1">
                    <div class="col-auto">
                      <table class="table table-striped table-bordered table-md table-sm table-responsive" style="max-height: 40rem;">
                        <thead class="thead-dark text-center">
                          <tr>
                            <th>Acciones</th>
                            <th>Quien</th>
                            <th>Cuando</th>
                            <th>Movimiento</th>
                            <th>Pagina</th>
                            <th>Observaciones</th>
                          </tr>
                        </thead>
                        <tbody align="center">
                          <?php
                            $result_tasks = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$usu1' ORDER BY inicio desc LIMIT 80");    
                            while($row = mysqli_fetch_assoc($result_tasks))
                            {
                          ?>
                            <tr>
                              <td>
                                <a href="" data-toggle="modal" data-target="#edicion_<?php echo $row['token']; ?>">
                                  <i class="fa-regular fa-comment p-2"></i>
                                </a>
                                <!-- Edicion -->
                                  <div class="modal fade" id="edicion_<?php echo $row['token']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['quien']; ?></h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="../Guardar/save_asistencia_interna.php" method="POST">
                                          <div class="modal-body">
                
                                            <input type="hidden" name="token" value="<?php echo $row['token']; ?>">
                                            <div class="form-row align-items-end">
                                              <div class="form-group col-12">
                                                <label>Cuando</label>
                                                <input type="text" class="form-control" value="<?php echo $row['cuando']; ?>" readonly>
                                              </div>
                                              <input type="hidden" name="dia" value="<?php echo $row['dia']; ?>">
                                            </div>
                                            <div class="form-row align-items-end">
                                              <div class="form-group col-md-6 col-12">
                                                <label>Movimiento</label>
                                                <input type="text" class="form-control" value="<?php echo $row['movimiento']; ?>" readonly>
                                              </div>

                                              <div class="form-group col-md-6 col-12">
                                                <label>Pagina</label>
                                                <input type="text" class="form-control" value="<?php echo $row['pag']; ?>" readonly>
                                              </div>
                                            </div>

                                            <div class="form-row align-items-end">
                                              <div class="form-group col">
                                                <label>Observaciones</label >
                                                <textarea type="text" name="obs" class="form-control" placeholder="Ingrese observaciones" autofocus><?php echo $row['obs']; ?></textarea>
                                              </div>
                                            </div>
                
                                          </div>
                                          <div class="modal-footer">
                                            <input type="submit" name="edicion" class="btn btn-success btn-block" value="Actualizar movimiento">
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                <!-- Edicion -->
                                <a href="../Borrar/delete_movimientos.php?token=<?php echo $row['token']?>">
                                  <i class="far fa-trash-alt p-2"></i>
                                </a>
                              </td>
                              <td><?php echo $row['quien']; ?></td>
                              <td><?php echo Fecha12($row['cuando']); ?></td>
                              <td><span <?php if($row['movimiento'] == 'Inicio'){echo 'class="badge badge-pill badge-success"';}; if($row['movimiento'] == 'Fin'){echo 'class="badge badge-pill badge-info"';} ?>><?php echo $row['movimiento']; ?></span></td>
                              <td><?php echo $row['pag']; ?></td>
                              <td><?php echo $row['obs']; ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <div class="tab-pane fade" id="nav-hoy" role="tabpanel" aria-labelledby="nav-hoy-tab">
                <div class="row justify-content-center p-1">
                  <div class="col-auto">
                    <table class="table table-striped table-bordered table-md table-sm table-responsive" style="max-height: 40rem;">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>Acciones</th>
                          <th>Quien</th>
                          <th>Cuando</th>
                          <th>Movimiento</th>
                          <th>Pagina</th>
                          <th>Observaciones</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          $hoy_hoy = date ('Y-m-d', strtotime('-0 month'));
                          $result_tasks = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '$hoy_hoy%' ORDER BY cuando desc");    
                          while($row = mysqli_fetch_assoc($result_tasks))
                          {
                        ?>
                          <tr>
                            <td>
                              <a href="" data-toggle="modal" data-target="#edi_<?php echo $row['token']; ?>">
                                <i class="fas fa-pen p-2"></i>
                              </a>
                              <!-- Edicion -->
                                <div class="modal fade" id="edi_<?php echo $row['token']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['quien']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form action="../Guardar/save_asistencia_interna.php" method="POST">
                                        <div class="modal-body">
              
                                          <input type="hidden" name="token" value="<?php echo $row['token']; ?>">
                                          <div class="form-row align-items-end">
                                            <div class="form-group col-md-6 col-12">
                                              <label>Cuando</label>
                                              <input type="text" class="form-control" value="<?php echo $row['cuando']; ?>" readonly>
                                            </div>
                                            
                                            <div class="form-group col-md-6 col-12">
                                              <label for="exampleFormControlSelect1">Dia</label >
                                              <select type="text" name="dia" class="form-control" required>
                                                <option selected value="<?php echo $row['dia']; ?>"><?php echo $row['dia']; ?></option>
                                                <option value="Normal">Normal</option>
                                                <option value="Ausente">Ausente</option>
                                                <option value="Sabado">Sabado</option>
                                                <option value="Feriado">Feriado</option>
                                                <option value="Vacaciones">Vacaciones</option>
                                                <option value="Licencia">Licencia</option>
                                                <option value="Dia libre">Dia libre</option>
                                                <option value="Suspension">Suspension</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-row align-items-end">
                                            <div class="form-group col-md-6 col-12">
                                              <label>Movimiento</label>
                                              <input type="text" class="form-control" value="<?php echo $row['movimiento']; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-6 col-12">
                                              <label>Pagina</label>
                                              <input type="text" class="form-control" value="<?php echo $row['pag']; ?>" readonly>
                                            </div>
                                          </div>

                                          <div class="form-row align-items-end">
                                            <div class="form-group col">
                                              <label>Observaciones</label >
                                              <textarea type="text" name="obs" class="form-control" placeholder="Ingrese observaciones" autofocus><?php echo $row['obs']; ?></textarea>
                                            </div>
                                          </div>
              
                                        </div>
                                        <div class="modal-footer">
                                          <input type="submit" name="edicion" class="btn btn-success btn-block" value="Actualizar movimiento">
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              <!-- Edicion -->
                              <a href="../Borrar/delete_movimientos.php?token=<?php echo $row['token']?>">
                                <i class="far fa-trash-alt p-2"></i>
                              </a>
                            </td>
                            <td><?php echo $row['quien']; ?></td>
                            <td><?php echo Fecha13($row['cuando']); ?></td>
                            <td><span <?php if($row['movimiento'] == 'Inicio'){echo 'class="badge badge-pill badge-success"';}; if($row['movimiento'] == 'Fin'){echo 'class="badge badge-pill badge-info"';} ?>><?php echo $row['movimiento']; ?></span></td>
                            <td><?php echo $row['pag']; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs']; ?>"><?php echo limitar_cadena($row['obs'], 50); ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
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
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>